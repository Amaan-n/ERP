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


        .floating-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s;
        }

        .floating-btn:hover {
            background-color: #0056b3;
        }

        .action-list {
            position: fixed;
            bottom: 90px;
            right: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            display: none;
        }

        .action-list.active {
            display: block;
        }

        .action-list ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .action-list li {
            padding: 10px;
            text-align: center;
            cursor: pointer;
        }

        .action-list li:hover {
            background-color: #f5f5f5;
        }
    </style>

    <div class="pos_container border border-dark position-relative h-100">

        <div class="card card-custom position-absolute w-100" style="top: 0">
            <div class="card-body min-h-300px"
                 style="background: linear-gradient(to right, #feac5e, #c779d0, #4bc0c8)">

            </div>
        </div>

        <div class="w-100 d-flex p-0 m-0">
            <div class="w-50 px-5">
                <div style="height: 3vh;"></div>
                <div class="card card-custom w-100" style="height: 15vh">
                    <div class="card-body">
                        <div class="input-group mb-5 display_customer_data">
                            <input type="text" class="form-control display_customer_phone_input"
                                   placeholder="Enter customer's phone"
                                   value="{{ \Illuminate\Support\Facades\Session::has('phone') ? \Illuminate\Support\Facades\Session::get('phone') : '' }}">
                            <div class="input-group-append">
                                <a class="btn btn-outline-secondary search_customer">
                                    <i class="fa fa-search"> </i>
                                </a>
                                <a class="btn btn-outline-secondary create_new_customer">
                                    <i class="fa fa-plus"> </i>
                                </a>
                            </div>
                        </div>
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

                        <div class="d-flex justify-content-between font-size-lg font-weight-bold">
                            <span
                                class="pos_invoice_number border border-light-dark px-5 py-1">{{ $invoice_number }}</span>
                            <span class="text-secondary booking_date border border-light-dark px-5 py-1">
                                    {{ \Carbon\Carbon::now()->tz('Asia/Kuwait')->format('dS F Y h:i A') }}
                                </span>
                        </div>
                    </div>
                </div>
                <div style="height: 3vh;"></div>
                <div class="card card-custom p-3" style="height: 75vh">
                    <input type="hidden" name="booking_data" id="booking_data" value="">
                    <input type="hidden" name="invoice_number" id="invoice_number" value="MER-000616">
                    <input type="hidden" name="customer_id" class="pos_customer_id" value="">

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
                            <tbody class="customer_bookings">
                            <tr>
                                <td colspan="4">No record found</td>
                            </tr>
                            </tbody>
                            <tfoot class="customer_bookings_footer"></tfoot>
                        </table>
                    </div>
                </div>
                <div style="height: 3vh;"></div>
            </div>

            <div class="w-50 pr-5">
                <div style="height: 3vh;"></div>
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
            </div>
        </div>
    </div>

    <button class="floating-btn" id="floatingButton">
        <i class="fa fa-plus text-white font-size-h1"></i>
    </button>

    <div class="action-list" id="actionList">
        <div class="card card-custom p-5">
            <div class="d-flex flex-wrap justify-content-center">
                <a href="javascript:void(0);"
                   class="btn mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white product_categories_button"
                   style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                    Filter By Category
                </a>
                <a href="javascript:void(0);"
                   class="btn mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white new_invoice"
                   style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                    New Invoice
                </a>
                <a href="{{ route('pos.index') }}"
                   class="btn mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white"
                   style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                    Search
                </a>
                <a href="javascript:void(0);"
                   class="btn mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white print_invoice"
                   style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                    <span class="navi-text">
                        Print Invoice
                    </span>
                </a>
                <button
                    class="btn mr-2 p-5 border-0 font-size-h4 font-weight-bold text-white payment_popup_button"
                    style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                    Book & Pay
                </button>

                <button
                    class="btn p-5 border-0 font-size-h4 font-weight-bold text-white close_pos"
                    style="background: linear-gradient(to right, #1a2980, #26d0ce)">
                    Close
                </button>
            </div>
        </div>
    </div>

    @include('pos.modal.customers')
    @include('pos.modal.create_customer')
    @include('pos.modal.edit_items')
    @include('pos.modal.payment_control')
    @include('pos.modal.categories')
@stop

