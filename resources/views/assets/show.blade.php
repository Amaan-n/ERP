@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">
                            Asset Detail
                            <span class="font-size-h6 ml-3 text-info">( {{ $asset->code }} )</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('assets', 'display', $asset->id) !!}
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
                            {{ isset($asset) && isset($asset->supplier) && !empty($asset->supplier->name) ? $asset->supplier->name : '' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Asset Model</strong><br>
                            {{ isset($asset) && isset($asset->asset_model) && !empty($asset->asset_model->name) ? $asset->asset_model->name : '' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Assigned To</strong><br>
                            @if(isset($asset) && !empty($asset->status) && $asset->status === 'allocated')
                                {{ isset($asset->allocation) && isset($asset->allocation->user) && !empty($asset->allocation->user->name)
                                        ? $asset->allocation->user->name
                                        : ''
                                }}
                            @else
                                Available (
                                <a href="{{ route('assets.allocation') }}" class="font-weight-bold">
                                    <i class="fa fa-plus text-primary fa-1x"> </i>
                                    Allocate
                                </a>
                                )
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ isset($asset) && !empty($asset->name) ? $asset->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Purchase Date</strong><br>
                            {{ isset($asset) && !empty($asset->purchase_date) ? \Carbon\Carbon::parse($asset->purchase_date)->format('dS F Y') : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Purchase Cost</strong><br>
                            {{ isset($asset) && !empty($asset->purchase_cost) ? $asset->purchase_cost : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Order Number</strong><br>
                            {{ isset($asset) && !empty($asset->order_number) ? $asset->order_number : '-' }}
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
                            {!! isset($asset) && !empty($asset->notes) ? $asset->notes : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($asset) && !empty($asset->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $asset->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-10x"> </i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>

                    @if(!empty($asset->parameters) && count($asset->parameters) > 0)
                        <div class="pb-5 mb-5">
                            <hr>
                            <p><strong>Asset Parameters</strong></p>

                            <div class="row">
                                @foreach($asset->parameters as $parameter_key => $parameter_value)
                                    <div class="col-md-3 mb-5">
                                        <strong>{{ !empty($parameter_value['key']) ? $parameter_value['key'] : 'Unknown' }}</strong><br>
                                        {{ !empty($parameter_value['value']) ? $parameter_value['value'] : '-' }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if(!empty($asset->transactions) && count($asset->transactions) > 0)
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">Activities</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="timeline timeline-5">
                            <div class="timeline-items">
                                @foreach($asset->transactions as $asset_transaction)
                                    <div class="timeline-item mb-5">
                                        <div class="timeline-media bg-light-primary">
                                            <span class="svg-icon-primary svg-icon-md">
                                                <i class="fa fa-arrow-circle-right"> </i>
                                            </span>
                                        </div>
                                        <div class="timeline-desc timeline-desc-light-primary">
                                            <span class="font-weight-bolder text-primary">
                                                {{ $asset_transaction->created_at->tz('Asia/Kolkata')->format('dS F, Y h:i A') }}
                                            </span>
                                            <p class="font-weight-normal text-dark-50 pb-2">
                                                @switch($asset_transaction->status)
                                                    @case('added')
                                                    <strong>
                                                        <span class="text-dark">
                                                            {{ isset($asset_transaction->added_by_user) && !empty($asset_transaction->added_by_user->name) ? $asset_transaction->added_by_user->name : '' }}
                                                        </span>
                                                        has added new asset
                                                    </strong>
                                                    @break

                                                    @case('allocated')
                                                    <strong>
                                                        <span class="text-dark">
                                                            {{ isset($asset_transaction->added_by_user) && !empty($asset_transaction->added_by_user->name) ? $asset_transaction->added_by_user->name : '' }}
                                                        </span>
                                                        has allocated asset code
                                                        <span class="text-dark">
                                                            {{ isset($asset_transaction->asset) && !empty($asset_transaction->asset->code) ? ' "' . $asset_transaction->asset->code . '" ' : '' }}
                                                        </span>
                                                        to
                                                        <span class="text-dark">
                                                            @if(isset($asset_transaction->user))
                                                                {{ $asset_transaction->user->name . ' ( ' . $asset_transaction->user->email . ' ) ' }}
                                                            @else
                                                                Unknown
                                                            @endif
                                                        </span>
                                                    </strong>
                                                    @break
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
