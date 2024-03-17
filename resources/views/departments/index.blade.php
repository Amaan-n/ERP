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

            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">List Of Departments</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('departments', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>Index</th>
                            <th>Name</th>
                            <th>Attachment</th>
                            <th>Description</th>
                            <th>Is Active?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($departments as $index => $department)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ !empty($department->name) ? $department->name : '-' }}</td>
                                <td>
                                    @if(isset($department) && !empty($department->attachment))
                                        <a href="{{ config('constants.s3.asset_url') . $department->attachment }}"
                                           target="_blank">
                                            <i class="fa fa-image"> </i>
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($department) && !empty($department->description))
                                        <span class="text-primary cursor-pointer"
                                              data-toggle="popover" data-placement="top"
                                              data-content="{{ $department->description }}">
                                            <i class="fa fa-paragraph"> </i>
                                        </span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>{!! prepare_active_button('departments', $department) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('departments', $department, $accesses_urls) !!}</td>
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