@section('page_js')
    <script type="text/javascript">
        const floatingButton = document.getElementById('floatingButton');
        const actionList = document.getElementById('actionList');

        floatingButton.addEventListener('click', () => {
            actionList.classList.toggle('active');
        });

        let arr = [];
        $(document).ready(function () {
            initSelect2();
            getItems();
            retrieveCartItems();

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
                $(document).find('.pos_customer_id').val('');
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

            $(document).off('click', '.product_categories_button');
            $(document).on('click', '.product_categories_button', function (e) {
                $(document).find('.product_categories_modal').modal('show');
            });

            $(document).off('click', '.item_category_selection');
            $(document).on('click', '.item_category_selection', function () {
                $(document).find('.item_category_selection').css('background-color', '');
                $(document).find('.item_category_selection').removeClass('active');

                $(this).css('background-color', '#d2d6ed');
                $(this).addClass('active');

                getItems('', $(this).attr('data-category-id'))

                setTimeout(function () {
                    $(document).find('.product_categories_modal').modal('hide');
                }, 300)
            });

            $(document).off('click', '.item_selection');
            $(document).on('click', '.item_selection', function (e) {
                e.preventDefault();
                const product_id = $(this).attr('data-product-id');
                let decoded_pos_items = JSON.parse(localStorage.getItem('pos_items')) || [];
                const existing_item_index = decoded_pos_items.findIndex(item => item.product_id === product_id);

                const addItem = (data) => {
                    decoded_pos_items.push({
                        'type': 'product',
                        'product_id': product_id,
                        'quantity': 1,
                        ...data,
                    });
                };

                const per_item_price = $(this).attr('data-per-item-price');

                if (existing_item_index !== -1) {
                    decoded_pos_items[existing_item_index].quantity++;
                    decoded_pos_items[existing_item_index].per_item_price = per_item_price;
                    decoded_pos_items[existing_item_index].final_price = per_item_price * decoded_pos_items[existing_item_index].quantity;
                } else {
                    addItem({
                        'per_item_price': per_item_price,
                        'final_price': (per_item_price * 1),
                        'name': $(this).attr('data-name'),
                    });
                }

                localStorage.setItem('pos_items', JSON.stringify(decoded_pos_items));
                retrieveCartItems();
            });

            $(document).off('click', '.edit_invoice_item');
            $(document).on('click', '.edit_invoice_item', function (e) {
                e.preventDefault();
                let index = $(this).closest('tr').attr('data-index');
                let decoded_items = $.parseJSON(localStorage.getItem('pos_items')) || [];
                let individual_item = decoded_items.find((ds, ds_index) => ds_index == index);

                if (individual_item === undefined) {
                    swal('Error...', 'Unable to find the data for the selected item.', 'error');
                    return false;
                }

                let modal_selector = $(document).find('.edit_item_model');
                modal_selector.modal('show');
                modal_selector.find('.edit_item_submit_button').attr('data-index', index);
                modal_selector.find('.item_quantity').val(individual_item.quantity);
                modal_selector.find('.per_item_price').val(individual_item.per_item_price);
                setTimeout(function () {
                    modal_selector.find('.item_quantity').focus();
                }, 500)
            })

            $(document).off('click', '.edit_item_submit_button');
            $(document).on('click', '.edit_item_submit_button', function (e) {
                e.preventDefault();
                let index = $(this).attr('data-index');
                let modal_selector = $(this).closest('.edit_item_model');
                let entered_quantity = modal_selector.find('.item_quantity').val();
                let entered_price = modal_selector.find('.per_item_price').val();
                let entered_final_price = entered_price * entered_quantity;

                if (isNaN(entered_quantity) || entered_quantity < 1) {
                    swal('Error...', 'Quantity should be greater than or equal to 1.', 'error');
                    return false;
                }

                if (isNaN(entered_price) || entered_price <= 0) {
                    swal('Error...', 'Per item price should be greater than or equal to 1.', 'error');
                    return false;
                }

                let decoded_items = $.parseJSON(localStorage.getItem('pos_items')) || [];
                let individual_item = decoded_items.find((ds, ds_index) => ds_index == index);

                if (individual_item === undefined) {
                    swal('Error...', 'Unable to find the data for the selected item.', 'error');
                    return false;
                }

                individual_item.per_item_price = entered_price;
                individual_item.quantity = entered_quantity;
                individual_item.final_price = entered_final_price;
                decoded_items[index] = individual_item;
                localStorage.setItem('pos_items', JSON.stringify(decoded_items));

                $(document).find('.edit_item_model').modal('hide');
                retrieveCartItems();
            });

            $(document).off('click', '.remove_invoice_item');
            $(document).on('click', '.remove_invoice_item', function () {
                let index = $(this).closest('tr').attr('data-index');
                let decoded_items = $.parseJSON(localStorage.getItem('pos_items')) || [];
                let filtered_items = decoded_items.filter((ds, ds_index) => ds_index != index);
                localStorage.setItem('pos_items', JSON.stringify(filtered_items));

                $(this).closest('tr').remove();
                retrieveCartItems();
            });

            $(document).off('click', '.selected_item_row');
            $(document).on('click', '.selected_item_row', function () {
                localStorage.setItem('selected_item_index', $(this).data('index'));
                $('.selected_item_row').removeClass('clicked');
                $(this).addClass('clicked');
            });

            $(document).off('click', '.payment_popup_button');
            $(document).on('click', '.payment_popup_button', function () {
                let customer_id = $(document).find('.pos_customer_id').val();
                if (!customer_id) {
                    getCustomerByPhone('65643177');
                }

                let validation_message = '';
                let storage_pos_items = localStorage.getItem('pos_items');
                if (!storage_pos_items) {
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

                let invoice_total = parseFloat($('.total_invoice_amount').html()).toFixed(3);
                $(document).find('.invoice_amount').html(invoice_total);
                $(document).find('.invoice_payable_amount').html(invoice_total);

                calculateEnteredAmount();
            });

            $('.payment_type_input').on('input', function () {
                calculateEnteredAmount();
            });

            $(document).off('click', '.invoice_input_discount_type');
            $(document).on('click', '.invoice_input_discount_type', function () {
                calculateEnteredAmount();
            });

            $(document).off('keyup', '.invoice_input_discount');
            $(document).on('keyup', '.invoice_input_discount', function () {
                calculateEnteredAmount();
            });

            $(document).off('click', '.payment_popup_submit_button');
            $(document).on('click', '.payment_popup_submit_button', function () {
                bookAndProceed();
            });

            $(document).off('click', '.print_invoice');
            $(document).on('click', '.print_invoice', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Please enter invoice number to print.',
                    icon: "info",
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
                        $(document).find('.display_customer_phone_input, .display_customer_data').addClass('d-none');
                        $(document).find('.display_customer_div').removeClass('d-none');
                        $(document).find('.display_customer_name').text(response.data.customer.name).attr('href', '{{ url('orders/customers') }}/' + response.data.customer.slug);
                        $(document).find('.display_customer_phone').text(response.data.customer.phone);
                        $(document).find('.pos_customer_id').val(response.data.customer.id);
                    }

                    localStorage.setItem('customer', JSON.stringify(response.data.customer));
                }
            });
        }

        function clearLocalStorage() {
            const itemsToRemove = [
                'customer',
                'pos_items',
                'selected_item_index',
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
            let decoded_pos_items = JSON.parse(localStorage.getItem('pos_items')) || [];

            if (decoded_pos_items.length === 0) {
                localStorage.removeItem('pos_items');
                $(document).find('.customer_bookings').html('<tr><td colspan="4">No record found</td></tr>');
                $(document).find('.customer_bookings_footer').html('');
                return false;
            }

            let item_row = '';
            let total_final_cost = 0;

            $.each(decoded_pos_items, function (index, decoded_item) {
                item_row += `<tr data-index="${index}" class="selected_item_row" data-type="${decoded_item.type}">
                                <td class="text-center">
                                    <a href="javascript:void(0);"
                                        class="remove_invoice_item border border-danger p-1 px-2 mr-3"
                                        data-product-id="${decoded_item.product_id}">
                                            <i class="fa fa-times text-danger"> </i>
                                    </a>
                                    <a href="javascript:void(0);"
                                        class="edit_invoice_item border border-primary p-1 px-2"
                                        data-product-id="${decoded_item.product_id}">
                                        <i class="fa fa-edit text-primary"> </i>
                                    </a>
                                </td>
                                <td class="align-middle">${decoded_item.quantity} x ${decoded_item.name}</td>
                                <td class="align-middle">${parseFloat(decoded_item.per_item_price).toFixed(3)}</td>
                                <td class="align-middle">${parseFloat(decoded_item.final_price).toFixed(3)}</td>
                            </tr>`;

                total_final_cost += decoded_item.final_price;
            });

            $(document).find('.customer_bookings').html(item_row);
            $(document).find('.customer_bookings_footer').html(`<tr>
                    <td colspan="3" class="font-weight-bold font-size-lg text-right">Total Invoice Amount</td>
                    <td class="total_invoice_amount">${parseFloat(total_final_cost).toFixed(3)}</td>
                </tr>`);
        }

        function initSelect2() {
            $(document).find('.select2').select2({
                placeholder: 'Please select a value',
                allowClear: true,
                closeOnSelect: false
            });
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

            calculateEnteredAmount();
        }

        function calculateEnteredAmount() {
            let payment_types = getPaymentTypes();
            let total_entered_amount = getEnteredAmountByPaymentTypes(payment_types);
            let total_invoice_amount = parseFloat($(document).find('.invoice_amount').text());

            $(document).find('.input_payment_types').val(JSON.stringify(payment_types));

            let invoice_input_discount = $(document).find('.invoice_input_discount').val() === '' ? '0.000' : $(document).find('.invoice_input_discount').val();
            invoice_input_discount = parseFloat(invoice_input_discount);
            if (invoice_input_discount > 0) {
                let discount_type = document.querySelector('input[name="discount_type"]:checked').value;
                if (discount_type === 'percentage') {
                    invoice_input_discount = (total_invoice_amount * invoice_input_discount) / 100;
                }
            }

            let total_discount_amount = total_invoice_amount > invoice_input_discount ? invoice_input_discount : total_invoice_amount;
            let total_payable_amount = total_invoice_amount - total_discount_amount;

            if (total_payable_amount < 0) {
                swal('Error...', 'Payable Amount can not be in Negative.', 'error')
                $(document).find('.payment_popup_submit_button').addClass('disabled');
                return false;
            }

            let total_due_amount = total_payable_amount - total_entered_amount;
            total_due_amount = total_due_amount < 0 ? 0.000 : total_due_amount;

            $(document).find('.invoice_payable_amount').html(total_payable_amount.toFixed(3));
            $(document).find('.invoice_discount_amount').html(total_discount_amount.toFixed(3));
            $(document).find('.invoice_due_amount').html(total_due_amount.toFixed(3));

            if (total_due_amount > 0 || total_payable_amount < total_entered_amount) {
                $(document).find('.payment_popup_submit_button').addClass('disabled');
            } else {
                $(document).find('.payment_popup_submit_button').removeClass('disabled');
            }
        }

        function getPaymentTypes() {
            let payment_types = [];
            $(document).find('.payment_type_input').each(function () {
                payment_types.push({
                    payment_type: $(this).attr('data-payment-type'),
                    amount: parseFloat($(this).val()) || 0
                });
            });

            return payment_types;
        }

        function getEnteredAmountByPaymentTypes(payment_types) {
            return payment_types.reduce((total, payment) => total + payment.amount, 0);
        }

        function bookAndProceed() {
            $(document).find('.payment_popup_submit_button').attr('disabled', true);
            $(document).find('.payment_popup_submit_button').addClass('disabled');

            let data = {
                customer_id: $(document).find('.pos_customer_id').val(),
                pos_items: localStorage.getItem('pos_items'),
                invoice_amount: parseFloat($(document).find('.invoice_amount').html()),
                discount_type: $(document).find('.invoice_input_discount_type:checked').val(),
                discount_value: $(document).find('.invoice_input_discount').val(),
                discount_amount: parseFloat($(document).find('.invoice_discount_amount').html()),
                final_amount: parseFloat($(document).find('.invoice_payable_amount').html()),
                payment_types: JSON.stringify(getPaymentTypes()),
                notes: $(document).find('.notes').val(),
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

                    $(document).find('.payment_control_modal').modal('hide');
                    clearLocalStorage();

                    setTimeout(async () => {
                        window.location.href = "{{ route('pos.create') }}";
                    }, 1000);
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error('Network/Server Error:', textStatus, errorThrown);
                    swal('Error...', 'An error occurred while processing your request.', 'error');
                }
            });
        }

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
    </script>
@stop
