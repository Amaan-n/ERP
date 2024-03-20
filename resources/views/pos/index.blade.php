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

            let currentURL = $(location).attr('href');
            let urlSegments = currentURL.split('&');
            if (urlSegments.length > 1) {
                let lastSegment = urlSegments[urlSegments.length - 1];
                let lastSegmentKey = lastSegment.split('=');
                let bookingIdSegment = urlSegments[urlSegments.length - 3];
                let bookingIdSegmentValue = bookingIdSegment.split('=');

                if (lastSegmentKey[0] !== null && lastSegmentKey[0] !== undefined) {
                    if(lastSegmentKey[0] == 'is_customer_phone'){
                        getCustomerByPhone(lastSegmentKey[1])
                    }
                    clear_local_storage();
                    getCalendarBookingData(bookingIdSegmentValue[1])
                }
            }

            $(document).off('click', '.print_invoice');
            $(document).on('click', '.print_invoice', function () {
                printInvoice($(this).attr('data-booking-slug'));
            });

            $(document).off('click', '.cancel_booking');
            $(document).on('click', '.cancel_booking', function (e) {
                $(document).find('.cancel_booking_modal').modal('hide');
                let options = generatePaymentTypeOptions();
                e.preventDefault();
                let $_this = $(this);
                // Cancel Invoice Password
                Swal.fire({
                    title: "Please Enter Cancel Invoice Password!",
                    icon: "warning",
                    html: `<input type="text" id="cancel_invoice_password" class="form-control">`,
                    confirmButtonText: 'Submit',
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            cancel_invoice_password: Swal.getPopup().querySelector('#cancel_invoice_password').value
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'post',
                            url: $_this.attr('data-password-href'),
                            data: {
                                cancel_invoice_password: result.value.cancel_invoice_password
                            },
                            success: function (response) {
                                if (!response.success) {
                                    swal('Error...', response.message, 'error')
                                    return false;
                                }
                                Swal.fire({
                                    title: "Once press submit, Booking will be canceled!",
                                    icon: "warning",
                                    html: `<select id="payment_type" class="form-control mb-2">${options}</select>
                                        <input disabled type="number" class="form-control mb-2" id="amount" placeholder="Enter refund amount" max="${$_this.attr('data-final-amount')}" value="${$_this.attr('data-final-amount')}">
                                        <textarea id="cancel_notes" class="form-control" placeholder="Type something here..." rows="2">`,
                                    confirmButtonText: 'Submit',
                                    showCancelButton: true,
                                    focusConfirm: false,
                                    preConfirm: () => {
                                        return {
                                            payment_type: Swal.getPopup().querySelector('#payment_type').value,
                                            amount: $_this.attr('data-final-amount'),
                                            cancel_notes: Swal.getPopup().querySelector('#cancel_notes').value
                                        }
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let final_amount = parseFloat($_this.attr('data-final-amount'));
                                        let entered_amount = result.value.amount !== '' ? parseFloat(result.value.amount) : 0;

                                        if (final_amount < entered_amount) {
                                            swal('Error...', 'You can not refund more than paid amount.', 'error')
                                            return false;
                                        }

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'post',
                                            url: $_this.attr('data-href'),
                                            data: {
                                                invoice_number: $_this.attr('data-booking-slug'),
                                                payment_type: result.value.payment_type,
                                                amount: entered_amount,
                                                notes: result.value.cancel_notes
                                            },
                                            success: function (response) {
                                                if (!response.success) {
                                                    swal('Error...', response.message, 'error')
                                                    return false;
                                                }

                                                location.reload();
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
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
                url: '{{ route('pos.print.invoice') }}',
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

        function getBookingForSelectedFilter(is_pos = false){
            let status = $(document).find('select[name="status"]').val();
            let created_from = $(document).find('select[name="created_from"]').val();
            let schedule_date = $(document).find('input[name="schedule_date"]').val();
            $('.bookings_listing').DataTable({
                lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
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
                        is_pos: is_pos,
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'id', defaultContent: '', searchable: false},
                    {data: 'invoice_number', name: 'invoice_number', searchable: true, orderable: true},
                    {data: 'customer.name', name: 'customer_name', searchable: true, orderable: true},
                    {data: 'customer_phone', name: 'customer_phone', searchable: true, orderable: true},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'status', name: 'status', searchable: true},
                    {data: 'paid', name: 'paid', searchable: true},
                    {data: 'remaining_amount', name: 'remaining_amount', searchable: true},
                    {data: 'final_amount', name: 'final_amount', searchable: true},
                    {data: 'action', name: 'action', orderable: false},
                ],

                columnDefs: [
                    {
                        targets: 5,
                        render: function(data, type, row) {
                            var status = row.status;
                            var statusClass = status === 'canceled' ? 'badge badge-danger' : 'badge badge-success';

                            return '<span class="' + statusClass + '">' + status + '</span>';
                        },
                    },
                    {
                        targets: 8,
                        render: function(data, type, row) {
                            var status = row.status;
                            var finalAmount = parseFloat(data);

                            var statusClass = status === 'canceled' ? 'text-danger' : '';

                            return '<span class="' + statusClass + '">' + finalAmount.toFixed(2) + '</span>';
                        },
                    },
                ],
                "footerCallback": function (row, data, start, end, display) {
                    let api = this.api();

                    let totalRemainingAmount = api.column(7, { page: 'current' })
                        .data()
                        .toArray()
                        .reduce(function (acc, value) {
                            return acc + parseFloat(value);
                        }, 0);
                    $('#totalRemainingAmount').html(totalRemainingAmount.toFixed(3));

                    let totalFinalAmount = api.column(8, { page: 'current' })
                        .data()
                        .reduce(function (acc, value) {
                            return parseFloat(acc) + parseFloat(value);
                        }, 0);

                    $('#totalFinalAmount').html(totalFinalAmount.toFixed(3));

                    let canceledRows = api.rows(function (idx, data, node) {
                        return data.status === 'canceled';
                    });

                    let totalCancelAmount = canceledRows
                        .data()
                        .pluck('final_amount')
                        .reduce(function (acc, value) {
                            return parseFloat(acc) + parseFloat(value);
                        }, 0);

                    let grandTotalAmount = totalFinalAmount - totalCancelAmount - totalRemainingAmount;
                    $('#totalCancelAmount').html(totalCancelAmount.toFixed(3));
                    $('#totalSaleAmount').html(grandTotalAmount.toFixed(3));
                }
            });
        }

        $(document).off('click', '.update_status');
        $(document).on('click', '.update_status', function (e) {
            e.preventDefault();
            let $_this = $(this);
            let current_status = $_this.attr('data-booking-status');
            Swal.fire({
                title: 'Update Booking Status',
                icon: "warning",
                html: `<select id="status" class="form-control mb-2">
            <option value="booked" ${current_status === 'booked' ? 'selected' : ''}>Booked</option>
        <option value="confirmed" ${current_status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
        <option value="in_progress" ${current_status === 'in_progress' ? 'selected' : ''}>In Progress</option>
        <option value="completed" ${current_status === 'completed' ? 'selected' : ''}>Completed</option>
            </select>`,
                confirmButtonText: 'Submit',
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    return {
                        status: Swal.getPopup().querySelector('#status').value,

                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: $_this.attr('data-href'),
                        data: {
                            booking_slug: $_this.attr('data-booking-slug'),
                            status: result.value.status
                        },
                        success: function (response) {
                            if (!response.success) {
                                swal('Error...', response.message, 'error')
                                return false;
                            }
                            location.reload();
                        }
                    });
                }
            });
        });

        function init_select2() {
            $(document).find('.select2').select2({
                placeholder: 'Please select a value',
                allowClear: true,
                closeOnSelect: false
            });
        }

        function edit_item(booking_item_id, href) {
            $.ajax({
                type: 'get',
                url: href,
                data: {
                    booking_item_id: booking_item_id
                },
                beforeSend: function () {
                    $(document).find('.edit_service_modal').find('.edit_service_modal_body').html('Loading...');
                },
                success: function (response) {
                    if (!response.success) {
                        return false;
                    }
                    setTimeout(function () {
                        $(document).find('.select2').select2({
                            placeholder: 'Please select a value',
                            allowClear: true,
                            closeOnSelect: false,
                            maximumSelectionLength: response.data.total_staff
                        });

                    }, 1000)
                    $(document).find('.edit_service_modal').find('.edit_service_modal_body').html(response.data.html);
                }
            });
        }

    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            //
        });
    </script>
@stop
