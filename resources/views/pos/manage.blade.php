@extends('guest-layouts.master')

@section('content')
    <style>
        .pos_container {
            font-weight: 500 !important;
        }

        .selected_item_row.clicked {
            background-color: #ddf2f9;
        }

        th, td {
            vertical-align: middle !important;
            text-wrap: nowrap !important;
            font-weight: 500;
            border: 1px solid darkgray !important;
        }

        .table-responsive::-webkit-scrollbar, .items_container::-webkit-scrollbar {
            display: none;
        }

        .table-responsive, .items_container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <div class="pos_container border border-dark position-relative h-100">

        <div class="card card-custom position-absolute w-100" style="top: 0">
            <div class="card-body min-h-300px"
                 style="background: linear-gradient(to right, #feac5e, #c779d0, #4bc0c8)">
                <a class="btn float-right close_pos cursor-pointer">
                    <i class="fa fa-times text-white fa-2x"> </i>
                </a>
            </div>
        </div>

        <div class="w-100 d-flex p-0 m-0">
            <div class="w-50 px-5">
                <div style="height: 3vh;"></div>
                <div class="card card-custom w-100" style="height: 20vh">
                    <div class="card-body">
                        <div class="input-group mb-5 display_customer_data">
                            <input type="text" class="form-control display_customer_phone_input"
                                   placeholder="Enter customer's phone"
                                   value="{{ \Illuminate\Support\Facades\Session::has('phone') ? \Illuminate\Support\Facades\Session::get('phone') : '' }}">
                            <div class="input-group-append search_customer">
                                <a class="btn btn-outline-secondary">
                                    <i class="fa fa-search"> </i>
                                </a>
                            </div>
                        </div>
                        <p class="text-danger display_customer_error d-none">
                            No Record Found. Click
                            <a href="javascript:void(0);" class="create_new_customer">HERE</a>
                            Add Customer
                        </p>
                        <div class="display_customer_div d-none">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div>
                                    <a href="javascript:void(0);" target="_blank"
                                       class="font-size-h5 font-weight-bold text-dark-75 display_customer_name">
                                        No Name
                                    </a><br>
                                    <span class="display_customer_phone mt-3">
                                                        No Phone
                                                    </span>
                                </div>

                                <div>
                                    <a href="javascript:void(0);"
                                       class="btn btn-icon btn-sm search_customer">
                                        <i class="fa fa-search"> </i>
                                    </a>
                                    <a href="javascript:void(0);"
                                       class="btn btn-icon btn-sm edit_customer">
                                        <i class="fa fa-edit"> </i>
                                    </a>
                                    <a href="javascript:void(0);"
                                       class="btn btn-icon btn-sm change_customer">
                                        <i class="fa fa-times"> </i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                <span>Invoice Number</span>
                                <span class="text-secondary pos_invoice_number">
                                                        {{ $invoice_number }}
                                                    </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                <span class="font-weight-bold">Date</span>
                                <span class="text-secondary">
                                                        {{ \Carbon\Carbon::now()->tz('Asia/Kuwait')->format('dS F Y h:i A') }}
                                                    </span>
                                <input type="hidden" class="item_booking_date"
                                       value="{{ \Carbon\Carbon::now()->tz('Asia/Kuwait')->format('Y-m-d') }}">
                            </li>
                        </ul>
                    </div>
                </div>
                <div style="height: 3vh;"></div>
                <div class="card card-custom p-3" style="height: 70vh">
                    <input type="hidden" name="booking_data" id="booking_data" value="">
                    <input type="hidden" name="invoice_number" id="invoice_number" value="MER-000616">
                    <input type="hidden" name="customer_id" id="customer_id" value="">
                    <input type="hidden" name="booking_id" id="booking_id" value="0">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr style="background: linear-gradient(to right, #feac5e, #c779d0, #4bc0c8)">
                                <th>Actions</th>
                                <th>Items</th>
                                <th>Per Item Price</th>
                                <th>Total Price</th>
                            </tr>
                            </thead>
                            <tbody id="customer_bookings">
                            <tr>
                                <td colspan="3">No record found</td>
                            </tr>
                            </tbody>
                            <tfoot id="customer_bookings_footers"></tfoot>
                        </table>
                    </div>
                </div>
                <div style="height: 3vh;"></div>
            </div>

            <div class="w-50 pr-5">
                <div style="height: 3vh;"></div>
                <div class="d-none" style="margin-top: -130px;">
                    <div class="card card-custom">
                        <div class="card-body p-3 pl-5">
                            <div data-scroll="true" data-height="620">
                                <ul class="navi navi-link-rounded navi-accent navi-hover flex-column mb-8 mb-lg-0"
                                    role="tablist">
                                    @foreach (\App\Providers\FormList::getProductCategories() as $product_category)
                                        <li class="navi-item border-bottom" style="border-bottom: 1px">
                                            <a href="javascript:void(0);"
                                               class="navi-link item_category_selection active"
                                               data-category-id="{{ $product_category->id }}">
                                                    <span class="navi-text text-dark-50">
                                                        {{ $product_category->name }}
                                                    </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-custom" style="height: 93vh">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title w-100">
                            <input type="text" name="item_keyword"
                                   class="form-control form-control-xs item_keyword"
                                   placeholder="Type here for search"
                                   style="">
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="items_container d-flex justify-content-between flex-wrap"
                             style="height:100%; overflow-y: auto"></div>
                    </div>
                </div>
                <div class="w-100 d-none" style="bottom: 1rem">
                    <div class="worker_container d-flex justify-content-center text-nowrap overflow-auto my-4"></div>

                    <div class="d-flex flex-wrap justify-content-center">
                        <a href="javascript:void(0);"
                           class="btn mb-2 mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white new_invoice"
                           style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                            New Invoice
                        </a>
                        <a href="{{ route('pos.index') }}"
                           class="btn mb-2 mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white"
                           style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                            Search
                        </a>
                        @if(in_array('pos.cancel_booking', $accesses_urls))
                            <a href="javascript:void(0);"
                               class="btn mb-2 mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white cancel_booking_pos"
                               style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                    <span class="navi-text">
                        Cancel Invoice
                    </span>
                            </a>
                        @endif
                        <a href="javascript:void(0);"
                           class="btn mb-2 mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white invoice_print"
                           style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                    <span class="navi-text">
                        Print Invoice
                    </span>
                        </a>
                        <button
                            class="btn mb-2 ml-2 p-5 border-0 font-size-h4 font-weight-bold text-white payment_popup_button"
                            style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                            Book & Pay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pos.modal.customers')
    @include('pos.modal.create_customer')
    @include('pos.modal.edit_items')
    @include('pos.modal.payment_control')
    @include('pos.modal.cancel_booking')
