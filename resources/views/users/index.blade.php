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
