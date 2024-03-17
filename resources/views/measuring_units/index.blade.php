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

            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">List Of Measuring Units</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('measuring_units', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>Index</th>
                            <th>Name</th>
                            <th>Is Active?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($measuring_units as $index => $measuring_unit)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $measuring_unit->name ?? '-' }}</td>
                                <td>{!! prepare_active_button('measuring_units', $measuring_unit) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('measuring_units', $measuring_unit, $accesses_urls) !!}</td>
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
