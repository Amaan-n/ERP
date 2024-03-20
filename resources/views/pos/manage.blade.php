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

        .actions_button {
            z-index: 1100;
        }

        #bookings_listing_filter {
            margin-left: 63%;
        }

        #bookings_listing_paginate {
            margin-left: 80%;
        }

        .swal2-html-container {
            max-height: 263px !important;
        }
    </style>

    <div class="pos_container">
        <div class="row mx-0">
            <div class="col-md-12 p-0">
                <div class="card card-custom">
                    <div class="card-body min-h-200px p-5"
                         style="background: linear-gradient(to right, #feac5e, #c779d0, #4bc0c8)">
                        <a class="btn float-right close_pos cursor-pointer">
                            <i class="fa fa-times text-white fa-2x"> </i>
                        </a>

                        <div class="row">
                            <div class="col-md-4 pl-0">
                                <div class="d-flex justify-content-center">
                                    <div class="card card-custom w-100">
                                        <div class="card-body p-5">
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
                                                           class="font-size-h3 font-weight-bold text-dark-75 display_customer_name">
                                                            No Name
                                                        </a><br>
                                                        <span class="display_customer_phone mt-3">
                                                        No Phone
                                                    </span>
                                                    </div>

                                                    <div>
                                                        <a href="javascript:void(0);"
                                                           class="btn btn-icon search_customer">
                                                            <i class="fa fa-search"> </i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                           class="btn btn-icon edit_customer">
                                                            <i class="fa fa-edit"> </i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                           class="btn btn-icon change_customer">
                                                            <i class="fa fa-times"> </i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                                    <span class="font-weight-bold">
                                                        Invoice Number
                                                    </span>
                                                    <span
                                                        class="text-secondary pos_invoice_number">
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
                                </div>
                            </div>

                            <div class="col-md-8 p-0 pl-3 d-flex justify-content-center align-items-start">
                                <div class="w-50">
                                    <input type="text" name="item_keyword"
                                           class="form-control form-control-xs item_keyword"
                                           placeholder="Type here for search"
                                           style="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <input type="hidden" name="booking_data" id="booking_data" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="MER-000616">
                        <input type="hidden" name="customer_id" id="customer_id" value="">
                        <input type="hidden" name="redeem_voucher_code" id="redeem_voucher_code" value="">
                        <input type="hidden" name="available_loyalty" id="available_loyalty" value="">
                        <input type="hidden" name="available_loyalty_amount" id="available_loyalty_amount" value="">
                        <input type="hidden" name="customer_advance_balance" id="customer_advance_balance" value="">
                        <input type="hidden" name="is_restricted_customer" id="is_restricted_customer" value="">
                        <input type="hidden" name="booking_id" id="booking_id" value="0">

                        <div class="card bg-white" style="height:400px; max-height: 400px; overflow: auto;">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr style="background: linear-gradient(to right, #feac5e, #c779d0, #4bc0c8)">
                                        <th>Actions</th>
                                        <th>Items</th>
                                        <th>U.Price</th>
                                        <th>Disc</th>
                                        <th>Total</th>
                                        <th>Worker</th>
                                        <th>Notes</th>
                                    </tr>
                                    </thead>
                                    <tbody id="customer_bookings">
                                    <tr>
                                        <td colspan="7">No record found</td>
                                    </tr>
                                    </tbody>
                                    <tfoot id="customer_bookings_footers"></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 pl-0 item_categories_div" style="margin-top: -160px;">

                        <div class="card card-custom bg-white">
                            <div class="card-header text-right p-3">
                                <button class="btn btn-transparent-white">
                                    &nbsp;
                                </button>
                                <button id="previous-button-item-category" class="btn btn-primary hidden" disabled>
                                    <i class="fa fa-arrow-left"> </i>
                                </button>
                                <button id="next-button-item-category" class="btn btn-primary hidden">
                                    <i class="fa fa-arrow-right"> </i>
                                </button>
                            </div>
                            <div class="card-body p-3 pl-5">
                                <div class="bg-white item_category_container" data-scroll="true"
                                     data-height="480"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 pl-0 items_div" style="margin-top: -160px;">
                        <div class="card card-custom bg-white">
                            <div class="card-header text-right p-3">
                                <button id="previous-button-item" class="btn btn-primary hidden" disabled>
                                    <i class="fa fa-arrow-left"> </i>
                                </button>
                                <button id="next-button-item" class="btn btn-primary hidden">
                                    <i class="fa fa-arrow-right"> </i>
                                </button>
                            </div>
                            <div class="card-body p-3 pl-5">
                                <div data-scroll="true" data-height="480">
                                    <div class="items_container d-flex flex-wrap"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="position-absolute w-100" style="bottom: 1rem">
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
                        {{ __('locale.book_and_pay') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <template class="general_worker_commission">
        <div class="col-md-6 individual_worker_commission">
            <div class="form-group">
                <label class="form-label worker_name" for="0">
                    <input type="hidden" name="" value="">
                </label>
                <label class="form-label worker_full_name" for="0">
                    <input type="hidden" name="" value="">
                </label>

                <div class="d-flex">
                    <div class="input-group">
                        <input type="number" class="form-control worker_commission_input"
                               name="" min="1">
                    </div>
                </div>
            </div>
        </div>
    </template>

    @include('pos.modal.customers')
    @include('pos.modal.create_customer')

    @include('pos.modal.customer_detail')
    @include('pos.modal.payment_control')
    @include('pos.modal.service_package_list_modal')
    @include('pos.modal.edit_items')
    @include('pos.modal.cancel_booking')
@stop

@section('page_js')
    <script type="text/javascript">
        let arr = [];
        let customer_slug = '';
        $(document).ready(function () {

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
                getCustomerByPhone($(document).find('.display_customer_phone').html(), true);
                $(document).find('.create_customer_model').modal('show');
                $(document).find('.create_customer_model').find('input[name="phone"]').val($('.display_customer_phone_input').val());
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
                $(document).find('#is_restricted_customer').val('');
                localStorage.removeItem('customer');
                customer_slug = '';
            });

            $('.item_type').click(function () {
                $(".item_keyword").focus();
            })
            let item_type = "product";
            if (null != localStorage.getItem('item_type')) {
                item_type = localStorage.getItem('item_type');
                $('#' + item_type + '_type').trigger('click');
                $('.item_type').removeClass('btn-secondary, active').addClass('btn-outline-secondary');
                $('#' + item_type + '_type').addClass('btn-secondary, active');

            } else {
                localStorage.setItem('item_type', "product")
                $('#service_type').addClass('btn-secondary, active');
            }
            //

            if (item_type == 'package' || item_type == 'voucher') {
                $('.item_categories_div').addClass('hidden')
                    .siblings('.items_div')
                    .removeClass('col-md-6')
                    .addClass('col-md-8');
            }
            let service_type = "";
            if (null != localStorage.getItem('service_type')) {
                service_type = localStorage.getItem('service_type');
            } else {
                localStorage.setItem('service_type', "");
            }
            $('.service_type').val(service_type).trigger('change');
            retrieve_cart_items();
            service_data()
            $(document).find('.display_customer_phone_input').focus();

            $('.customer_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required',
                    phone: 'required'
                }
            });

            let session_phone = '{{ \Illuminate\Support\Facades\Session::has('phone') ? \Illuminate\Support\Facades\Session::get('phone') : '' }}';

            let customer = localStorage.getItem('customer');
            if (customer !== null) {
                customer = $.parseJSON(customer);
                session_phone = customer.phone;
                customer_slug = customer.slug;
            }

            if (session_phone.length > 0) {
                getCustomerByPhone(session_phone);
            }

            $(document).off('click', '.new_invoice');
            $(document).on('click', '.new_invoice', function () {
                clear_local_storage();
                location.href = "{{ route('pos.create') }}";
            });

            $(document).off('click', '.close_pos');
            $(document).on('click', '.close_pos', function () {
                clear_local_storage();
                location.href = "{{ route('home') }}";
            });

            let debounceTimer;
            $(document).off('keyup', 'input[name="item_keyword"]');
            $(document).on('keyup', 'input[name="item_keyword"]', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    getItems(localStorage.getItem('item_type'), 1, $(this).val());
                }, 300);
            });

            $(document).off('click', '.item_category_selection');
            $(document).on('click', '.item_category_selection', function () {
                let item_category_id = $(this).attr('data-category-id');
                $('.item_category_selection').css('background-color', '');
                $(this).css('background-color', '#d2d6ed');
                $('.item_category_selection').removeClass('active');
                $(this).addClass('active');
                getItems(localStorage.getItem('item_type'), 1, '', item_category_id)

            });

            // Add To Cart
            $(document).off('click', '.item_selection');
            $(document).on('click', '.item_selection', function (e) {
                e.preventDefault();
                const selected_worker_id = localStorage.getItem('service_worker_id');
                const selected_worker_name = localStorage.getItem('service_worker_name');
                const item_type = localStorage.getItem('item_type');
                const item_id = $(this).data('item-id');

                // if (item_type === 'product') {
                //     const available_count = parseInt($(this).attr('data-available'));
                //     if(available_count > 0){
                //         $(this).attr('data-available', available_count - 1);
                //     }else{
                //         swal('Error...', 'Product Quantity exceeded', 'error');
                //         return false;
                //     }
                // }
                const booking_date = $(document).find('.item_booking_date').val();
                const quantity = 1;
                let decoded_pos_item_data = JSON.parse(localStorage.getItem('pos_item_data') || '[]');
                const existingItemIndex = decoded_pos_item_data.findIndex(item => item.type === item_type && item.item_id === item_id);
                if (localStorage.getItem('service_worker_id') === null) {
                    swal('Error...', 'Please select Worker', 'error');
                    return false;
                }

                const addItem = (data) => {
                    // const workerCommissionPercentage = parseFloat(10) / 100; //worker Commission
                    const workerCommissionPercentage = 0 //worker Commission
                    const workerCommissionAmount = data.final_cost * workerCommissionPercentage;
                    decoded_pos_item_data.push({
                        'type': item_type,
                        'item_id': item_id,
                        'booking_date': booking_date,
                        'quantity': quantity,
                        ...data,
                        'selected_worker_id': selected_worker_id,
                        'selected_worker_name': selected_worker_name,
                        'is_package': 0,
                        'package_id': 0,
                        'notes': null,
                        'commission_data': [{
                            worker_id: selected_worker_id,
                            worker_name: selected_worker_name,
                            worker_commission: data.final_cost.toFixed(2),
                            is_supporting_staff: 0
                        }],
                    });
                };

                if (item_type === 'service') {
                    const service_type = $('.service_type option:selected').val();
                    const service_price_for_home_service = $(this).data('price-for-home-service');
                    const service_price_for_branch = $(this).data('price-for-branch');
                    let service_price = service_type === 'home_service' || service_type === 'home'
                        ? service_price_for_home_service
                        : service_price_for_branch;
                    const item_name = $(this).data('name');

                    if (service_price <= 0) {
                        (async () => {
                            service_price = await getServicePrice();
                            addItem({
                                'price': service_price,
                                'expiry_days': 0,
                                'final_cost': (service_price * quantity),
                                'item_name': item_name,
                                'item_discount_type': 'fixed',
                                'item_discount_value': 0,
                                'item_discount_cost': 0.000,
                                'service_type': service_type,
                                'voucher_value': 0,
                            });
                            localStorage.setItem('pos_item_data', JSON.stringify(decoded_pos_item_data));
                            retrieve_cart_items();
                        })();
                    } else {
                        addItem({
                            'price': service_price,
                            'expiry_days': 0,
                            'final_cost': (service_price * quantity),
                            'item_name': item_name,
                            'item_discount_type': 'fixed',
                            'item_discount_value': 0,
                            'item_discount_cost': 0.000,
                            'service_type': service_type,
                            'voucher_value': 0,
                        });
                    }

                } else if (item_type === 'voucher') {
                    (async () => {
                        const voucher_number = await getVoucherNumber();
                        const price = $(this).data('price');
                        const item_name = $(this).data('name');
                        const voucher_value = $(this).data('value');
                        addItem({
                            'price': price,
                            'final_cost': (price * quantity),
                            'expiry_days': 0,
                            'item_name': item_name,
                            'item_discount_type': 'fixed',
                            'item_discount_value': 0,
                            'item_discount_cost': 0.000,
                            'service_type': 'salon',
                            'voucher_number': voucher_number,
                            'voucher_value': voucher_value,
                        });
                        localStorage.setItem('pos_item_data', JSON.stringify(decoded_pos_item_data));
                        retrieve_cart_items();
                    })();
                } else {
                    const price = $(this).data('price');
                    const expiry_days = $(this).data('days');
                    const item_name = $(this).data('name');

                    if (existingItemIndex !== -1 && item_type === 'product') {
                        decoded_pos_item_data[existingItemIndex].quantity++;
                        decoded_pos_item_data[existingItemIndex].price = price;
                        decoded_pos_item_data[existingItemIndex].final_cost = price * decoded_pos_item_data[existingItemIndex].quantity;
                        const updatedCommissionData = {
                            worker_id: selected_worker_id,
                            worker_name: selected_worker_name,
                            worker_commission: decoded_pos_item_data[existingItemIndex].final_cost.toFixed(2),
                            is_supporting_staff: 0
                        };
                        decoded_pos_item_data[existingItemIndex].commission_data = [updatedCommissionData]
                    } else {
                        if (item_type == 'package') {
                            const isRestrictedCustomer = $(document).find('#is_restricted_customer').val();
                            const customerId = $(document).find('#customer_id').val();
                            if (!customerId || isRestrictedCustomer) {
                                swal('Alert', 'Please Select Customer', 'warning');
                                return false;
                            }
                        }
                        addItem({
                            'price': price,
                            'expiry_days': expiry_days,
                            'final_cost': (price * quantity),
                            'item_name': item_name,
                            'item_discount_type': 'fixed',
                            'item_discount_value': 0,
                            'item_discount_cost': 0.000,
                            'service_type': 'salon',
                            'voucher_number': null,
                            'voucher_value': 0,
                        });
                    }
                }
                localStorage.setItem('pos_item_data', JSON.stringify(decoded_pos_item_data));
                retrieve_cart_items();
            });
            // End To Cart

            $(document).off('click', '.item_type');
            $(document).on('click', '.item_type', function (event) {
                $('.item_type').css('background', 'linear-gradient(to right, #c2e59c, #64b3f4)');
                $(this).css('background', '');
                $(this).css('background-color', '#d2d6ed');

                localStorage.setItem('item_type', $(this).val().toLowerCase());
                let =
                item_type = localStorage.getItem('item_type');
                getItems(item_type, 1);
                $('.item_keyword').val('');
                if (item_type != 'service') {
                    $('.service_type').addClass('hidden');
                } else {
                    $('.service_type').removeClass('hidden');

                }
                if (item_type == 'package' || item_type == 'voucher') {
                    $('.item_categories_div').addClass('hidden')
                        .siblings('.items_div')
                        .removeClass('col-md-6')
                        .addClass('col-md-8');
                } else {
                    $('.item_categories_div').removeClass('hidden')
                        .siblings('.items_div')
                        .addClass('col-md-6')
                        .removeClass('col-md-8');

                    getItemCategories(item_type, 1);
                }
                $('.item_type').not(this).removeClass('btn-secondary active').addClass('btn-outline-secondary');
            });

            $(document).off('change', '.service_type');
            $(document).on('change', '.service_type', function (event) {
                localStorage.setItem('service_type', $('.service_type option:selected').val());
                getItems(localStorage.getItem('item_type'), 1)
            });

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

            $(document).off('keyup', '#voucher_code');
            $(document).on('keyup', '#voucher_code', function () {
                let voucher_code = $(this).val();
                if (voucher_code.length >= 5) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('voucher.validate') }}',
                        data: {
                            voucher_code: voucher_code,
                            customer_id: $(document).find('#customer_id').val(),
                        },
                        success: function (response) {
                            $(document).find('.voucher_balance_remaining, .voucher_expiry_date,.voucher_usage_count').html('-');
                            $(document).find('#voucher_amount').val(0);
                            if (!response.success) {
                                $(document).find('#redeem_voucher_code').val('');
                                $(document).find('.display_voucher_code_error').removeClass('hidden');
                                $(document).find('.display_voucher_code_error').html(response.message);
                                calculateAddedAmounts();
                                return false;
                            }

                            $(document).find('#redeem_voucher_code').val(voucher_code);
                            $(document).find('.voucher_amount_div').removeClass('hidden');
                            $(document).find('.voucher_detail_div').removeClass('hidden');
                            $(document).find('.voucher_code_div').addClass('hidden');
                            $(document).find('.display_voucher_code_error').addClass('hidden');
                            $(document).find('#voucher_amount').val(response.data.voucher.balance);
                            $(document).find('.voucher_balance_remaining').html(parseFloat(response.data.voucher.balance).toFixed(3));
                            $(document).find('.voucher_expiry_date').html(response.data.voucher.expiry_date);
                            $(document).find('.voucher_usage_count').html(response.data.voucher.redeem_voucher_count + '/' + response.data.voucher.voucher_number_of_uses);
                            calculateAddedAmounts();
                        }
                    });
                }
            });

            getItems(localStorage.getItem('item_type'), 1, item_keyword = null, item_category_id = null)
            if (localStorage.getItem('item_type') == 'package' || localStorage.getItem('item_type') == 'voucher') {
                $('.item_categories_div').addClass('hidden')
                    .siblings('.items_div')
                    .removeClass('col-md-6')
                    .addClass('col-md-8');
            } else {
                $('.item_categories_div').removeClass('hidden')
                    .siblings('.items_div')
                    .addClass('col-md-6')
                    .removeClass('col-md-8');

                getItemCategories(localStorage.getItem('item_type'), 1);
            }
            getWorkersByServices('salon', 1);


            $(document).off('click', '.worker_selection');
            $(document).on('click', '.worker_selection', function () {
                let selected_worker_id = $(this).attr('data-id');
                let selected_worker_name = $(this).attr('data-content');
                localStorage.setItem('service_worker_id', selected_worker_id);
                localStorage.setItem('service_worker_name', selected_worker_name);
                service_data();
                $('.worker_selection').css({
                    'background': 'linear-gradient(to right, #c2e59c, #64b3f4)',
                    'box-shadow': '0 0px 0px 0 rgba(0,0,0,0)'
                });
                $(this).css('background', '');
                $(this).css({
                    'background': 'linear-gradient(to right, #d2d6ed, #d2d6ed)',
                    'box-shadow': '0 4px 8px 0 rgba(0,0,0,0.2)'
                });
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
                    retrieve_cart_items();
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
                retrieve_cart_items();
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

            $(document).off('keyup', '#voucher_amount');
            $(document).on('keyup', '#voucher_amount', function () {
                calculateAddedAmounts();
            });

            $(document).off('keyup', '#advance_amount');
            $(document).on('keyup', '#advance_amount', function () {
                calculateAddedAmounts();
            });

            $(document).off('keyup', '#loyalty_amount');
            $(document).on('keyup', '#loyalty_amount', function () {
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

            $(document).off('click', '.redeem_package_service');
            $(document).on('click', '.redeem_package_service', function (e) {
                let storage_pos_item_data = localStorage.getItem('pos_item_data');
                let customer_id = $(document).find('#customer_id').val();
                let selected_services_ids = [];
                if (storage_pos_item_data !== null && storage_pos_item_data !== '[]') {
                    let decoded_pos_item_data = JSON.parse(storage_pos_item_data);
                    $.each(decoded_pos_item_data, function (index, decoded_service) {
                        if (decoded_service.type == 'service') {
                            selected_services_ids.push(decoded_service.item_id);
                        }
                    });
                }
                if (selected_services_ids.length < 1) {
                    swal('Alert', 'Please Select Service To Redeem Package', 'warning')
                    return false;
                }
                if (customer_id == '') {
                    swal('Alert', 'Please Select Customer', 'warning')
                    return false;
                }
                $(document).find('.service_package_list_modal').modal('show');
                var url = '{{ route('customer.package.services') }}';
                url += '?customer_id=' + customer_id + '&service_ids=' + selected_services_ids;
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        $(document).find('.service_package_list_modal_body').html(response.data.item_html);
                        let storage_selected_service_package = localStorage.getItem('redeem_service_package_data');
                        ;
                        if (storage_selected_service_package !== null && storage_selected_service_package !== '[]') {
                            decoded_selected_service_package = $.parseJSON(storage_selected_service_package);

                            decoded_selected_service_package.forEach(function (value) {
                                $(`.common_radio_package[data-service-id='${value.serviceId}'][data-package-id='${value.packageId}']`).prop("checked", true);
                            });
                        }
                    }
                });
            });

            $(document).off('click', '.redeem_service_submit_button');
            $(document).on('click', '.redeem_service_submit_button', function (event) {
                event.preventDefault();

                const selectedServicePackage = $(".service_package_tr input[type='radio']:checked");
                const selectedData = [];
                selectedServicePackage.each(function () {
                    let storage_items = localStorage.getItem('pos_item_data');
                    if (storage_items !== null && storage_items !== '[]') {
                        decoded_items = $.parseJSON(storage_items);
                        var serviceRecordAndIndex = findServiceRecordAndIndex(decoded_items, $(this).attr("data-service-id"));
                        if (serviceRecordAndIndex.record !== null) {
                            const service_type = localStorage.getItem('service_type') ?? $('.service_type option:selected').val();
                            let commission_value = $(this).attr("data-salon-price");
                            if (service_type == 'home') {
                                commission_value = $(this).attr("data-home-price");
                            }
                            selectedData.push({
                                serviceId: $(this).attr("data-service-id"),
                                packageId: $(this).attr("data-package-id"),
                                commission: commission_value,
                                workerId: serviceRecordAndIndex.record.selected_worker_id
                            });
                        }
                    }
                });

                if (selectedData.length > 0) {
                    selectedData.forEach(function (selected_items) {
                        let storage_items = localStorage.getItem('pos_item_data');
                        if (storage_items !== null && storage_items !== '[]') {
                            decoded_items = $.parseJSON(storage_items);
                            var serviceRecordAndIndex = findServiceRecordAndIndex(decoded_items, selected_items.serviceId);
                            if (serviceRecordAndIndex.record !== null) {
                                local_package_id = 0;
                                if (selected_items.packageId > 0) {
                                    local_package_id = 1;
                                }
                                commission_data = [];
                                commission_data_length = serviceRecordAndIndex.record.commission_data.length;
                                if (commission_data_length > 0) {
                                    serviceRecordAndIndex.record.commission_data.forEach(function (commission) {
                                        commission.worker_commission = (selected_items.commission / commission_data_length)
                                    })
                                }
                                serviceRecordAndIndex.record.is_package = local_package_id;
                                serviceRecordAndIndex.record.package_id = selected_items.packageId;
                                serviceRecordAndIndex.record.commission = selected_items.commission;
                                decoded_items[serviceRecordAndIndex.index] = serviceRecordAndIndex.record;
                                localStorage.setItem('pos_item_data', JSON.stringify(decoded_items));
                            }
                        }
                    });
                    localStorage.setItem('redeem_service_package_data', JSON.stringify(selectedData));
                }
                $(document).find('.service_package_list_modal').modal('hide');
                retrieve_cart_items();
            });

            init_select2();

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

            document.querySelector('.close_pos').addEventListener('mouseover', function () {
                this.classList.add('btn-danger');
            });

            document.querySelector('.close_pos').addEventListener('mouseout', function () {
                this.classList.remove('btn-danger');
            });

            $(document).off('click', '.add_balance');
            $(document).on('click', '.add_balance', function (e) {
                e.preventDefault();
                if (customer_slug == null || customer_slug == '') {
                    swal('Error...', 'Please select Customer', 'error');
                    return false;
                }
                let $_this = $(this);
                manageCustomerBalance('Add Balance', $_this, 'credit');
            });

            $(document).off('click', '.refund_balance');
            $(document).on('click', '.refund_balance', function (e) {
                e.preventDefault();
                if (customer_slug == null || customer_slug == '') {
                    swal('Error...', 'Please select Customer', 'error');
                    return false;
                }
                let $_this = $(this);
                manageCustomerBalance('Refund Balance', $_this, 'debt');
            });
        });

        function getCustomerByPhone(phone, is_edit = false) {
            $.ajax({
                type: 'GET',
                url: '',
                data: {
                    phone: phone,
                },
                success: function (response) {
                    if (!response.success) {
                        $(document).find('#phone').attr('readonly', false);
                        $(document).find('.customer_password_section').removeClass('d-none');
                        $(document).find('.display_customer_error').removeClass('d-none');
                        return false;
                    }

                    if (is_edit) {
                        editCustomer(response.data);
                    } else {
                        let customer_detail_route = '{{ url('customers') }}/' + response.data.customer.slug;
                        $(document).find('.display_customer_error, .display_customer_phone_input, .display_customer_data').addClass('d-none');
                        $(document).find('.display_customer_div').removeClass('d-none');
                        $(document).find('.display_customer_name').text(response.data.customer.name).attr('href', customer_detail_route);
                        $(document).find('.display_customer_phone').text(response.data.customer.phone);
                        $(document).find('#customer_id').val(response.data.customer.id);
                        $(document).find('#is_restricted_customer').val(response.data.customer.is_restricted_customer);
                        $(document).find('#customer_slug').val(response.data.customer.slug);
                        customer_slug = response.data.customer.slug;
                        $(document).find('#available_loyalty').val(response.data.customer.available_loyalty);
                        $(document).find('#available_loyalty_amount').val(response.data.customer.available_loyalty_amount);
                        $(document).find('#customer_advance_balance').val(response.data.customer.customer_advance_balance);
                        $(document).find('.customer_detail_customer_available_balance').html(response.data.customer.customer_advance_balance);
                        $(document).find('.advance_balance_remaining').html(response.data.customer.customer_advance_balance);
                        inputText = response.data.customer.internal_notes.substring(0, 30);
                        if (inputText != "") {
                            $(document).find('.customer_notes').html(inputText + '<i class="fa fa-info-circle" title="' + response.data.customer.internal_notes + '"></i>');
                        }
                        if (response.data.customer.customer_advance_balance <= 0) {
                            $(document).find('.payment_control_modal').find('.advance_amount_div').addClass('hidden');
                        } else {
                            $(document).find('.payment_control_modal').find('.advance_amount_div').removeClass('hidden');
                        }
                    }

                    localStorage.setItem('customer', JSON.stringify(response.data.customer));
                }
            });
        }

        function manageCustomerBalance(title, $_this, type) {
            let options = generatePaymentTypeOptions();
            Swal.fire({
                title: title,
                icon: "warning",
                html: `<select id="payment_type" class="form-control mb-2">${options}</select>
                            <input type="number" class="form-control mb-2" id="amount" placeholder="Enter amount" name="balance_amount">
                            <textarea id="notes" class="form-control" placeholder="Type something here..." rows="2">`,
                confirmButtonText: 'Submit',
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    return {
                        payment_type: Swal.getPopup().querySelector('#payment_type').value,
                        amount: Swal.getPopup().querySelector('#amount').value,
                        notes: Swal.getPopup().querySelector('#notes').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let entered_amount = result.value.amount !== '' ? parseFloat(result.value.amount) : 0;

                    if (entered_amount < 1) {
                        swal('Error...', 'Please add value more than zero.', 'error')
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
                            payment_type_id: result.value.payment_type,
                            amount: entered_amount,
                            customer_slug: customer_slug,
                            notes: result.value.notes,
                            type: type,
                        },
                        success: function (response) {
                            if (!response.success) {
                                swal('Error...', response.message, 'error')
                                return false;
                            }
                            let balance_type = 'Refunded';
                            if (type == 'credit') {
                                balance_type = 'Added';
                            }
                            swal({
                                title: "Success",
                                icon: 'success',
                                text: 'Balance ' + balance_type + ' Successfully',
                                type:
                                    "success"
                            }).then(function () {
                                    location.reload();
                                }
                            );
                        }
                    });
                }
            });
        }

        function hideAllSections() {
            $('.main_div_common_selection').addClass('hidden');
        }

        function resetAllButtons() {
            $('.section-button').removeClass('btn-primary').addClass('btn-outline-primary');
        }

        function updateWorkerCommissions(workerIds) {
            var selectedCommissionType = $('.split_type:checked').val();

            workerIds.forEach(function (id) {
                var equalValue;
                if (selectedCommissionType === 'percentage') {
                    equalValue = 100 / workerIds.length;
                } else {
                    equalValue = $('.selected_service_final_price').val() / workerIds.length;
                }
                $('.individual_worker_commission_' + id + ' .worker_commission_input').val(equalValue);
            });
        }

        function calculateTotalCommission() {
            let totalCommission = 0;
            $('.worker_commission_input').each(function () {
                const commission = parseFloat($(this).val());
                if (!isNaN(commission)) {
                    totalCommission += commission;
                }
            });
            return totalCommission;
        }

        function init_select2() {
            $(document).find('.select2').select2({
                placeholder: 'Please select a value',
                allowClear: true,
                closeOnSelect: false
            });
        }

        let counter = 0;

        function generateUniqueNumber() {
            const ipv6Address = [];
            for (let i = 0; i < 8; i++) {
                const segment = Math.floor(Math.random() * 0xFFFF).toString(16).padStart(4, '0');
                ipv6Address.push(segment);
            }

            const concatenatedIPv6 = ipv6Address.join('');
            const decimalNumber = parseInt(concatenatedIPv6, 16);
            const sixDigitNumber = decimalNumber % 1000000;

            return sixDigitNumber.toString().padStart(6, '0');
        }

        async function getVoucherNumber() {
            const uniqueNumber = generateUniqueNumber();
            return new Promise((resolve) => {
                let voucher_number = null;
                Swal.fire({
                    title: 'Voucher Number',
                    icon: "warning",
                    html: `<input type="text" class="form-control mb-2" id="voucher_number" placeholder="Enter Voucher Number" readonly value="${uniqueNumber}">`,
                    confirmButtonText: 'Submit',
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            voucher_number: Swal.getPopup().querySelector('#voucher_number').value,
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        voucher_number = result.value.voucher_number;
                        resolve(voucher_number);
                    }
                });
            });
        }

        async function getServicePrice() {
            return new Promise((resolve) => {
                let service_price = null;
                Swal.fire({
                    title: 'Service Price',
                    icon: "warning",
                    html: `<input type="number" class="form-control mb-2" id="service_price" placeholder="Enter Service Price">`,
                    confirmButtonText: 'Submit',
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            service_price: Swal.getPopup().querySelector('#service_price').value,
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        service_price = result.value.service_price;
                        resolve(service_price);
                    }
                });
            });
        }

        function findServiceRecordAndIndex(decoded_items, item_id_to_find) {
            var result = {
                record: null,
                index: -1
            };

            decoded_items.forEach(function (record, index) {
                if (record.item_id == item_id_to_find && record.type == 'service') {
                    result.record = record;
                    result.index = index;
                    return false;
                }
            });

            return result;
        }

        function retrieve_cart_items() {
            let storage_pos_item_data = localStorage.getItem('pos_item_data');
            if (storage_pos_item_data !== null && storage_pos_item_data !== '[]') {
                $('.service_type').prop('disabled', true);
                let decoded_pos_item_data = JSON.parse(storage_pos_item_data);

                let item_row = '';
                let invoice_total = 0;
                let total_item_discount_cost = 0;
                $.each(decoded_pos_item_data, function (index, decoded_service) {
                    let commission_section = '';

                    $.each(decoded_service.commission_data, function (index1, commission) {
                        let comma = (decoded_service.commission_data.length - 1 === index1) ? '' : ', ';
                        commission_section += commission.worker_name + '=' + commission.worker_commission + comma;
                    });

                    let final_cost = decoded_service.final_cost;
                    let price = decoded_service.price;
                    let item_discount_cost = decoded_service.item_discount_cost ? decoded_service.item_discount_cost : 0;
                    if (item_discount_cost > 0) {
                        total_item_discount_cost += parseFloat(item_discount_cost);
                    }
                    let is_edit = true;
                    if (decoded_service.is_package == 1) {
                        final_cost = 0;
                        price = 0;
                        item_discount_cost = 0;
                    }
                    let item_name = decoded_service.item_name;
                    if (decoded_service.type == 'voucher') {
                        item_name = decoded_service.item_name + '(' + decoded_service.voucher_number + ')';
                        is_edit = false;
                    }
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
                    item_row += '<td class="align-middle">' + parseFloat(item_discount_cost).toFixed(3) + ' </td>';
                    item_row += '<td class="align-middle">' + parseFloat(final_cost).toFixed(3) + ' </td>';
                    item_row += '<td class="align-middle">' + decoded_service.selected_worker_name + ' </td>';
                    item_row += '<td class="align-middle">' + commission_section + ' </td>';
                    item_row += '</tr>';

                    invoice_total += final_cost;
                });

                let footer_row = '' +
                    '<tr><td colspan="4" align="right"><strong>Sub Total</strong></td><td id="sub_invoice_total">' + parseFloat(parseFloat(invoice_total) + parseFloat(total_item_discount_cost)).toFixed(3) + '</td><td></td><td></td></tr>';
                footer_row +=
                    '<tr><td colspan="4" align="right"><strong>Total Discount</strong></td><td id="discount_total">' + parseFloat(total_item_discount_cost).toFixed(3) + '</td><td></td><td></td></tr>';
                footer_row += '<tr><td colspan="4" align="right"><strong>Invoice Cost</strong></td><td id="invoice_total">' + parseFloat(invoice_total).toFixed(3) + '</td><td></td><td></td></tr>';

                $(document).find('#customer_bookings').html(item_row);
                $(document).find('#customer_bookings_footers').html(footer_row);
            } else {
                localStorage.removeItem('pos_item_data');
                $(document).find('#customer_bookings').html('<tr><td colspan="7">No record found</td></tr>');
                $(document).find('#customer_bookings_footers').html('');
                $('.service_type').prop('disabled', false);
            }
        }

        function editCustomer(data) {
            $(document).find('.customer_form_method').val('put');
            $(document).find('#name').val(data.customer.name);
            $(document).find('#email').val(data.customer.email);
            $(document).find('#phone').val(data.customer.phone).attr('readonly', true);
            $(document).find('#height').val(data.customer.height);
            $(document).find('#weight').val(data.customer.weight);
            $(document).find('#picture').val(data.customer.picture);
            $(document).find('.customer_password_section').addClass('d-none');
            $(document).find('#birth_date').val(data.customer.birth_date);
            $(document).find('#internal_notes').val(data.customer.internal_notes);

            $('.customer_form').attr('action', '{{ url('customers') }}/' + data.customer.id);
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
                    $('#pos_invoice_number').html(response.data.booking_data.invoice_number)
                    retrieve_cart_items();
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


        let totalItemPages;

        function getItems(item_type, pageNumber, item_keyword = null, item_category_id = null) {
            $.ajax({
                type: 'get',
                url: '{{ route('items.details') }}',
                data: {
                    service_type: localStorage.getItem('service_type'),
                    item_type: item_type,
                    item_keyword: item_keyword,
                    item_category_id: item_category_id,
                    page: pageNumber,
                    perPage: 10
                },
                success: function (response) {
                    if (response.data.item_html == '') {
                        $(document).find('.items_container').html('<h6 class="text-warning d-flex justify-content-center align-items-center" style="height: 500px; margin-left: 0;">No Record Found...</h6>');
                        return false;
                    }

                    if (response.data.is_barcode && response.data.item_type === 'product') {
                        const selected_worker_id = localStorage.getItem('service_worker_id');
                        const selected_worker_name = localStorage.getItem('service_worker_name');
                        if (selected_worker_id === null) {
                            swal('Error...', 'Please select Worker', 'error');
                            return false;
                        }

                        let decoded_pos_item_data = JSON.parse(localStorage.getItem('pos_item_data') || '[]');
                        const existingItemIndex = decoded_pos_item_data.findIndex(item => item.type === response.data.item_type && item.item_id === response.data.item.id);

                        if (existingItemIndex !== -1 && response.data.item_type === 'product') {
                            decoded_pos_item_data[existingItemIndex].quantity++;
                            decoded_pos_item_data[existingItemIndex].price = response.data.item.price;
                            decoded_pos_item_data[existingItemIndex].final_cost = response.data.item.price * decoded_pos_item_data[existingItemIndex].quantity;
                            const updatedCommissionData = {
                                worker_id: selected_worker_id,
                                worker_name: selected_worker_name,
                                worker_commission: decoded_pos_item_data[existingItemIndex].final_cost.toFixed(2),
                                is_supporting_staff: 0
                            };
                            decoded_pos_item_data[existingItemIndex].commission_data = [updatedCommissionData]
                        } else {
                            decoded_pos_item_data.push({
                                'type': response.data.item_type,
                                'item_id': response.data.item.id,
                                'booking_date': $(document).find('.item_booking_date').val(),
                                'quantity': 1,
                                'price': response.data.item.price,
                                'final_cost': (response.data.item.price * 1),
                                'item_name': response.data.item.name,
                                'item_discount_type': 'fixed',
                                'item_discount_value': 0,
                                'item_discount_cost': 0.000,
                                'service_type': 'salon',
                                'voucher_number': null,
                                'voucher_value': 0,
                                'selected_worker_id': selected_worker_id,
                                'selected_worker_name': selected_worker_name,
                                'is_package': 0,
                                'package_id': 0,
                                'notes': null,
                                'commission_data': [{
                                    worker_id: selected_worker_id,
                                    worker_name: selected_worker_name,
                                    worker_commission: response.data.item.price.toFixed(2),
                                    is_supporting_staff: 0
                                }]
                            });
                        }

                        localStorage.setItem('pos_item_data', JSON.stringify(decoded_pos_item_data));
                        retrieve_cart_items();
                        $(document).find('input[name="item_keyword"]').val('');
                    } else {
                        $(document).find('.items_container').html(response.data.item_html);
                        totalItemPages = response.data.item_total_pages;
                        // updateButtonStates(pageNumber, totalItemPages, "#previous-button-item", "#next-button-item")
                        updateItemsButtonStates()
                    }
                }
            });
        }

        let currentItemPage = 1;

        function updateItemsButtonStates() {
            $("#next-button-item").prop("disabled", false);
            $("#previous-button-item").prop("disabled", false);
            $("#previous-button-item").removeClass("hidden");
            if (currentItemPage === 1) {
                $("#previous-button-item").prop("disabled", true);
                $("#previous-button-item").addClass("hidden");
            }

            if (totalItemPages > 1) {
                $("#next-button-item").removeClass("hidden");
            }

            if (currentItemPage === totalItemPages) {
                $("#next-button-item").addClass("hidden");
                $("#next-button-item").prop("disabled", true);
            }
        }

        function handleNextButtonClick(type) {
            currentItemPage++;
            getItems(type, currentItemPage);
        }

        function handlePreviousButtonClick(type) {
            if (currentItemPage > 1) {
                currentItemPage--;
                getItems(type, currentItemPage);
            }
        }

        document.getElementById('next-button-item').addEventListener('click', function () {
            handleNextButtonClick(localStorage.getItem('item_type'));
        });

        document.getElementById('previous-button-item').addEventListener('click', function () {
            handlePreviousButtonClick(localStorage.getItem('item_type'));
        });

        // Item Category
        let totalItemCategoryPages;

        function getItemCategories(item_type, pageNumber, item_keyword = null, item_category_id = null) {
            $.ajax({
                type: 'get',
                url: '{{ route('item_categories.details') }}',
                data: {
                    item_type: item_type,
                    item_keyword: item_keyword,
                    item_category_id: item_category_id,
                    page: pageNumber,
                    perPage: 10
                },
                success: function (response) {
                    if (response.data.item_category_html == '') {
                        $(document).find('.item_category_container').html('<h6 class="text-warning">No Record Found...</h6>');
                        return false;
                    }
                    $(document).find('.item_category_container').html(response.data.item_category_html);

                    totalItemCategoryPages = response.data.item_category_total_pages;
                    // updateButtonStates(pageNumber, totalItemCategoryPages, "#previous-button-item-category", "#next-button-item-category")
                    updateItemCategoriesButtonStates();
                }
            });
        }

        let currentItemCategoryPage = 1;

        function updateItemCategoriesButtonStates() {
            $("#next-button-item-category").prop("disabled", false);
            $("#previous-button-item-category").prop("disabled", false);
            $("#previous-button-item-category").removeClass("hidden");

            if (currentItemCategoryPage === 1) {
                $("#previous-button-item-category").prop("disabled", true);
                $("#previous-button-item-category").addClass("hidden");
            }

            if (totalItemCategoryPages > 1) {
                $("#next-button-item-category").removeClass("hidden");
            }

            if (currentItemCategoryPage === totalItemCategoryPages) {
                $("#next-button-item-category").prop("disabled", true);
                $("#next-button-item-category").addClass("hidden");
            }
        }

        function handleItemCategoryNextButtonClick(type) {
            currentItemCategoryPage++;
            getItemCategories(type, currentItemCategoryPage);
        }

        function handleItemCategoryPreviousButtonClick(type) {
            if (currentItemCategoryPage > 1) {
                currentItemCategoryPage--;
                getItemCategories(type, currentItemCategoryPage);
            }
        }


        document.getElementById('next-button-item-category').addEventListener('click', function () {
            handleItemCategoryNextButtonClick(localStorage.getItem('item_type'));
        });

        document.getElementById('previous-button-item-category').addEventListener('click', function () {
            handleItemCategoryPreviousButtonClick(localStorage.getItem('item_type'));
        });

        // End Item Category

        // Start Worker Data
        function getWorkersByServices(service_type, pageNumber) {
            $.ajax({
                type: 'get',
                url: "{{route('workers.details')}}",
                data: {
                    service_type: service_type,
                    page: pageNumber,
                    perPage: 6
                },
                success: function (response) {
                    if (response.data.item_html == '') {
                        $(document).find('.worker_container').html('<h6 class="text-warning">No Worker Found...</h6>');
                        return false;
                    }
                    $(document).find('.worker_container').html(response.data.item_html);

                    totalWorkerPages = response.data.item_total_pages;
                    // updateButtonStates(pageNumber, totalWorkerPages, "#previous-button-worker", "#next-button-worker")
                    updateWorkersButtonStates()
                }
            });
        }

        let currentWorkerPage = 1;

        function updateWorkersButtonStates() {
            $("#next-button-worker").prop("disabled", false);
            $("#previous-button-worker").prop("disabled", false);
            $("#previous-button-worker").removeClass("hidden");

            if (currentWorkerPage === 1) {
                $("#previous-button-worker").prop("disabled", true);
                $("#previous-button-worker").addClass("hidden");
            }

            if (totalItemCategoryPages > 1) {
                $("#next-button-worker").removeClass("hidden");
            }

            if (currentWorkerPage === totalWorkerPages) {
                $("#next-button-worker").prop("disabled", true);
                $("#next-button-worker").addClass("hidden");
            }
        }

        function handleWorkerNextButtonClick(type) {
            currentWorkerPage++;
            getWorkersByServices('salon', currentWorkerPage);
        }

        function handleWorkerPreviousButtonClick(type) {
            if (currentWorkerPage > 1) {
                currentWorkerPage--;
                getWorkersByServices('salon', currentWorkerPage);
            }
        }


        document.getElementById('next-button-worker').addEventListener('click', function () {
            handleWorkerNextButtonClick(localStorage.getItem('item_type'));
        });

        document.getElementById('previous-button-worker').addEventListener('click', function () {
            handleWorkerPreviousButtonClick(localStorage.getItem('item_type'));
        });

        // End Worker Data

        // function updateButtonStates(page, totalPages, prevButtonSelector, nextButtonSelector) {
        //     $(prevButtonSelector).prop("disabled", false);
        //     $(nextButtonSelector).prop("disabled", false);
        //     $(prevButtonSelector).removeClass("hidden");
        //     if (page === 1) {
        //         $(prevButtonSelector).prop("disabled", true);
        //         $(prevButtonSelector).addClass("hidden");
        //     }

        //     if (totalPages > 1) {
        //         $(nextButtonSelector).removeClass("hidden");
        //     }

        //     if (page === totalPages) {
        //         $(nextButtonSelector).addClass("hidden");
        //         $(nextButtonSelector).prop("disabled", true);
        //     }
        // }

        // function handlePageNavigation(buttonId, nextPageCallback, prevPageCallback, type) {
        //     let currentPage = 1;

        //     function handleNextButtonClick() {
        //         console.log(buttonId, nextPageCallback, prevPageCallback, type);
        //         currentPage++;
        //         nextPageCallback(type, currentPage);
        //     }

        //     function handlePreviousButtonClick() {
        //         if (currentPage > 1) {
        //             currentPage--;
        //             prevPageCallback(type, currentPage);
        //         }
        //     }

        //     document.getElementById(`next-button-${buttonId}`).addEventListener('click', function () {
        //         handleNextButtonClick();
        //     });

        //     document.getElementById(`previous-button-${buttonId}`).addEventListener('click', function () {
        //         handlePreviousButtonClick();
        //     });
        // }

        // handlePageNavigation('item', getItems, getItems, localStorage.getItem('item_type'));
        // handlePageNavigation('item-category', getItemCategories, getItemCategories, localStorage.getItem('item_type'));
        // handlePageNavigation('worker', getWorkersByServices, getWorkersByServices, 'salon');

        function clear_local_storage() {
            const itemsToRemove = [
                'pos_item_data',
                'service_worker_id',
                'service_booking_date',
                'service_schedule_time',
                'service_supporting_staff_ids',
                'service_worker_name',
                'customer',
                'item_type',
                'service_type',
                'redeem_service_package_data',
                'selected_item_row_index',
                'selected_item_row_type'
            ];

            for (const item of itemsToRemove) {
                localStorage.removeItem(item);
            }
        }

        function service_data() {
            $('.local_storage_worker').html(localStorage.getItem('service_worker_name'));
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
                    clear_local_storage();
                    $(document).find('.payment_control_modal').modal('hide');

                    swal({
                        title: "Success", icon: 'success', text: 'Invoice Saved Successfully', type:
                            "success"
                    }).then(function () {
                            {{--if ({{$is_invoice_print}} == 1) {--}}
                            printInvoice(response.data.invoice_number, 1);
                            // }
                            // clear_local_storage();
                            retrieve_cart_items();
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
