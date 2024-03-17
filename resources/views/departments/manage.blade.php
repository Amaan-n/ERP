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
            $redirect_route = !empty($department)
                ? route('departments.update', $department->id)
                : route('departments.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="department_form" id="department_form">
                {{ csrf_field() }}

                @if(isset($department))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{ $department->id ?? 0 }}">
                    <input type="hidden" name="slug" value="{{ $department->slug ?? '' }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($department)
                                        ? 'Edit Department - ' . '<span class="border-bottom border-dark">' . $department->name . '</span>'
                                        : 'Create Department' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('departments', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('departments.form')
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            {!! isset($department) ? 'Update Department' : 'Create Department' !!}
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
            $('.department_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required'
                }
            });
        });
    </script>
@stop
