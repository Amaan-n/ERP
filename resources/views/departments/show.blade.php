@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Department Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('departments', 'display', $department) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('departments', $department) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ isset($department) && !empty($department->name) ? $department->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($department->created_by_user) && !empty($department->created_by_user) ? $department->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($department->updated_by_user) && !empty($department->updated_by_user) ? $department->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Description</strong><br>
                            {!! isset($department) && !empty($department->description) ? $department->description : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($department) && !empty($department->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $department->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-5x"> </i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
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
