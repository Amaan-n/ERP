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

        <div class="card card-custom gutter-b">
            <div class="card-body">
                <div style="font-size: 16px;text-align: center;font-weight: 500;">{{session()->get('organization_name')}}</div>
                <div style="font-size: 14px;text-align: center;font-weight: 500;">{{($wallet->type == 'debt') ? 'Advance Refund Invoice' : 'Advance Receipt'}}</div>
                <hr style="border-top: 2px dashed black;margin-block-start: 0;margin-block-end: 0.8em;">

                <table class="customer_details">
                    <tbody>
                    <tr>
                        <td>{{__('locale.invoice_number')}}</td>
                        <td>{{ !empty($wallet->invoice_number) ? $wallet->invoice_number : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.date')}}</td>
                        <td>{{ !empty($wallet->created_at) ? \Carbon\Carbon::parse($wallet->created_at)->tz('Asia/Kuwait')->format('Y-m-d') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.time')}}</td>
                        <td>{{ !empty($wallet->created_at) ? \Carbon\Carbon::parse($wallet->created_at)->tz('Asia/Kuwait')->format('h:i A') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.customer')}}</td>
                        <td>{{ !empty($wallet->customer) ? $wallet->customer->name : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.mobile')}}</td>
                        <td>{{ !empty($wallet->customer) ? $wallet->customer->phone : '-' }}</td>
                    </tr>
                    <tr>
                        <td>{{__('locale.created_by')}}</td>
                        <td>{{ !empty($wallet->user) ? $wallet->user->name : '-' }}</td>
                    </tr>
                    </tbody>
                </table>

                <div style="border-top: 2px dashed black;margin-block-start: 0.6em;margin-block-end: 0.6em;"></div>

                <p style="text-align:center">{{__('locale.advance_payment')}} @if($wallet->type == 'credit') {{'Received'}} @else {{'Refund'}} @endif</p>

                <div style="border-top: 2px dashed black;margin-block-start: 0.8em;margin-block-end: 0.8em;"></div>

                <table
                    style="width: 100%;border: none !important;background-color: white !important;margin-bottom: 8px;">
                    <tbody>
                    <tr>
                        <td style="text-align: end;right: 20px;position: relative;font-weight: 600;font-size: 11px;">
                            {{__('locale.paid')}}
                        </td>
                        <td style="position: relative;right: 6px;font-weight: 600;font-size: 11px;text-align: end;">{{ number_format((float)$wallet->amount, 3, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>
                            <hr style="border-top: 2px dashed #000;">
                        </td>
                        <td>
                            <hr style="border-top: 2px dashed #000;">
                        </td>
                    </tr>
                    </tbody>
                </table>

                
                    <table style="width: 100%;">
                        <thead>
                        <th colspan="3"
                            style="border: 1px solid black; text-align:center; border-collapse: collapse; width: 100%; padding-left: 15px;">
                            {{ $wallet->type == 'debt' ? __('locale.refund') : ''}} {{ __('locale.payment_summary') }}
                        </th>
                        </thead>
                        <tbody>
                            @if(in_array($wallet->type, ['credit', 'debt']))
                            <tr>
                                <td align="center"
                                    style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 40%;">
                                    {{ $wallet->payment_type->name }}
                                </td>
                                <td align="center"
                                    style="font-weight: bold;  border: 1px solid black; border-collapse: collapse; width: 100%;padding-right: 20px;">
                                    {{ number_format((float)$wallet->amount, 3, '.', '') }} <br>
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
            THANK YOU FOR VISITING, WELCOME BACK
        </div>
    @endif

    <div style="display: flex; justify-content: center; padding: 0.5rem 0">
        <span style="font-size: 8px">
            {{ __('locale.footer_title') }}
        </span>
    </div>
</div>
</body>

</html>
