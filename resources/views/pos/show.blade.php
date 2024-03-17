@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('pos.partials.booking_details')
        </div>
    </div>
@stop

@section('page_js')
@include('bookings.partials.general_service_html')
<script type="text/javascript" src="{{ asset('js/booking.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            
        });
        function generatePaymentTypeOptions() {
            const paymentTypes = {!! json_encode($payment_types) !!};
            
            let options = '';
            for (const typeId in paymentTypes) {
                if (paymentTypes.hasOwnProperty(typeId)) {
                    options += `<option value="${typeId}">${paymentTypes[typeId]}</option>`;
                }
            }
            return options;
        }
    </script>
@stop
