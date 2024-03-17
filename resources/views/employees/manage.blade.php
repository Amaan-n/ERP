@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <?php
            $redirect_route = !empty($employee)
                ? route('employees.update', $employee->id)
                : route('employees.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="employee_form" id="employee_form" autocomplete="off">
                {{ csrf_field() }}

                <input type="hidden" name="group_id" value="2">

                @if(isset($employee))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{ $employee->id ?? 0 }}">
                    <input type="hidden" name="slug" value="{{ $employee->slug ?? '' }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($employee)
                                        ? 'Edit Employee - ' . '<span class="border-bottom border-dark">' . $employee->name . '</span>'
                                        : 'Create Employee' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('employees', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('employees.form')
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit"
                                class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            {!! isset($employee) ? 'Update Employee' : 'Create Employee' !!}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.employee_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required',
                    phone: {
                        required: true,
                        number: true,
                        maxlength: 10,
                        minlength: 8,
                        remote: {
                            url: '{{ route('validate.unique') }}',
                            method: 'post',
                            data: {
                                'table': 'users',
                                'field': 'phone',
                                'id': $(document).find('input[name="id"]').val()
                            }
                        }
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '{{ route('validate.unique') }}',
                            method: 'post',
                            data: {
                                'table': 'users',
                                'field': 'email',
                                'id': $(document).find('input[name="id"]').val()
                            }
                        }
                    },
                    picture: {
                        accept: "image/*"
                    },
                    confirm_password: {
                        equalTo: "#password"
                    }
                },
                messages: {
                    phone: {
                        remote: 'The phone has already been taken.'
                    },
                    email: {
                        remote: 'The email has already been taken.'
                    }
                }
            });
        });
    </script>
@stop
