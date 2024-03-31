@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div
                            class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap py-3">
                            <div class="card-title">
                                <h3 class="card-label">Booking Detail</h3>
                            </div>
                            <div class="card-toolbar">
                                @if ($is_root_user == 1 || in_array('pos.index', $accesses_urls))
                                    <a href="{{ route('pos.index') }}"
                                       class="btn btn-outline-dark font-weight-bold">
                                        <i class="fa fa-angle-double-left mr-1"></i>
                                        Back
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Invoice Number</span>
                                    <span class="text-secondary">
                                        {{ $booking->invoice_number ?? '-' }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Invoice Date</span>
                                    <span class="text-secondary">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('dS F Y') ?? '-' }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Customer</span>
                                    @if(isset($booking->customer))
                                        <a href="{{ route('customers.show', [$booking->customer->slug]) }}"
                                           class="text-primary">
                                            {{ $booking->customer->name ?? '-' }}
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Status</span>
                                    <span class="text-secondary">
                                        {!! !empty($booking->status) ? ucwords($booking->status) : '-' !!}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Invoice Amount</span>
                                    <span class="text-secondary">
                                        {{ 'KD ' . number_format((float)$booking->invoice_amount, 3, '.', '') }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Notes</span>
                                    <span class="text-secondary">
                                        {{ $booking->notes ?? '-' }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap py-3">
                            <div class="card-title">
                                <h3 class="card-label">Booking Items</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="bg-light">
                                        <th>Index</th>
                                        <th>Name</th>
                                        <th>Price Per Unit</th>
                                        <th>Quantity</th>
                                        <th>Final Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($booking->products) && count($booking->products) > 0)
                                        @foreach($booking->products as $index => $booking_product)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>
                                                    {{ isset($booking_product->product) && !empty($booking_product->product->name)
                                                        ? $booking_product->product->name
                                                        : '' }}
                                                </td>
                                                <td>{{ number_format((float) $booking_product->per_item_price, 3, '.', '') }}</td>
                                                <td>{{ number_format((float) $booking_product->quantity, 3, '.', '') }}</td>
                                                <td>{{ number_format((float) $booking_product->final_price, 3, '.', '') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No Record Found</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
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
