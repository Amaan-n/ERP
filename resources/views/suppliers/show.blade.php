@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Supplier Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('suppliers', 'display', $supplier) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('suppliers', $supplier) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ isset($supplier) && !empty($supplier->name) ? $supplier->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Contact Person</strong><br>
                            {{ isset($supplier) && !empty($supplier->contact_person) ? $supplier->contact_person : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Phone</strong><br>
                            {{ isset($supplier) && !empty($supplier->phone) ? $supplier->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Email</strong><br>
                            {{ isset($supplier) && !empty($supplier->email) ? $supplier->email : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($supplier->created_by_user) && !empty($supplier->created_by_user) ? $supplier->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($supplier->updated_by_user) && !empty($supplier->updated_by_user) ? $supplier->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Description</strong><br>
                            {!! isset($supplier) && !empty($supplier->description) ? $supplier->description : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($supplier) && !empty($supplier->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $supplier->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-10x"></i>
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
