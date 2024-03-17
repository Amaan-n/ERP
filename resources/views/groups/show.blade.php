@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Group Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('groups', 'display', $group) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('groups', $group) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($group->name) ? $group->name : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Description</strong><br>
                            {{ !empty($group->description) ? $group->description : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($group->created_by_user) && !empty($group->created_by_user) ? $group->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($group->updated_by_user) && !empty($group->updated_by_user) ? $group->updated_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created Date</strong><br>
                            {{ $group->created_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated Date</strong><br>
                            {{ $group->updated_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">List Of Users - {{ $group->name }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>Index</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Is Active?</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($group->users as $index => $user)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ !empty($user->name) ? $user->name : '-' }}</td>
                                <td>{{ !empty($user->email) ? $user->email : '-' }}</td>
                                <td>{{ !empty($user->phone) ? $user->phone : '-' }}</td>
                                <td>{!! prepare_active_button('users', $user) !!}</td>
                                <td>{{ isset($user->created_by_user) && !empty($user->created_by_user) ? $user->created_by_user->name : 'System' }}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('users', $user, $accesses_urls) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
