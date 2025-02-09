@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
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
                        <h3 class="card-label">List Of Assets</h3>
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
                            <th>Name</th>
                            <th>Code</th>
                            <th>Is Active?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assets as $index => $asset)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ isset($asset->supplier) && !empty($asset->supplier->name) ? $asset->supplier->name : '' }}</td>
                                <td>{{ isset($asset->asset_model) && !empty($asset->asset_model->name) ? $asset->asset_model->name : '' }}</td>
                                <td>{{ !empty($asset->name) ? $asset->name : '-' }}</td>
                                <td>{{ !empty($asset->code) ? $asset->code : '-' }}</td>
                                <td>{!! prepare_active_button('assets', $asset) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('assets', $asset, $accesses_urls) !!}</td>
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
