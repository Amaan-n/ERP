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
                        <h3 class="card-label">List Of Asset Models</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('asset_models', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>Index</th>
                            <th>Manufacturer</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Is Active?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($asset_models as $index => $asset_model)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ isset($asset_model->manufacturer) && !empty($asset_model->manufacturer->name) ? $asset_model->manufacturer->name : '' }}</td>
                                <td>{{ isset($asset_model->category) && !empty($asset_model->category->name) ? $asset_model->category->name : '' }}</td>
                                <td>{{ !empty($asset_model->name) ? $asset_model->name : '-' }}</td>
                                <td>{!! prepare_active_button('asset_models', $asset_model) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('asset_models', $asset_model, $accesses_urls) !!}</td>
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
