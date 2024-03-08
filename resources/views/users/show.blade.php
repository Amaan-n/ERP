@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">User Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('users', 'display', $user) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('users', $user) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Group</strong><br>
                            @if(isset($user->group))
                                @if($is_root_user == 1 || in_array('groups.show', $accesses_urls))
                                    <a href="{{ route('groups.show', [$user->group->slug]) }}"
                                       class="text-decoration-none text-primary text-hover-primary border-bottom border-primary">
                                        {{ $user->group->name ?? '-' }}
                                    </a>
                                @else
                                    {{ $user->group->name ?? '-' }}
                                @endif
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($user->name) ? $user->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Phone</strong><br>
                            {{ !empty($user->phone) ? $user->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Email</strong><br>
                            {{ !empty($user->phone) ? $user->phone : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>About</strong><br>
                            {{ !empty($user->about) ? $user->about : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($user->created_by_user) && !empty($user->created_by_user) ? $user->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($user->updated_by_user) && !empty($user->updated_by_user) ? $user->updated_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created Date</strong><br>
                            {{ $user->created_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated Date</strong><br>
                            {{ $user->updated_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            //
        });
    </script>
@stop