@stop

@section('page_js')
    <script type="text/javascript">
        let arr = [];
        $(document).ready(function () {
            initSelect2();
            getItems();

            $(document).find('.display_customer_phone_input').focus();

            let session_phone = '{{ \Illuminate\Support\Facades\Session::has('phone') ? \Illuminate\Support\Facades\Session::get('phone') : '' }}';

            let customer = localStorage.getItem('customer');
            if (customer !== null) {
                customer = $.parseJSON(customer);
                session_phone = customer.phone;
            }

            if (session_phone.length > 0) {
                getCustomerByPhone(session_phone);
            }

            $(document).off('click', '.search_customer');
            $(document).on('click', '.search_customer', function () {
                $(document).find('.customers_listing').modal('show');
            });

            $(document).off('click', '.select_customer');
            $(document).on('click', '.select_customer', function () {
                getCustomerByPhone($(this).data('phone'));
                $(document).find('.customers_listing').modal('hide');
            });

            $(document).off('click', '.create_new_customer');
            $(document).on('click', '.create_new_customer', function () {
                $(document).find('.create_customer_model').modal('show');
                $(document).find('.create_customer_model').find('input[name="phone"]').val($('.display_customer_phone_input').val());
            });

            $(document).off('click', '.edit_customer');
            $(document).on('click', '.edit_customer', function () {
                $(document).find('.create_customer_model').modal('show');
                $(document).find('.create_customer_model').find('input[name="phone"]').val($('.display_customer_phone_input').val());

                getCustomerByPhone($(document).find('.display_customer_phone').html(), true);
            });

            $(document).off('keyup', '.display_customer_phone_input');
            $(document).on('keyup', '.display_customer_phone_input', function () {
                let customer_phone = $(this).val();
                if (customer_phone.length >= 5) {
                    getCustomerByPhone(customer_phone);
                }
            });

            $(document).off('click', '.change_customer');
            $(document).on('click', '.change_customer', function () {
                $(document).find('.display_customer_phone_input').removeClass('d-none').val('').focus();
                $(document).find('.display_customer_data').removeClass('d-none');
                $(document).find('.display_customer_div').addClass('d-none');
                $(document).find('.display_customer_name').text('No Name').attr('href', 'javascript:void(0);');
                $(document).find('.display_customer_phone').text('No Phone');
                $(document).find('#customer_id').val('');
                localStorage.removeItem('customer');

                $(document).find('.display_customer_phone_input').focus();
            });

            $('.customer_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required',
                    phone: 'required'
                }
            });

            $(document).off('click', '.new_invoice');
            $(document).on('click', '.new_invoice', function () {
                clearLocalStorage();
                location.href = "{{ route('pos.create') }}";
            });

            $(document).off('click', '.close_pos');
            $(document).on('click', '.close_pos', function () {
                clearLocalStorage();
                location.href = "{{ route('orders.home') }}";
            });

            let debounceTimer;
            $(document).off('keyup', 'input[name="item_keyword"]');
            $(document).on('keyup', 'input[name="item_keyword"]', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    getItems($(this).val(), '');
                }, 300);
            });

            $(document).off('click', '.item_category_selection');
            $(document).on('click', '.item_category_selection', function () {
                $(document).find('.item_category_selection').css('background-color', '');
                $(document).find('.item_category_selection').removeClass('active');

                $(this).css('background-color', '#d2d6ed');
                $(this).addClass('active');

                getItems('', $(this).attr('data-category-id'))
            });

            $(document).off('click', '.item_selection');
            $(document).on('click', '.item_selection', function (e) {
                e.preventDefault();
                const item_id = $(this).data('item-id');
                const booking_date = $(document).find('.item_booking_date').val();
                const quantity = 1;
                let decoded_pos_item_data = JSON.parse(localStorage.getItem('pos_item_data')) || [];
                const existingItemIndex = decoded_pos_item_data.findIndex(item => item.item_id === item_id);

                const addItem = (data) => {
                    decoded_pos_item_data.push({
                        'type': 'product',
                        'item_id': item_id,
                        'booking_date': booking_date,
                        'quantity': quantity,
                        ...data,
                    });
                };

                const price = $(this).data('price');
                const item_name = $(this).data('name');

                if (existingItemIndex !== -1) {
                    decoded_pos_item_data[existingItemIndex].quantity++;
                    decoded_pos_item_data[existingItemIndex].price = price;
                    decoded_pos_item_data[existingItemIndex].final_cost = price * decoded_pos_item_data[existingItemIndex].quantity;
                } else {
                    addItem({
                        'price': price,
                        'final_cost': (price * quantity),
                        'item_name': item_name,
                        'item_discount_type': 'fixed',
                        'item_discount_value': 0,
                        'item_discount_cost': 0.000
                    });
                }

                localStorage.setItem('pos_item_data', JSON.stringify(decoded_pos_item_data));
                retrieveCartItems();
            });

            retrieveCartItems();

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
                startDate: new Date(),
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $(document).off('keyup', '#coupon_code');
            $(document).on('keyup', '#coupon_code', function () {
                let coupon_code = $(this).val();
                if (coupon_code.length >= 6) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('coupon.validate') }}',
                        data: {
                            coupon_code: coupon_code,
                            customer_id: $(document).find('#customer_id').val(),
                            date: $(document).find('.item_booking_date').val(),
                        },
                        success: function (response) {
                            if (!response.success) {
                                $(document).find('.coupon_discount_value').val(0);
                                $(document).find('.coupon_discount_type').val('absolute');
                                $(document).find('.display_coupon_code_error').removeClass('d-none');
                                $(document).find('.display_coupon_code_error').html(response.message);
                                $(document).find('#discount_value').val('');
                                calculateAddedAmounts();
                                return false;
                            }

                            $(document).find('.display_coupon_code_error').addClass('d-none');
                            $(document).find('.coupon_id').val(response.data.coupon.coupon_id);
                            $(document).find('.coupon_discount_type').val(response.data.coupon.type);
                            $(document).find('.coupon_discount_value').val(response.data.coupon.value);

                            $(document).find('input:radio[name="discount_type"]').filter(function () {
                                return $(this).val() === response.data.coupon.type;
                            }).prop('checked', true);

                            $(document).find('.discount_section').removeClass('hidden');
                            $(document).find('#discount_value').val(response.data.coupon.value);
                            $(document).find('.coupon_section').find('input').val('');
                            calculateAddedAmounts();
                        }
                    });
                }
            });

            $(document).off('click', '.edit_invoice_item');
            $(document).on('click', '.edit_invoice_item', function (e) {
                e.preventDefault();
                let index = $(this).closest('tr').attr('data-index');

                let decoded_items = [];
                let storage_items = localStorage.getItem('pos_item_data');
                if (storage_items !== null) {
                    decoded_items = $.parseJSON(storage_items);
                    let individual_item = decoded_items.find((ds, ds_index) => ds_index == index);

                    let modal_selector = $(document).find('.edit_item_model');
                    if (individual_item.type == 'service') {
                        modal_selector.find('.edit_quantity_modal').hide();
                    } else {
                        modal_selector.find('.edit_quantity_modal').show();
                    }
                    modal_selector.modal('show');
                    modal_selector.find('.edit_item_submit_button').attr('data-index', index);
                    modal_selector.find('.item_quantity').val(individual_item.quantity);
                    modal_selector.find('.item_price').val(individual_item.price);
                    modal_selector.find('.item_discount_value').val(individual_item.item_discount_value);
                    if (individual_item.item_discount_type == 'percentage') {
                        modal_selector.find("#item_discount_type").prop("checked", true)
                    } else {
                        modal_selector.find("#item_discount_type").prop("checked", false)
                    }
                }
            })

            // Start Update Item
            $(document).off('click', '.edit_item_submit_button');
            $(document).on('click', '.edit_item_submit_button', function (e) {
                e.preventDefault();
                let index = $(this).attr('data-index');
                let modal_selector = $(document).find('.edit_item_model');
                let entered_quantity = modal_selector.find('.item_quantity').val();
                let entered_price = modal_selector.find('.item_price').val();
                let entered_discount = modal_selector.find('.item_discount_value').val();
                let discount_cost = entered_discount ?? 0;
                let total_price = entered_price * entered_quantity;

                if (isNaN(entered_quantity) || entered_quantity < 1) {
                    modal_selector.find('.item_quantity').addClass("is-invalid");
                    modal_selector.find('.item_quantity').next(".invalid-feedback").html('');
                    modal_selector.find('.item_quantity').after("<div class='invalid-feedback'>Item quantity must be at least 1</div>");
                    return false;
                } else {
                    modal_selector.find('.item_quantity').removeClass("is-invalid");
                    modal_selector.find('.item_quantity').next(".invalid-feedback").remove();
                }

                if (isNaN(entered_price) || entered_price <= 0) {
                    modal_selector.find('.item_price').addClass("is-invalid");
                    modal_selector.find('.item_price').next(".invalid-feedback").html('');
                    modal_selector.find('.item_price').after("<div class='invalid-feedback'>Item unit price must be at least 1</div>");
                    return false;
                } else {
                    modal_selector.find('.item_price').removeClass("is-invalid");
                    modal_selector.find('.item_price').next(".invalid-feedback").remove();
                }
                var item_discount_type = $("#item_discount_type").prop("checked");
                if (item_discount_type) {
                    discount_cost = (total_price * entered_discount) / 100;
                }

                if (discount_cost >= total_price) {
                    swal('Error...', 'You can not give discount greater than item price', 'error');
                    return false;
                }
                let storage_items = localStorage.getItem('pos_item_data');
                if (storage_items !== null) {
                    decoded_items = $.parseJSON(storage_items);
                    let final_cost = total_price - discount_cost;
                    let individual_item = decoded_items.find((ds, ds_index) => ds_index == index);
                    individual_item.item_discount_type = (item_discount_type) ? 'percentage' : 'fixed';
                    individual_item.item_discount_value = entered_discount;
                    individual_item.item_discount_cost = discount_cost;
                    individual_item.price = entered_price;
                    individual_item.quantity = entered_quantity;
                    individual_item.final_cost = final_cost;
                    individual_item.commission_data = [{
                        worker_id: individual_item.selected_worker_id,
                        worker_name: individual_item.selected_worker_name,
                        worker_commission: final_cost.toFixed(3),
                        is_supporting_staff: 0
                    }];

                    decoded_items[index] = individual_item;
                    localStorage.setItem('pos_item_data', JSON.stringify(decoded_items));
                    $(document).find('.edit_item_model').modal('hide');
                    retrieveCartItems();
                }
            });
            // End Update Item

            $(document).off('click', '.remove_invoice_item');
            $(document).on('click', '.remove_invoice_item', function () {
                let index = $(this).closest('tr').attr('data-index');

                let decoded_pos_item_data = [];
                let storage_pos_item_data = localStorage.getItem('pos_item_data');
                if (storage_pos_item_data !== null) {
                    decoded_pos_item_data = $.parseJSON(storage_pos_item_data);
                    decoded_pos_item_data = decoded_pos_item_data.filter((ds, ds_index) => ds_index != index);
                }

                localStorage.setItem('pos_item_data', JSON.stringify(decoded_pos_item_data));
                $(this).closest('tr').remove();
                retrieveCartItems();
            });

            $(document).off('click', '.payment_popup_button');
            $(document).on('click', '.payment_popup_button', function () {
                $('.common_selection:first').trigger('click');
                $(document).find('#is_restricted_customer').val('0');
                let customer_id = $(document).find('#customer_id').val();
                if (!customer_id) {
                    let customer_phone = '';
                    $(document).find('#is_restricted_customer').val('1');
                    $(document).find('#available_loyalty').val('');
                    $(document).find('#available_loyalty_amount').val('');
                    $(document).find('#customer_advance_balance').val('')
                    getCustomerByPhone(customer_phone);
                }

                let validation_message = '';
                let storage_pos_item_data = localStorage.getItem('pos_item_data');
                if (!storage_pos_item_data) {
                    validation_message = 'Please select item(s) to proceed.';
                }

                if (validation_message !== '') {
                    swal('Error...', validation_message, 'error');
                    return false;
                }
                $(document).find('.payment_control_modal').modal('show');
                setTimeout(function () {
                    document.getElementById(last_focused).focus();
                }, 500);
                let item_type = localStorage.getItem('item_type');
                let service_worker_id = localStorage.getItem('service_worker_id');
                let service_booking_date = localStorage.getItem('service_booking_date');
                let service_schedule_time = localStorage.getItem('service_schedule_time');
                $(document).find('.invoice_amount').html(parseFloat($('#invoice_total').html()).toFixed(3));

                $('input[type="radio"][name="discount_type"]').filter('[value="fixed"]').trigger('click');
                $('.invoice_input_redeem').val('');

                let invoiceTotal = $(document).find('#invoice_total').text();
                $(document).find('.invoice_payable_amount').html(parseFloat(invoiceTotal).toFixed(3));

                calculateAddedAmounts();
                if ($(document).find('#available_loyalty').val() > 0 && (item_type == 'service' || item_type == 'product')) {
                    // $(document).find('.loyal_amount_div').removeClass('hidden');
                    $('.loyal_point_label').html($(document).find('#available_loyalty').val())
                    $('.loyal_amount_label').html($(document).find('#available_loyalty_amount').val())
                    $(document).find('#redeem_button').removeClass('hidden');
                } else {
                    $(document).find('.redeem_section').addClass('hidden');
                    // $(document).find('.loyal_amount_div').addClass('hidden');
                    $(document).find('#redeem_button').addClass('hidden');
                    $('.loyal_point_label').html(0.000);
                    $('.loyal_amount_label').html(0.000);
                }
            });

            $(document).on('click', '.common_selection', function () {
                var sectionId = $(this).data('section');

                $('.main_div_common_selection').addClass('hidden');
                $('.' + sectionId).removeClass('hidden');
                $('.common_selection').removeClass('btn-primary').addClass('btn-outline-primary');
                $(this).addClass('btn-primary').removeClass('btn-outline-primary');

                if (sectionId === 'advance_redeem_section') {
                    var advanceBalance = parseFloat($('#customer_advance_balance').val());
                    $('.advance_amount_div').toggleClass('hidden', advanceBalance < 1);
                    $('.advance_balance_remaining').html(advanceBalance.toFixed(3));
                } else if (sectionId === 'loyalty_redeem_section') {
                    var availableLoyalty = parseFloat($('#available_loyalty').val());
                    $('.loyalty_amount_div').toggleClass('hidden', availableLoyalty < 1);
                    $('.loyalty_balance_remaining').html(availableLoyalty);
                }
            });

            $('.payment-type-input').on('input', function () {
                calculateAddedAmounts();
            });

            $(document).off('click', '#discount_type');
            $(document).on('click', '#discount_type', function () {
                $(document).find('.discount_section').removeClass('hidden');

                calculateAddedAmounts();
            });

            $(document).off('keyup', '#discount_value');
            $(document).on('keyup', '#discount_value', function () {
                calculateAddedAmounts();
            });

            $(document).off('click', '#proceed_to_pay');
            $(document).on('click', '#proceed_to_pay', function () {
                proceedToPay();
            });

            $(document).off('click', '.invoice_print');
            $(document).on('click', '.invoice_print', function (e) {

                e.preventDefault();
                let $_this = $(this);
                Swal.fire({
                    title: 'Invoice',
                    icon: "warning",
                    html: `<input type="text" class="form-control mb-2" id="invoice_number" placeholder="Enter Invoice Number">`,
                    confirmButtonText: 'Submit',
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            invoice_number: Swal.getPopup().querySelector('#invoice_number').value,
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        printInvoice(result.value.invoice_number, 1)
                    }
                });
            });

            $(document).off('click', '.selected_item_row');
            $(document).on('click', '.selected_item_row', function (event) {
                localStorage.setItem('selected_item_row_index', $(this).data('index'));
                localStorage.setItem('selected_item_row_type', $(this).data('type'));
                $('.selected_item_row').removeClass('clicked');
                $(this).addClass('clicked');
            });

            $(document).off('click', '.cancel_booking_pos');
            $(document).on('click', '.cancel_booking_pos', function (e) {
                $(document).find('.cancel_booking_modal').modal('show');
                getBookingForSelectedFilter(true);
            });
        });

        function getCustomerByPhone(phone, is_edit = false) {
            $.ajax({
                type: 'GET',
                url: '{{ route('pos.customer_by_phone') }}',
                data: {
                    phone: phone,
                },
                success: function (response) {
                    if (!response.success) {
                        $(document).find('.display_customer_error').removeClass('d-none');
                        return false;
                    }

                    let selector = $(document).find('.create_customer_model');

                    if (is_edit) {
                        selector.find('input[name="name"]').val(response.data.customer.name);
                        selector.find('input[name="email"]').val(response.data.customer.email);
                        selector.find('input[name="phone"]').val(response.data.customer.phone);
                        selector.find('textarea[name="about"]').val(response.data.customer.about);

                        selector.find('input[name="_method"]').val('put');
                        selector.find('.customer_form').attr('action', '{{ url('orders/customers') }}/' + response.data.customer.id);
                        selector.find('.submit_button').text('Update Customer');
                    } else {
                        $(document).find('.display_customer_error, .display_customer_phone_input, .display_customer_data').addClass('d-none');
                        $(document).find('.display_customer_div').removeClass('d-none');
                        $(document).find('.display_customer_name').text(response.data.customer.name).attr('href', '{{ url('orders/customers') }}/' + response.data.customer.slug);
                        $(document).find('.display_customer_phone').text(response.data.customer.phone);
                        $(document).find('#customer_id').val(response.data.customer.id);
                    }

                    localStorage.setItem('customer', JSON.stringify(response.data.customer));
                }
            });
        }

        function clearLocalStorage() {
            const itemsToRemove = [
                'pos_item_data',
                'service_booking_date',
                'service_schedule_time',
                'customer',
                'item_type',
                'service_type',
                'selected_item_row_index',
                'selected_item_row_type'
            ];

            for (const item of itemsToRemove) {
                localStorage.removeItem(item);
            }
        }

        function getItems(keyword = null, product_category_id = null) {
            $.ajax({
                type: 'get',
                url: '{{ route('pos.items') }}',
                data: {
                    keyword: keyword,
                    product_category_id: product_category_id
                },
                success: function (response) {
                    if (response.data.items_html === '') {
                        $(document).find('.items_container').html('<h6 class="text-warning d-flex justify-content-center align-items-center" style="height: 500px; margin-left: 0;">No Record Found...</h6>');
                        return false;
                    }

                    $(document).find('.items_container').html(response.data.items_html);
                }
            });
        }

        function retrieveCartItems() {
            let storage_pos_item_data = localStorage.getItem('pos_item_data');
            if (storage_pos_item_data !== null && storage_pos_item_data !== '[]') {
                let decoded_pos_item_data = JSON.parse(storage_pos_item_data);

                let item_row = '';
                let invoice_total = 0;
                let total_item_discount_cost = 0;
                $.each(decoded_pos_item_data, function (index, decoded_service) {
                    let final_cost = decoded_service.final_cost;
                    let price = decoded_service.price;

                    let is_edit = true;
                    let item_name = decoded_service.item_name;
                    item_row += '<tr data-index="' + index + '" class="selected_item_row" data-type="' + decoded_service.type + '">';
                    item_row += '<td class="text-center">' +
                        '<a href="javascript:void(0);" class="remove_invoice_item border border-danger p-1 px-2 mr-3" data-item-id="' + decoded_service.item_id + '">' +
                        '<i class="fa fa-times text-danger"> </i>' +
                        '</a>';
                    if (is_edit) {
                        @if($is_root_user == 1 || in_array('pos.edit_service_price', $accesses_urls))
                            item_row += '<a href="javascript:void(0);" class="edit_invoice_item border border-primary p-1 px-2" data-s-cat-type="service" data-item-id="' + decoded_service.item_id + '">' +
                            '<i class="fa fa-edit text-primary"> </i>' +
                            '</a>';
                        @endif
                    }
                    item_row += '</td>';
                    item_row += '<td class="align-middle">' + decoded_service.quantity + ' x ' + item_name + ' </td>';
                    item_row += '<td class="align-middle">' + parseFloat(price).toFixed(3) + ' </td>';
                    item_row += '<td class="align-middle">' + parseFloat(final_cost).toFixed(3) + ' </td>';
                    item_row += '</tr>';

                    invoice_total += final_cost;
                });

                let footer_row = '' +
                    '<tr><td colspan="3" align="right"><strong>Sub Total</strong></td><td id="sub_invoice_total">' + parseFloat(parseFloat(invoice_total) + parseFloat(total_item_discount_cost)).toFixed(3) + '</td></tr>';
                footer_row += '<tr><td colspan="3" align="right"><strong>Invoice Cost</strong></td><td id="invoice_total">' + parseFloat(invoice_total).toFixed(3) + '</td></tr>';

                $(document).find('#customer_bookings').html(item_row);
                $(document).find('#customer_bookings_footers').html(footer_row);
            } else {
                localStorage.removeItem('pos_item_data');
                $(document).find('#customer_bookings').html('<tr><td colspan="7">No record found</td></tr>');
                $(document).find('#customer_bookings_footers').html('');
            }
        }

        function initSelect2() {
            $(document).find('.select2').select2({
                placeholder: 'Please select a value',
                allowClear: true,
                closeOnSelect: false
            });
        }

        function getCalendarBookingData(booking_id) {
            $.ajax({
                type: 'get',
                url: '{{ route('calendar.booking_data') }}',
                data: {
                    booking_id: booking_id
                },
                success: function (response) {
                    $('#booking_id').val(booking_id);
                    localStorage.setItem('pos_item_data', JSON.stringify(response.data.item_data));
                    $('.pos_invoice_number').html(response.data.booking_data.invoice_number)
                    retrieveCartItems();
                }
            });
        }

        function calculateSum(paymentTypeAmountsArray) {
            let sum = paymentTypeAmountsArray.reduce((total, payment) => total + payment.amount, 0);
            return sum;
        }

        function collectPaymentTypeAmounts() {
            let paymentTypeAmounts = [];

            $('.payment-type-input').each(function () {
                let paymentTypeId = $(this).attr('data-id');
                let paymentTypeName = $(this).attr('name');
                let paymentTypeAmount = parseFloat($(this).val()) || 0;

                paymentTypeAmounts.push({
                    payment_type_id: paymentTypeId,
                    payment_type_name: paymentTypeName,
                    amount: paymentTypeAmount
                });
            });

            return paymentTypeAmounts;
        }

        var last_focused = document.querySelector('.focused').getAttribute('id');
        var elements = document.getElementsByClassName('last_focused');
        for (let i = 0; i < elements.length; i++) {
            elements[i].addEventListener('keyup', handleFocusElement, false);
            elements[i].addEventListener('click', handleFocusElement, false);
        }

        function handleFocusElement() {
            last_focused = $(this).attr('id');
        }

        function display(value, action = '') {
            let last_focused_value = $(document).find('.' + last_focused).val();
            if (action === 'add') {
                value = parseFloat(value);
                last_focused_value = last_focused_value !== '' ? parseFloat(last_focused_value) : 0;
                $(document).find('.' + last_focused).val(last_focused_value + value);
            } else {
                $(document).find('.' + last_focused).val(last_focused_value + value);
            }

            calculateAddedAmounts();
        }

        function calculateAddedAmounts() {
            let paymentTypeAmountsArray = collectPaymentTypeAmounts();
            let total_entered_amount = calculateSum(paymentTypeAmountsArray);
            let total_invoice_amount = parseFloat($(document).find('.invoice_amount').text());
            let item_type = $('input[name="item_type"]:checked').val()

            $(document).find('.input_payment_types_value').val(JSON.stringify(paymentTypeAmountsArray));

            let invoice_input_discount = $(document).find('.invoice_input_discount').val() === '' ? '0.000' : $(document).find('.invoice_input_discount').val();
            let invoice_input_redeem = $(document).find('.invoice_input_redeem').val() === '' ? '0.000' : $(document).find('.invoice_input_redeem').val();
            let invoice_input_voucher_amount = $(document).find('.invoice_input_voucher_amount').val() === '' ? '0.000' : $(document).find('.invoice_input_voucher_amount').val();
            let invoice_input_advance_amount = $(document).find('.invoice_input_advance_amount').val() === '' ? '0.000' : $(document).find('.invoice_input_advance_amount').val();
            let invoice_input_loyalty_amount = $(document).find('.invoice_input_loyalty_amount').val() === '' ? '0.000' : $(document).find('.invoice_input_loyalty_amount').val();

            invoice_input_discount = parseFloat(invoice_input_discount);
            invoice_input_redeem = parseFloat(invoice_input_redeem);
            invoice_input_voucher_amount = parseFloat(invoice_input_voucher_amount);
            invoice_input_advance_amount = parseFloat(invoice_input_advance_amount);
            invoice_input_loyalty_amount = parseFloat(invoice_input_loyalty_amount);
            if (invoice_input_discount > 0) {
                let discount_type = document.querySelector('input[name="discount_type"]:checked').value;
                if (discount_type == 'percentage') {
                    invoice_input_discount = (total_invoice_amount * invoice_input_discount) / 100;
                }
            }
            let total_discount_amount = total_invoice_amount > invoice_input_discount ? invoice_input_discount : total_invoice_amount;
            let total_redeem_amount = total_invoice_amount > invoice_input_redeem ? invoice_input_redeem : total_invoice_amount;
            let total_voucher_amount = total_invoice_amount > invoice_input_voucher_amount ? invoice_input_voucher_amount : total_invoice_amount;
            let total_advance_amount = total_invoice_amount > invoice_input_advance_amount ? invoice_input_advance_amount : total_invoice_amount;
            let total_loyalty_amount = total_invoice_amount > invoice_input_loyalty_amount ? invoice_input_loyalty_amount : total_invoice_amount;
            let total_payable_amount = total_invoice_amount - total_discount_amount - total_redeem_amount - total_voucher_amount - total_advance_amount - total_loyalty_amount;

            // if (total_payable_amount < 0) {
            //     swal('Error...', 'Payable Amount can not be in Negative.', 'error')
            //     $(document).find('#proceed_to_pay').addClass('disabled');
            //     return false;
            // }

            let total_due_amount = total_payable_amount - total_entered_amount;
            total_due_amount = total_due_amount < 0 ? 0.000 : total_due_amount;

            let total_change_amount = total_entered_amount - total_payable_amount;
            total_change_amount = total_change_amount < 0 ? 0.000 : total_change_amount;

            $(document).find('.invoice_payable_amount').html(total_payable_amount.toFixed(3));
            $(document).find('.invoice_discount_amount').html(total_discount_amount.toFixed(3));
            $(document).find('.invoice_redeem_amount').html(total_redeem_amount.toFixed(3));
            $(document).find('.invoice_voucher_amount').html(total_voucher_amount.toFixed(3));
            $(document).find('.invoice_advance_amount').html(total_advance_amount.toFixed(3));
            $(document).find('.invoice_loyalty_amount').html(total_loyalty_amount.toFixed(3));
            $(document).find('.invoice_due_amount').html(total_due_amount.toFixed(3));
            $(document).find('.invoice_change_amount').html(total_change_amount.toFixed(3));

            $(document).find('#proceed_to_pay').removeClass('disabled');
            let loyalty_amount = $(document).find('#available_loyalty_amount').val();
            let customer_advance_balance = $(document).find('#customer_advance_balance').val();
            // if (total_entered_amount > 0 && total_entered_amount < total_payable_amount.toFixed(3) && item_type != 'service') {
            //     $(document).find('#proceed_to_pay').addClass('disabled');
            // }
            if (invoice_input_redeem > total_invoice_amount ||
                invoice_input_discount > total_invoice_amount ||
                invoice_input_voucher_amount > total_invoice_amount || invoice_input_voucher_amount > parseFloat($('.voucher_balance_remaining').html()) ||
                invoice_input_advance_amount > total_invoice_amount ||
                invoice_input_loyalty_amount > total_invoice_amount || invoice_input_loyalty_amount > parseFloat($('.loyalty_balance_remaining').html())
            ) {
                $(document).find('#proceed_to_pay').addClass('disabled');
            }
        }

        function proceedToPay() {
            $(document).find('#proceed_to_pay').attr('disabled', true);
            $(document).find('#proceed_to_pay').addClass('disabled');

            let paymentTypeAmountsArray = collectPaymentTypeAmounts();
            const invoicePayableAmount = parseFloat($(document).find('.invoice_payable_amount').html());
            let is_proceed = true;
            paymentTypeAmountsArray.forEach((paymentType) => {
                if (paymentType.payment_type_name != 'cash') {
                    if (paymentType.amount > invoicePayableAmount) {
                        swal('Error...', 'You cannot pay more than the payable amount.', 'error');
                        is_proceed = false;
                    }
                }
            });
            if (!is_proceed) {
                return false;
            }
            let total_entered_amount = calculateSum(paymentTypeAmountsArray);
            const service_type = localStorage.getItem('service_type') ?? $('.service_type option:selected').val();

            let invoice_due_text = parseFloat($(document).find('.invoice_due_amount').text());
            // let is_partial_pay_enabled = parseFloat($(document).find('.is_partial_pay_enabled').val());
            // if (total_entered_amount > 0 && invoice_due_text > 0 && is_partial_pay_enabled === 0) {
            //     swal('Error...', 'Partial payment is not allowed, Please enter full amount.', 'error')
            //     return false;
            // }
            var isChecked = $(".is_balance_transfer").prop("checked");

            let data = {
                customer_id: $(document).find('#customer_id').val(),
                booking_id: $(document).find('#booking_id').val(),
                scheduled_at: $(document).find('.item_booking_date').val(),
                invoice_amount: parseFloat($('#invoice_total').html()),
                booking_data: localStorage.getItem('pos_item_data'),
                coupon_id: $(document).find('.coupon_id').val(),
                redeem_voucher_code: $(document).find('#redeem_voucher_code').val(),
                discount_type: document.querySelector('input[name="discount_type"]:checked').value,
                discount_value: $(document).find('.invoice_input_discount').val(),
                notes: $(document).find('.notes').val(),
                discount_price: $(document).find('.invoice_discount_amount').html(),
                redeem_price: $(document).find('.invoice_redeem_amount').html(),
                voucher_amount: $(document).find('.invoice_voucher_amount').html(),
                redeem_from_advance: $(document).find('.invoice_advance_amount').html(),
                redeem_from_loyalty: $(document).find('.invoice_loyalty_amount').html(),
                last_focused: last_focused,
                payment_type: paymentTypeAmountsArray,
                service_type: service_type,
                customer_data: localStorage.getItem('customer'),
                final_price: invoicePayableAmount,
                change_amount: $(document).find('.invoice_change_amount').html(),
                remaining_amount: invoice_due_text,
                is_transfer: isChecked,
                redeem_service_package_data: localStorage.getItem('redeem_service_package_data'),
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '{{ route('pos.store') }}',
                data: data,
                success: async function (response) {
                    if (!response.success) {
                        swal('Error...', response.message, 'error')
                        return false;
                    }
                    clearLocalStorage();
                    $(document).find('.payment_control_modal').modal('hide');

                    swal({
                        title: "Success", icon: 'success', text: 'Invoice Saved Successfully', type:
                            "success"
                    }).then(function () {
                            {{--if ({{$is_invoice_print}} == 1) {--}}
                            printInvoice(response.data.invoice_number, 1);
                            // }
                            // clear_local_storage();
                            retrieveCartItems();
                            service_data()
                            setTimeout(async () => {
                                window.location.href = "{{ route('pos.create') }}";
                            }, 1000);
                        }
                    );
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error('Network/Server Error:', textStatus, errorThrown);
                    swal('Error...', 'An error occurred while processing your request.', 'error');
                }
            });
        }

        function generatePaymentTypeOptions() {
            {{--            const paymentTypes = {!! json_encode($payment_types) !!};--}}

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
