<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $configuration['name'] }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <style type="text/css">
        body {
            font-family: "Poppins", Verdana, monospace;
            font-size: 14px;
            border: 1px solid black;
            border-collapse: collapse;
            width: 80mm;
            height: 100%;
        }

        table, td {
            border: 0 solid black;
            border-collapse: collapse;
        }

        .customer_details td:first-child {
            text-align: right;
            font-weight: 600;
            padding-right: 10px;
        }

        .customer_details td:last-child {
            text-align: left;
            padding-left: 10px;
        }

        .items_particular {
            width: 100%;
        }

        .items_particular th:first-child, .items_particular td:first-child {
            border: 1px solid black;
            height: 25px;
            text-align: left;
            padding-left: 10px;
            width: 70%;
        }

        .items_particular th:last-child, .items_particular td:last-child {
            border: 1px solid black;
            height: 25px;
            text-align: right;
            padding-right: 10px;
            width: 30%;
        }

        .items_table td {
            border: 1px solid black;
        }

        .invoice_footer {
            text-transform: uppercase;
            text-align: center;
            font-size: small;
        }

        .invoice_footer p {
            margin: 0.1rem 0;
        }

        @media print {
            body {
                width: 80mm;
                height: 100%;
            }
        }
    </style>
</head>

<body>
<div class="content" style="padding: 20px">
    @if (!empty($configuration['logo']))
        <div style=" text-align: center;">
            <img src="{{ config('constants.s3.asset_url') . $configuration['logo'] }}"
                 style="text-align: center;"
                 class="mx-auto d-block" width="200" alt="{{ $configuration['name'] }}">
        </div>
    @else
        <h1 style="text-align: center; font-weight: 500">{{ $configuration['name'] }}</h1>
    @endif

    <div style="text-align: center; font-size: 16px; font-weight: 500; margin: 10px 0;">
        Sales Invoice
    </div>

    <hr style="border-top: 1px dashed darkgray; margin: 15px 0">

    <table class="customer_details">
        <tbody>
        <tr>
            <td>Invoice Number</td>
            <td>{{ !empty($booking->invoice_number) ? $booking->invoice_number : '-' }}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{ !empty($booking->created_at) ? \Carbon\Carbon::parse($booking->created_at)->tz('Asia/Kuwait')->format('dS F, Y') : '-' }}</td>
        </tr>
        <tr>
            <td>Time</td>
            <td>{{ !empty($booking->created_at) ? \Carbon\Carbon::parse($booking->created_at)->tz('Asia/Kuwait')->format('h:i A') : '-' }}</td>
        </tr>
        <tr>
            <td>Customer</td>
            <td>{{ !empty($booking->customer) ? $booking->customer->name : '-' }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ !empty($booking->customer) ? $booking->customer->phone : '-' }}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>{{ !empty($booking->user) ? $booking->user->name : '-' }}</td>
        </tr>
        </tbody>
    </table>

    <hr style="border-top: 1px dashed darkgray; margin: 15px 0">

    <table class="items_particular">
        <thead>
        <tr style="background-color: lightgrey">
            <th style="font-weight: 500;">Particular</th>
            <th style="font-weight: 500;">Price</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($booking->products) && count($booking->products) > 0)
            @foreach($booking->products as $booking_product)
                <tr>
                    <td>
                        @if($booking_product->product)
                            {{ !empty($booking_product->product->name)
                                ? $booking_product->quantity . ' X ' . $booking_product->product->name
                                : '' }}
                        @endif
                    </td>
                    <td>{{ number_format((float)$booking_product->final_price, 3, '.', '') }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <hr style="border-top: 1px dashed darkgray; margin: 15px 0">

    <table style="width: 100%">
        <tbody>
        <tr>
            <td style="height: 25px; text-align: right; padding-right: 10px; width: 70%; font-weight: 500">
                Sub Total :
            </td>
            <td style="height: 25px; text-align: right; padding-right: 10px; width: 70%; font-weight: 500">
                {{ number_format((float)$booking->invoice_amount, 3, '.', '') }}
            </td>
        </tr>
        <tr>
            <td style="height: 25px; text-align: right; padding-right: 10px; width: 70%; font-weight: 500">
                Less Discount :
            </td>
            <td style="height: 25px; text-align: right; padding-right: 10px; width: 70%; font-weight: 500">
                {{ number_format((float)$booking->discount_amount, 3, '.', '') }}
            </td>
        </tr>
        <tr>
            <td style="height: 25px; text-align: right; padding-right: 10px; width: 70%; font-weight: 500">
                Total Payable :
            </td>
            <td style="height: 25px; text-align: right; padding-right: 10px; width: 70%; font-weight: 500">
                {{ number_format((float)$booking->final_amount, 3, '.', '') }}
            </td>
        </tr>
        </tbody>
    </table>

    <hr style="border-top: 1px dashed darkgray; margin: 15px 0">

    <h3 style="text-align: center; font-weight: 500">Thank You !</h3>
    <div class="invoice_footer">
        <p>{{ $configuration['name'] ?? '-' }}</p>
        <p>{{ $configuration['address'] ?? '-' }}</p>
        <p>TEL. NOS. {{ $configuration['phone'] }}</p>
    </div>
</div>
</body>
</html>
