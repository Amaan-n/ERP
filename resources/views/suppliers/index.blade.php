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
                        <h3 class="card-label">List Of Suppliers</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('suppliers', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>Index</th>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Attachment</th>
                            <th>Is Active?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suppliers as $index => $supplier)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ !empty($supplier->name) ? $supplier->name : '-' }}</td>
                                <td>{{ !empty($supplier->contact_person) ? $supplier->contact_person : '-' }}</td>
                                <td>{{ !empty($supplier->phone) ? $supplier->phone : '-' }}</td>
                                <td>{{ !empty($supplier->email) ? $supplier->email : '-' }}</td>
                                <td>
                                    @if(isset($supplier) && !empty($supplier->attachment))
                                        <a href="{{ config('constants.s3.asset_url') . $supplier->attachment }}"
                                           target="_blank">
                                            <i class="fa fa-image"> </i>
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>{!! prepare_active_button('suppliers', $supplier) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('suppliers', $supplier, $accesses_urls) !!}</td>
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
