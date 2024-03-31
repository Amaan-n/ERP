@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{ \Illuminate\Support\Facades\Session::get('notification.type') }}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <?php $session = session()->has('pos_filters') ? session()->get('pos_filters') : []; ?>
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap">
                    <div class="card-title">
                        <h3 class="card-label">
                            <?php
                            $selected_date = '';
                            if (!empty($session)) {
                                $selected_date = ' ( ' . \Carbon\Carbon::createFromDate($session['date'])->format('dS F Y') . ' ) ';
                            }
                            ?>
                            List Of Orders
                            <span class="text-muted">{{ $selected_date }}</span>
                        </h3>
                    </div>

                    <div class="card-toolbar">
                        <div class="d-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text cursor-pointer schedule_date"
                                      data-action="previous">
                                    <i class="fa fa-angle-left"> </i>
                                </span>
                                </div>
                                <div class="input-group-prepend">
                                <span class="input-group-text cursor-pointer schedule_date"
                                      data-action="current">
                                      Today
                                </span>
                                </div>
                                <input type="text" class="form-control date_picker text-center" id="schedule_date"
                                       name="schedule_date" value="{{ \Carbon\Carbon::now()->format('l d F Y') }}"
                                       autocomplete="off">
                                <div class="input-group-append">
                                <span class="input-group-text cursor-pointer schedule_date" data-action="next">
                                    <i class="fa fa-angle-right"> </i>
                                </span>
                                </div>
                            </div>

                            <a href="{{ route('pos.create') }}" class="btn btn-outline-primary ml-3">
                                POS
                            </a>
                        </div>
                    </div>
                </div>

                @include('pos.index_table')
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            getBookingForSelectedFilter();

            let arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

            $('.date_picker').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                templates: arrows,
                autoclose: true,
            });

            $(document).off('click', '.schedule_date');
            $(document).on('click', '.schedule_date', function () {
                let schedule_date = $(document).find('input[name="schedule_date"]').val();
                let action = $(this).attr('data-action');
                switch (action) {
                    case 'previous':
                        schedule_date = moment(schedule_date).subtract(1, 'days').format('dddd D MMMM YYYY');
                        break;
                    case 'current':
                        schedule_date = moment().format('dddd D MMMM YYYY');
                        break;
                    case 'next':
                        schedule_date = moment(schedule_date).add(1, 'days').format('dddd D MMMM YYYY');
                        break;
                }

                $(document).find('input[name="schedule_date"]').val(schedule_date);
                $(document).find('input[name="schedule_date"]').datepicker({setDate: schedule_date});
                getBookingForSelectedFilter();
            });

            $(document).off('change', 'input[name="schedule_date"]');
            $(document).on('change', 'input[name="schedule_date"]', function () {
                getBookingForSelectedFilter(true);
            });

            $(document).off('click', '.print_invoice');
            $(document).on('click', '.print_invoice', function () {
                printInvoice($(this).attr('data-booking-slug'));
            });
        });

        function printInvoice(invoice_number, number_of_invoice_print = 1) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: '{{ route('pos.print_invoice') }}',
                data: {
                    invoice_number: invoice_number
                },
                success: function (response) {
                    if (!response.success) {
                        swal('Error...', response.message, 'error')
                        return false;
                    }

                    if (response.data) {
                        let custom_window = window.open('', '', 'height=5000, width=1000');
                        custom_window.document.write(response.data.html);
                        custom_window.document.close();
                        for (let i = 0; i < number_of_invoice_print; i++) {
                            custom_window.print();
                        }
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error('Network/Server Error:', textStatus, errorThrown);
                    swal('Error...', 'An error occurred while processing your request.', 'error');
                }
            });
        }

        function getBookingForSelectedFilter() {
            let status = $(document).find('select[name="status"]').val();
            let created_from = $(document).find('select[name="created_from"]').val();
            let schedule_date = $(document).find('input[name="schedule_date"]').val();
            $('.bookings_listing').DataTable({
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                aaSorting: [],
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('pos.get_bookings') }}",
                    data: {
                        status: status,
                        created_from: created_from,
                        schedule_date: schedule_date,
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'id', defaultContent: '', searchable: false},
                    {data: 'invoice_number', name: 'invoice_number', searchable: true, orderable: true},
                    {data: 'customer_name', name: 'customer_name', searchable: true, orderable: true},
                    {data: 'customer_phone', name: 'customer_phone', searchable: true, orderable: true},
                    {data: 'invoice_amount', name: 'paid', searchable: true},
                    {data: 'status', name: 'status', searchable: true},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'action', name: 'action', orderable: false},
                ]
            });
        }

        function init_select2() {
            $(document).find('.select2').select2({
                placeholder: 'Please select a value',
                allowClear: true,
                closeOnSelect: false
            });
        }
    </script>
@stop
