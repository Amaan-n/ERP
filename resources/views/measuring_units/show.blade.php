@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Measuring Unit Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('measuring_units', 'display', $measuring_unit) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('measuring_units', $measuring_unit) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($measuring_unit->name) ? $measuring_unit->name : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <strong>Description</strong><br>
                            {{ !empty($measuring_unit->description) ? $measuring_unit->description : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($measuring_unit->created_by_user) && !empty($measuring_unit->created_by_user) ? $measuring_unit->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($measuring_unit->updated_by_user) && !empty($measuring_unit->updated_by_user) ? $measuring_unit->updated_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created Date</strong><br>
                            {{ $measuring_unit->created_at->tz('Asia/Kuwait')->format('dS M, Y h:i A') }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated Date</strong><br>
                            {{ $measuring_unit->updated_at->tz('Asia/Kuwait')->format('dS M, Y h:i A') }}
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
