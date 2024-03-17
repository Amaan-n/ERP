<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $configuration['name'] }}</title>
    <style type="text/css">
        body {
            font-family: 'Poppins', Courier, monospace;
            font-size: 13px;
            border: 1px solid black;
            border-collapse: collapse;
            width: 80mm;
            height: 100%;
        }

        strong {
            font-weight: 600;
        }

        th {
            text-align: left;
            border-top: 0px solid hsl(0, 44%, 96%);
            border-bottom: 0px solid #f8f4f4;
        }

        tfoot td {
            border-top: 1px solid #9a9a9a;
            border-bottom: 1px solid #9a9a9a;
        }

        .content {
            font-family: 'Poppins', Courier, monospace
        }

        table, td {
            border: 0px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        .customer_details td {
            /*border: 1px solid black;*/
            font-size: 10px;
            font-weight: bold;
            width: 33%;
            text-align: center;
        }

        .items_particular thead td {
            height: 25px;
        }

        .items_particular td {
            border: 1px solid black;
            text-align: center;
            width: 33% !important;
        }

        .items_table td {
            border: 1px solid black;
        }

        @media print {
            body {
                font-family: 'Poppins', Courier, monospace;
                font-size: 14px;
                width: 80mm;
                height: 100%;
            }

            strong {
                font-weight: 600;
            }

            th {
                text-align: left;
                border-top: 0px solid #9a9a9a;
                border-bottom: 0px solid #9a9a9a;
            }

            tfoot td {
                border-top: 1px solid #9a9a9a;
                border-bottom: 1px solid #9a9a9a;
            }

            .content {
                font-family: 'Poppins', Courier, monospace
            }
        }
    </style>
</head>

<body>
<div class="content">
    <div class="page-content" style="padding: 0 30px;">
        @if(isset($booking->branch) && $booking->branch->is_name_print == 1)
            <div style=" text-align: center;">
                <h2 style="margin-block-start: 0;margin-block-end: 0;">
                    {{ !empty($booking->branch) ? $booking->branch->name : '-' }}
                </h2>
            </div>
            <div class="top-border" style="border-top: 2px dashed black;"></div>
        @endif

        <div class="card card-custom gutter-b">
            <div class="card-body">
                @if (!empty($configuration['actual_logo']) && !empty($configuration['name']))
                    <div style=" text-align: center;">
                        <img src="{{ config('constants.s3.asset_url') . $configuration['logo'] }}" style=" text-align: center;"
                            class="mx-auto d-block"
                            width="150"
                            alt="Sparkalz">
                    </div>
                @else
                    <h1>Sparkalz</h1>
                @endif
                @if($configuration['invoice_header_one'] || $configuration['invoice_header_two'])
                    <div style="font-size: 12px;text-align: center;font-weight: 500;">{{$configuration['invoice_header_one']}}</div>
                    <div style="font-size: 12px;text-align: center;font-weight: 500;">{{$configuration['invoice_header_two']}}</div>
                @endif
                @if($booking->status == 'canceled')
                    <div style="font-size: 16px;text-align: center;font-weight: 500;">{{__('locale.canceled_invoice')}}</div>
                @else
                    <div style="font-size: 16px;text-align: center;font-weight: 500;">{{__('locale.sales_invoice')}}</div>
                @endif
                
                <hr style="border-top: 2px dashed black;margin-block-start: 0;margin-block-end: 0.8em;">

                <table class="customer_details">
                    <tbody>
                    <tr>
                        <td>{{__('locale.invoice_no')}}</td>
                        <td>{{ !empty($booking->invoice_number) ? $booking->invoice_number : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.date')}}</td>
                        <td>{{ !empty($booking->created_at) ? \Carbon\Carbon::parse($booking->created_at)->tz('Asia/Kuwait')->format('d-m-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.time')}}</td>
                        <td>{{ !empty($booking->created_at) ? \Carbon\Carbon::parse($booking->created_at)->tz('Asia/Kuwait')->format('h:i A') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.customer')}}</td>
                        <td>{{ !empty($booking->customer) ? $booking->customer->name : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.mobile')}}</td>
                        <td>{{ !empty($booking->customer) ? $booking->customer->phone : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.created_by')}}</td>
                        <td>{{ !empty($booking->user) ? $booking->user->name : '-' }}</td>
                    </tr>
                    </tbody>
                </table>

                <div style="border-top: 2px dashed black;margin-block-start: 0.6em;margin-block-end: 0.6em;"></div>

                <table class="items_particular">
                    <thead>
                    <tr>
                        <td>{{__('locale.description')}}</td>
                        <td>{{__('locale.item_price')}}</td>
                        <td>{{__('locale.qty')}}</td>
                        <td>{{__('locale.price')}}</td>
                    </tr>
                    </thead>
                    <tbody>
                        @php 
                        $final_cost = 0;
                        @endphp
                    @if(!empty($booking->items) && count($booking->items) > 0)
                        @foreach($booking->items as $booking_item)
                        @php 
                            $parts = explode('\\', $booking_item->itemable_type);
                            $itemType = end($parts);
                            $voucher_code = (strtolower($itemType) == 'voucher') ? '(' . $booking_item->voucher_number . ')' : '';
                        @endphp
                            <tr>
                                <td style="font-size: 11px;font-weight: 500;padding-top: 0.25rem;">
                                    @if($booking_item->itemable)
                                        @php 
                                            $worker_names = [($config_locale == 'ar') ? ($booking_item->worker->a_name == null) ? $booking_item->worker->name : $booking_item->worker->a_name : $booking_item->worker->name];
                                            foreach ($booking_item->staff as $staff) {
                                                if(!in_array($staff->worker->name, $worker_names)){
                                                    $worker_names[] = ($config_locale == 'ar') ? ($staff->worker->a_name == null) ? $staff->worker->name : $staff->worker->a_name : $staff->worker->name;
                                                }
                                            }
                                            $worker_names_str = implode(', ', $worker_names);
                                        @endphp

                                        {{ (!empty($booking_item->itemable->name) || !empty($booking_item->itemable->code))
                                            ? (!empty($booking_item->itemable->name) ? ($config_locale == 'ar' && in_array(strtolower($itemType), ['service', 'product'])) ? ($booking_item->itemable->a_name ?? $booking_item->itemable->name) : $booking_item->itemable->name  : $booking_item->itemable->code) .'('. $worker_names_str .')' . $voucher_code
                                            : '' }}

                                        @if($booking_item->redeem_from_package_id > 0)
                                            <h6 style="color: red">{{__('locale.redeem_by_package')}}</h6>
                                        @endif
                                    @endif
                                </td>
                                <td style="font-size: 11px;font-weight: 500;padding-top: 0.25rem;">
                                    {{ $booking_item->per_item_cost ?? '0' }}
                                </td>
                                <td style="font-size: 11px;font-weight: 500;padding-top: 0.25rem;">
                                    {{ $booking_item->quantity ?? '0' }}
                                </td>
                                <td style="font-size: 11px;font-weight: 500;padding-top: 0.25rem;">
                                    @if($booking_item->redeem_from_package_id == 0)
                                    @php $final_cost+= $booking_item->final_cost; @endphp
                                    {{ number_format((float)$booking_item->final_cost, 3, '.', '') }}
                                    @else
                                    0.000
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                <div style="border-top: 2px dashed black;margin-block-start: 0.8em;margin-block-end: 0.8em;"></div>

                <table
                    style="width: 100%;border: none !important;background-color: white !important;margin-bottom: 8px;">
                    <tbody>
                    <tr>
                        <td style="text-align: end;right: 20px;position: relative;font-weight: 600;font-size: 11px;">
                            {{__('locale.sub_total')}}
                        </td>
                        <td style="position: relative;right: 6px;font-weight: 600;font-size: 11px;text-align: end;">{{ number_format((float)$final_cost, 3, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: end;right: 20px;position: relative;font-weight: 600;font-size: 11px;">
                            {{__('locale.less_desc')}}
                        </td>
                        <td style="position: relative;right: 6px;font-weight: 600;font-size: 11px;text-align: end;">{{ number_format((float)$booking->discount_amount, 3, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: end;right: 20px;position: relative;font-weight: 600;font-size: 11px;">
                            {{__('locale.change')}}
                        </td>
                        <td style="position: relative;right: 6px;font-weight: 600;font-size: 11px;text-align: end;">{{ number_format((float)$booking->change_amount, 3, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: end;right: 20px;position: relative;font-weight: 600;font-size: 11px;">
                            {{__('locale.paid')}}
                        </td>
                        <td style="position: relative;right: 6px;font-weight: 600;font-size: 11px;text-align: end;">{{ number_format((float)(($final_cost + $booking->change_amount) - $booking->discount_amount), 3, '.', '') }}</td>
                    </tr>
                    {{-- <tr>
                        <td>
                            <hr style="border-top: 2px dashed #000;">
                        </td>
                        <td>
                            <hr style="border-top: 2px dashed #000;">
                        </td>
                    </tr>
                    <tr>
                        <td style="position: relative;right: 6px;font-weight: 600;font-size: 11px;text-align: end;">
                            {{ number_format((float)($final_cost - $booking->discount_amount), 3, '.', '') }}
                        </td>
                    </tr> --}}
                    <tr>
                        <td>
                            <hr style="border-top: 2px dashed #000;">
                        </td>
                        <td>
                            <hr style="border-top: 2px dashed #000;">
                        </td>
                    </tr>
                    @if($booking->remaining_amount > 0)
                        <tr>
                            <td style="text-align: end;right: 44px;position: relative;font-weight: 600;font-size: 11px;">
                                {{__('locale.remaining_amount')}}
                            </td>
                            <td style="position: relative;right: 6px;font-weight: 600;font-size: 11px;text-align: end;">
                                {{ number_format((float)($booking->remaining_amount), 3, '.', '') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <hr style="border-top: 2px dashed #000;">
                            </td>
                            <td>
                                <hr style="border-top: 2px dashed #000;">
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                <?php
                $transactions = $booking->transactions->whereIn('type', ['credit', 'debit'])->whereIn('action', ['receipt', 'refund']);
                ?>
                    <table style="width: 100%;">
                        <thead>
                        <th colspan="3"
                            style="border: 1px solid black; text-align:center; border-collapse: collapse; width: 100%; padding-left: 15px;">
                            {{ $booking->status == 'canceled' ? __('locale.refund') : ''}} {{ __('locale.payment_summary') }}
                        </th>
                        </thead>
                        <tbody>
                        @php $total_paid = 0; $canceled_by_name = ''; $canceled_on = ''; @endphp
                        @if(!empty($transactions) && count($transactions) > 0)
                        @foreach($transactions as $transaction)
                            @if($booking->status != 'canceled' && $transaction->type == 'credit')
                            @php $total_paid+= number_format((float)$transaction->amount, 3, '.', ''); @endphp
                            <tr>
                                <td align="center"
                                    style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 40%;">
                                    {{ $transaction->payment_type->name }}
                                </td>
                                <td align="center"
                                    style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 100%;padding-right: 20px;">
                                    {{ number_format((float)$transaction->amount, 3, '.', '') }} <br>
                                </td>
                            </tr>
                            @endif
                            @if($booking->status == 'canceled' && $transaction->action == 'refund')
                            @php 
                                $total_paid+= number_format((float)$transaction->amount, 3, '.', ''); 
                                $canceled_by_name = $transaction->created_by_user->name;
                                $canceled_on = $transaction->created_at;
                            @endphp
                            <tr>
                                <td align="center"
                                    style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 40%;">
                                    {{ $transaction->payment_type->name }}
                                </td>
                                <td align="center"
                                    style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 100%;padding-right: 20px;">
                                    {{ number_format((float)$transaction->amount, 3, '.', '') }} <br>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        @endif
                        @if($booking->status != 'canceled' && $booking->redeem_from_voucher > 0)
                        @php $total_paid+= number_format((float)$booking->redeem_from_voucher, 3, '.', ''); @endphp
                        <tr>
                            <td align="center"
                                style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 40%;">{{__('locale.voucher')}} # {{$booking->voucher_code}}
                            </td>
                            <td align="center"
                                    style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 100%;padding-right: 20px;">
                                    {{number_format((float)$booking->redeem_from_voucher, 3, '.', '')}}
                                    
                            </td>
                        </tr>
                        @endif
                        @if($booking->status != 'canceled' && $booking->redeem_from_advance > 0)
                        @php $total_paid+= number_format((float)$booking->redeem_from_advance, 3, '.', ''); @endphp
                        <tr>
                            <td align="center"
                                style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 40%;">{{__('locale.advance')}} 
                            </td>
                            <td align="center"
                                    style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 100%;padding-right: 20px;">
                                    {{number_format((float)$booking->redeem_from_advance, 3, '.', '')}}
                                    
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td align="center"
                            style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 40%;">{{__('locale.total')}}</td>
                            <td align="center"
                            style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 100%;padding-right: 20px;">{{number_format((float)$total_paid, 3, '.', '')}}</td>
                        </tr>
                        @if($booking->status == 'canceled' && $transaction->action == 'refund')
                        <tr>
                            <td>
                                <hr style="border-top: 2px dashed #000;">
                            </td>
                            <td>
                                <hr style="border-top: 2px dashed #000;">
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: start;left: 10px;position: relative;font-weight: 600;font-size: 11px;">{{__('locale.cancel_summary')}}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: start;left: 10px;position: relative;font-weight: 600;font-size: 11px;">
                                {{__('locale.cancel_by')}}: {{ !empty($canceled_by_name) ? $canceled_by_name : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: start;left: 49px;position: absolute;font-weight: 600;font-size: 11px;">
                                {{__('locale.cancel_on')}}: {{ \Carbon\Carbon::parse($canceled_on)->tz('Asia/Kuwait')->format('d M Y h:i A') }}
                            </td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
            </div>
        </div>
        <br>
    </div>

    @if(!empty($configuration['footer_notes']))
        <div style="border-bottom: 2px dashed black; margin-bottom: 5px"></div>
        <div class="footer_notes" style="text-align: center; margin-bottom: 0;">
            {!! $configuration['footer_notes'] !!}
        </div>
    @endif
    @if($configuration['invoice_footer_one'] || $configuration['invoice_footer_two'])
        <div style="font-size: 12px;text-align: center;font-weight: 500;">{{$configuration['invoice_footer_one']}}</div>
        <div style="font-size: 12px;text-align: center;font-weight: 500;">{{$configuration['invoice_footer_two']}}</div>
    @endif
    <div style="display: flex; justify-content: center; padding: 0.5rem 0">
        <span style="font-size: 8px">
            {{ __('locale.footer_title') }}
        </span>
    </div>
    @if(isset($receipt_url))
        <div class="text-center" style="text-align: center;padding: 0.5rem 0">
            <div class="float-left">
                <a href="{{ route('customers.scan', $booking->slug) }}" class="btn btn-outline-primary">
                    Receipt & Feedback
                </a>
            </div>
        </div>
    @endif
</div>
</body>

</html>
