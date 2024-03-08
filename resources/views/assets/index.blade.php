@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Assets</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('assets', 'listing') !!}
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
                        @foreach($assets as $index => $asset)
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
