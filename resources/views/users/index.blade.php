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

            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">List Of Users</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('users', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>Index</th>

                            @if($is_root_user == 1 || auth()->user()->group_id == 1)
                                <th>Group</th>
                            @endif

                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Is Active?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{ ++$index }}</td>

                                @if($is_root_user == 1 || auth()->user()->group_id == 1)
                                    <td>
                                        @if(isset($user->group_id) && $user->group_id > 0)
                                            <a href="{{ route('groups.show', [$user->group->slug]) }}"
                                               class="text-decoration-none text-primary text-hover-primary">
                                                <u>{{ isset($user->group) ? $user->group->name : '-' }}</u>
                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                @endif

                                <td>{{ !empty($user->name) ? $user->name : '-' }}</td>
                                <td>{{ !empty($user->email) ? $user->email : '-' }}</td>
                                <td>{{ !empty($user->phone) ? $user->phone : '-' }}</td>
                                <td>{!! prepare_active_button('users', $user) !!}</td>
                                <td nowrap="nowrap">
                                    @if($is_root_user == 1 || auth()->user()->group_id === 1)
                                        <a href="javascript:void(0);" class="reset_password"
                                           data-user-id="{{ $user->id }}">
                                            Reset Password
                                        </a>
                                        <span class="text-primary">&nbsp; | &nbsp;</span>
                                    @endif

                                    {!! prepare_listing_action_buttons('users', $user, $accesses_urls) !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade reset_password_modal" id="reset_password_modal" tabindex="-1" role="dialog"
         aria-labelledby="reset_password_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">

                <form action="{{ route('reset_password') }}" method="post"
                      enctype="multipart/form-data" class="reset_password_form" id="reset_password_form">
                    {{ csrf_field() }}

                    <input type="hidden" name="user_id" value="0">

                    <div class="modal-header">
                        <h5 class="modal-title">Reset Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"> </i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label" for="password">
                                        Password
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password"
                                           value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-5">
                        <button type="submit"
                                class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            Reset Password
                        </button>
                        <button type="button" class="btn btn-outline-secondary font-weight-bold font-size-lg"
                                data-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).off('click', '.reset_password');
            $(document).on('click', '.reset_password', function () {
                $(document).find('.reset_password_modal').modal('show');
                $(document).find('.reset_password_modal').find('input[name="user_id"]').val($(this).attr('data-user-id'))
            });

            $('.reset_password_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    password: 'required',
                }
            });
        });
    </script>
@stop
