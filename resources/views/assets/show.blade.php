@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">
                            Asset Detail
                            <span class="font-size-h6 ml-3 text-info">( {{ $asset->code }} )</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('assets', 'display', $asset) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('assets', $asset) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Supplier</strong><br>
                            {{ isset($asset->supplier) && !empty($asset->supplier->name) ? $asset->supplier->name : '' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Asset Model</strong><br>
                            {{ isset($asset->asset_model) && !empty($asset->asset_model->name) ? $asset->asset_model->name : '' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($asset->name) ? $asset->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Purchase Date</strong><br>
                            {{ !empty($asset->purchase_date) ? \Carbon\Carbon::parse($asset->purchase_date)->format('dS F Y') : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Purchase Cost</strong><br>
                            {{ !empty($asset->purchase_cost) ? $asset->purchase_cost : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Order Number</strong><br>
                            {{ !empty($asset->order_number) ? $asset->order_number : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($asset->created_by_user) && !empty($asset->created_by_user) ? $asset->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($asset->updated_by_user) && !empty($asset->updated_by_user) ? $asset->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Notes</strong><br>
                            {!! !empty($asset->notes) ? $asset->notes : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($asset) && !empty($asset->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $asset->attachment }}"
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

            @if(!empty($asset->parameters) && count($asset->parameters) > 0)
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">Asset Parameters</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($asset->parameters as $parameter_key => $parameter_value)
                                <div class="col-md-3 mb-5">
                                    <strong>{{ !empty($parameter_value['key']) ? $parameter_value['key'] : 'Unknown' }}</strong><br>
                                    {{ !empty($parameter_value['value']) ? $parameter_value['value'] : '-' }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
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
