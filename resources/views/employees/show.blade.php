@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Employee Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('employees', 'display', $employee) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('employees', $employee) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($employee->name) ? $employee->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Phone</strong><br>
                            {{ !empty($employee->phone) ? $employee->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Email</strong><br>
                            {{ !empty($employee->phone) ? $employee->phone : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>About</strong><br>
                            {{ !empty($employee->about) ? $employee->about : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($employee->created_by_employee) && !empty($employee->created_by_employee) ? $employee->created_by_employee->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($employee->updated_by_employee) && !empty($employee->updated_by_employee) ? $employee->updated_by_employee->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created Date</strong><br>
                            {{ $employee->created_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated Date</strong><br>
                            {{ $employee->updated_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
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
