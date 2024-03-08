@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
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
            $redirect_route = !empty($user)
                ? route('users.update', $user->id)
                : route('users.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="user_form" id="user_form">
                {{ csrf_field() }}
                @if(isset($user) && !empty($user))
                    <input type="hidden" name="_method" value="put">
                @endif

                <input type="hidden" name="id" class="user_id"
                       value="{{ isset($user) && isset($user->id) && $user->id > 0 ? $user->id : 0 }}">

                <input type="hidden" name="slug"
                       value="{{ isset($user) && !empty($user->slug) ? $user->slug : '' }}">

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($user)
                                        ? 'Edit User - ' . '<span class="border-bottom border-dark">' . $user->name . '</span>'
                                        : 'Create User' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('users', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('users.form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg">
                            Submit
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
            $('.user_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    group_id: 'required',
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
