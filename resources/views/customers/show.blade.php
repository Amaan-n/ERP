@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Customer Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('customers', 'display', $customer) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Is Active</strong><br>
                            {!! prepare_active_button('customers', $customer) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($customer->name) ? $customer->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Phone</strong><br>
                            {{ !empty($customer->phone) ? $customer->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Email</strong><br>
                            {{ !empty($customer->email) ? $customer->email : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>About</strong><br>
                            {!! !empty($customer->about) ? $customer->about : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($customer->created_by_user) && !empty($customer->created_by_user) ? $customer->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($customer->updated_by_user) && !empty($customer->updated_by_user) ? $customer->updated_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created Date</strong><br>
                            {{ $customer->created_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated Date</strong><br>
                            {{ $customer->updated_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
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
