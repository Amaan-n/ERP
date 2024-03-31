@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap py-3">
                            <div class="card-title">
                                <h3 class="card-label">Booking Detail</h3>
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
                                    <span class="font-weight-bold">{{__('locale.status')}}</span>
                                    <span
                                        class="text-secondary {{ $booking->status === 'canceled' ? 'label label-lg font-weight-bold label-light-danger label-inline' : 'label label-lg font-weight-bold label-light-success label-inline' }}">
                            {!! !empty($booking->status) ? ucwords($booking->status) : '-' !!}
                        </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">{{__('locale.invoice_amount')}}</span>
                                    <span class="text-secondary">
                            {{ 'KD ' . number_format((float)$booking->invoice_amount, 3, '.', '') }}
                        </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">{{__('locale.remaining_amount')}}</span>
                                    <span class="text-secondary">
                            {{ 'KD ' . number_format((float)$booking->remaining_amount, 3, '.', '') }}
                        </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">{{__('locale.notes')}}</span>
                                    <span class="text-secondary">
                            {{ $booking->notes }}
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
                                <h3 class="card-label">{{__('locale.booking_items')}}</h3>
                            </div>
                            @php $title = __('locale.remaining_amount').': <br><br> KD ' . number_format((float)$booking->remaining_amount, 3, '.', ''); @endphp
                            <div class="card-toolbar">
                                {{-- <button type="button" title="Addon" class="btn btn-outline-secondary add_services_from_detail mr-2"><i class="fa fa-plus"></i> {{__('locale.addons')}}</button> --}}
                                <div class="btn-toolbar" role="toolbar" aria-label="...">
                                    <div class="btn-group mr-2" role="group" aria-label="...">
                                        @if ($booking->status !== 'canceled' && $booking->remaining_amount > 0)
                                            <button type="button" title="Receive Payment"
                                                    class="btn btn-outline-secondary btn-icon receive_payment"
                                                    data-remaining-amount="{{$booking->remaining_amount}}"
                                                    data-title="{{$title}}" data-booking-slug="{{$booking->slug}}"
                                                    data-href="{{ route('pos.receive.payment')}}"><i
                                                    class="fa fa-money-bill-alt"></i></button>
                                        @endif
                                        @if ($booking->status !== 'canceled')
                                            <button type="button" title="Update Status"
                                                    class="btn btn-outline-secondary btn-icon update_status"
                                                    data-booking-slug="{{$booking->slug}}"
                                                    data-booking-status="{{$booking->status}}"
                                                    data-href="{{ route('pos.update_status')}}"><i
                                                    class="fa fa-sync"></i></button>
                                            <button type="button" title="Cancel Booking"
                                                    class="btn btn-outline-secondary btn-icon cancel_booking"
                                                    data-final-amount="{{($booking->final_amount - $booking->remaining_amount)}}"
                                                    data-booking-slug="{{$booking->invoice_number}}"
                                                    data-href="{{ route('pos.cancel_booking') }}"
                                                    data-password-href="{{ route('users.check_cancel_invoice_password')}}"
                                                    data-booking-id="{{$booking->id}}"><i class="fa fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                {!! prepare_header_html('pos', 'manage') !!}
                            </div>
                        </div>
                        <div class="card-body">
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

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{{__('locale.index')}}</th>
                                        <th>{{__('locale.type')}}</th>
                                        <th>{{__('locale.item')}}</th>
                                        <th>{{__('locale.unit_price')}}</th>
                                        <th>{{__('locale.quantity')}}</th>
                                        <th>{{__('locale.final_cost')}}</th>
                                        <th>{{__('locale.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(!empty($booking->items) && count($booking->items) > 0)
                                        @foreach($booking->items as $index => $booking_item)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>{{ ucwords(str_replace('_', ' ', $booking_item->itemable_type)) ?? '-' }}</td>
                                                <td>
                                                    {{ isset($booking_item->itemable) && (!empty($booking_item->itemable->name) || !empty($booking_item->itemable->code))
                                                        ? !empty($booking_item->itemable->name) ? $booking_item->itemable->name : $booking_item->itemable->code
                                                        : '' }}
                                                </td>
                                                <td>{{ number_format((float) $booking_item->per_item_cost, 3, '.', '') }}</td>
                                                <td>{{ number_format((float) $booking_item->quantity, 3, '.', '') }}</td>
                                                <td>{{ number_format((float) $booking_item->final_cost, 3, '.', '') }}</td>
                                                <td>
                                                    @if($is_root_user == 1 || in_array('bookings.edit_item', $accesses_urls))
                                                        <button class="btn btn-primary edit_service_button"
                                                                id="edit_service_button"
                                                                data-booking-item-id="{{$booking_item->id}}"
                                                                data-href="{{ route('bookings.edit_item')}}"><i
                                                                class="fas fa-pencil-alt"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix">&nbsp;</div>

                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap py-3">
                            <div class="card-title">
                                <h3 class="card-label">{{__('locale.booking_transactions')}}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{{__('locale.index')}}</th>
                                        <th>{{__('locale.action')}}</th>
                                        <th>{{__('locale.payment_type')}}</th>
                                        <th>{{__('locale.debit')}}</th>
                                        <th>{{__('locale.credit')}}</th>
                                        <th>{{__('locale.notes')}}</th>
                                        <th>{{__('locale.created_by')}}</th>
                                        <th>{{__('locale.date_and_time')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(!empty($booking->transactions) && count($booking->transactions) > 0)
                                        <?php $total_debit_amount = $total_credit_amount = 0; ?>

                                        @foreach($booking->transactions as $index => $booking_transaction)
                                            @if($booking_transaction->action !== 'booking')
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ ucwords($booking_transaction->action) ?? '-' }}</td>
                                                    <td>
                                                        @if($is_root_user == 1 || in_array('pos.update_payment_type', $accesses_urls))
                                                            <select name="transaction_payment_type"
                                                                    id="transaction_payment_type"
                                                                    class="transaction_payment_type form-control"
                                                                    data-id="{{$booking_transaction->id}}"
                                                                    data-url="{{ route('pos.update_payment_type') }}">
                                                                @foreach (\App\Providers\FormList::getPaymentTypes() as $payment_type)
                                                                    <option value="{{ $payment_type->id }}"
                                                                        {{ isset($booking_transaction->payment_type) && $booking_transaction->payment_type->id == $payment_type->id ? 'selected="selected"' : '' }}>
                                                                        {{ ucwords(str_replace(array('_', '-'), ' ', $payment_type->name)) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            {{$booking_transaction->payment_type->name}}
                                                        @endif
                                                    </td>

                                                    <td align="right">
                                                        @if($booking_transaction->type === 'debit')
                                                            {{ number_format((float) $booking_transaction->amount, 3, '.', '') }}
                                                            <?php $total_debit_amount += (float)$booking_transaction->amount; ?>
                                                        @else
                                                            {{ '0.000' }}
                                                        @endif
                                                    </td>
                                                    <td align="right">
                                                        @if($booking_transaction->type === 'credit')
                                                            {{ number_format((float) $booking_transaction->amount, 3, '.', '') }}
                                                            <?php $total_credit_amount += (float)$booking_transaction->amount; ?>
                                                        @else
                                                            {{ '0.000' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ isset($booking_transaction->notes) ? $booking_transaction->notes : '' }}</td>
                                                    <td>{{ isset($booking_transaction->created_by_user) ? $booking_transaction->created_by_user->name : '' }}</td>
                                                    <td>{{ $booking_transaction->created_at->tz('Asia/Kuwait')->format('d-m-Y h:i A') }}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        <tr class="font-weight-bold font-size-h6">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">{{ number_format((float) $total_debit_amount, 3, '.', '') }}</td>
                                            <td align="right">{{ number_format((float) $total_credit_amount, 3, '.', '') }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('bookings.popups.add_services')
            @include('bookings.popups.edit_service')
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
