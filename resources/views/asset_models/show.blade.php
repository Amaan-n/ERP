@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Asset Model Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('asset_models', 'display', $asset_model) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('asset_models', $asset_model) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Manufacturer</strong><br>
                            {{ isset($asset_model) && isset($asset_model->manufacturer) && !empty($asset_model->manufacturer->name) ? $asset_model->manufacturer->name : '' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Category</strong><br>
                            {{ isset($asset_model) && isset($asset_model->category) && !empty($asset_model->category->name) ? $asset_model->category->name : '' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ isset($asset_model) && !empty($asset_model->name) ? $asset_model->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Model Number</strong><br>
                            {{ isset($asset_model) && !empty($asset_model->model_number) ? $asset_model->model_number : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($asset_model->created_by_user) && !empty($asset_model->created_by_user) ? $asset_model->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($asset_model->updated_by_user) && !empty($asset_model->updated_by_user) ? $asset_model->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Notes</strong><br>
                            {!! isset($asset_model) && !empty($asset_model->notes) ? $asset_model->notes : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($asset_model) && !empty($asset_model->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $asset_model->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-5x"></i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Assets</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>Index</th>
                            <th>Supplier</th>
                            <th>Asset Model</th>
                            <th>Category</th>
                            <th>Code</th>
                            <th>Assigned To</th>
                            <th>Is Active?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($asset_model->assets as $index => $asset)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ isset($asset) && isset($asset->supplier) && !empty($asset->supplier->name) ? $asset->supplier->name : '' }}</td>
                                <td>{{ isset($asset) && isset($asset->asset_model) && !empty($asset->asset_model->name) ? $asset->asset_model->name : '' }}</td>
                                <td>{{ isset($asset) && isset($asset->category) && !empty($asset->category->name) ? $asset->category->name : '' }}</td>
                                <td>{{ isset($asset) && !empty($asset->code) ? $asset->code : '-' }}</td>
                                <td>
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
                                </td>
                                <td>{!! prepare_active_button('assets', $asset) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('assets', $asset->id, $accesses_urls) !!}</td>
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
