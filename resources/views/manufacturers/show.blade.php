@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Manufacturer Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('manufacturers', 'display', $manufacturer) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('manufacturers', $manufacturer) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($manufacturer->name) ? $manufacturer->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Contact Person</strong><br>
                            {{ !empty($manufacturer->contact_person) ? $manufacturer->contact_person : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Phone</strong><br>
                            {{ !empty($manufacturer->phone) ? $manufacturer->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Email</strong><br>
                            {{ !empty($manufacturer->email) ? $manufacturer->email : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Description</strong><br>
                            {!! isset($manufacturer) && !empty($manufacturer->description) ? $manufacturer->description : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($manufacturer) && !empty($manufacturer->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $manufacturer->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-5x"></i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($manufacturer->created_by_user) && !empty($manufacturer->created_by_user) ? $manufacturer->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($manufacturer->updated_by_user) && !empty($manufacturer->updated_by_user) ? $manufacturer->updated_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created Date</strong><br>
                            {{ $manufacturer->created_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated Date</strong><br>
                            {{ $manufacturer->updated_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
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
