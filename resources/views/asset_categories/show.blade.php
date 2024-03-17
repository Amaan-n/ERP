@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Asset Category Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('asset_categories', 'display', $asset_category) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('asset_categories', $asset_category) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($asset_category->name) ? $asset_category->name : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($asset_category) && !empty($asset_category->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $asset_category->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-5x"></i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <strong>Description</strong><br>
                            {{ !empty($asset_category->description) ? $asset_category->description : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($asset_category->created_by_user) && !empty($asset_category->created_by_user) ? $asset_category->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($asset_category->updated_by_user) && !empty($asset_category->updated_by_user) ? $asset_category->updated_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created Date</strong><br>
                            {{ $asset_category->created_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated Date</strong><br>
                            {{ $asset_category->updated_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
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
