<div class="modal fade payment_control_modal" id="payment_control_modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl payment-model" role="document" style="">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="create_bookings_modal_popup">{{__('locale.payment_details')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-10">
                    <div class="col-md-6 text-center">
                        <div class="form-group">
                            <input type="hidden" id="input_payment_types_value" class="input_payment_types_value" value=""/>
                            <input type="hidden" id="coupon_id"             class="coupon_id"              value=""/>
                            <input type="hidden" id="coupon_discount_type"  class="coupon_discount_type"   value=""/>
                            <input type="hidden" id="coupon_discount_value" class="coupon_discount_value"  value=""/>

                            <div class="d-flex flex-column">
                                <div class="numbers mb-2">
                                    <input type="button" class="w-70px h-45px font-size-h5" value="1"
                                           onclick="display(1)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="2"
                                           onclick="display(2)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="3"
                                           onclick="display(3)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="Clear"
                                           onclick="clearScreen()"/>
                                </div>
                                <div class="numbers mb-2">
                                    <input type="button" class="w-70px h-45px font-size-h5" value="4"
                                           onclick="display(4)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="5"
                                           onclick="display(5)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="6"
                                           onclick="display(6)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="5KD"
                                           onclick="display(5, 'add')"/>
                                </div>
                                <div class="numbers mb-2">
                                    <input type="button" class="w-70px h-45px font-size-h5" value="7"
                                           onclick="display(7)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="8"
                                           onclick="display(8)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="9"
                                           onclick="display(9)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="10KD"
                                           onclick="display(10, 'add')"/>
                                </div>
                                <div class="numbers mb-2">
                                    <input type="button" class="w-70px h-45px font-size-h5" value=" " disabled/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="0"
                                           onclick="display(0)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="." disabled/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="15KD"
                                           onclick="display(15, 'add')"/>
                                </div>
                                <div class="numbers">
                                    <input type="button" class="w-70px h-45px font-size-h5" value="0.250"
                                           onclick="display(0.250, 'add')"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="0.500"
                                           onclick="display(0.500, 'add')"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="0.750"
                                           onclick="display(0.750, 'add')"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="20KD"
                                           onclick="display(20, 'add')"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-custom gutter-b bg-light-primary">
                                    <div class="card-body pb-0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.invoice')}}</h6>
                                                    <div class="font-weight-bold">
                                                        <span class="invoice_amount">0.000</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.payable')}}</h6>
                                                    <div class="font-weight-bold">
                                                        <span class="invoice_payable_amount">0.000</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.discount')}}</h6>
                                                    <div class="discount-box">
                                                        <span class="invoice_discount_amount">0.000</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.due')}}</h6>
                                                    <div class="font-weight-bold rounded" style="background-color: red;color: white;">
                                                        <span class="invoice_due_amount">0.000</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.change')}}</h6>
                                                    <div class="font-weight-bold">
                                                        <span class="invoice_change_amount">0.000</span>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-3">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>Redeem</h6>
                                                    <div class="font-weight-bold">
                                                        <span class="invoice_redeem_amount">0.000</span>
                                                    </div>
                                                </div>
                                            </div> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">

                        </div>

                        <div class="row">
                            <div class="btn-group btn-group-lg mb-5 ml-4" role="group" aria-label="Large button group">
                                <button type="button" class="btn btn-primary common_selection" id="discount_type_button" data-section="discount_section">{{__('locale.discount_type')}}</button>
                                {{-- <button type="button" class="btn btn-outline-primary common_discount common_selection" id="coupon_button" data-section="coupon_section">Coupon</button> --}}
                            </div>
                        </div>
                        <div class="row coupon_section hidden main_div_common_selection">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="coupon_code">
                                        {{__('locale.coupon_code')}}
                                    </label>
                                    <input type="text" name="coupon_code" id="coupon_code"
                                           class="form-control invoice_input_coupon_code" value="">
                                    <p class="text-danger display_coupon_code_error d-none"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row voucher_redeem_section hidden main_div_common_selection">
                            <div class="col-md-12 voucher_code_div">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="coupon_code">
                                        {{__('locale.voucher_code')}}
                                    </label>
                                    <input type="text" name="voucher_code" id="voucher_code"
                                           class="form-control invoice_input_voucher_code" value="">
                                    <p class="text-danger display_voucher_code_error hidden"></p>
                                </div>
                            </div>
                            <div class="col-md-12 hidden voucher_amount_div">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="coupon_code">
                                        {{__('locale.voucher_amount')}}
                                    </label>
                                    <input type="number" name="voucher_amount" id="voucher_amount"
                                           class="form-control invoice_input_voucher_amount" value="">
                                    <p class="text-danger display_voucher_amount_error hidden"></p>
                                </div>
                            </div>
                            <div class="col-md-12 voucher_detail_div hidden">
                                <div class="card card-custom gutter-b bg-light-primary">
                                    <div class="card-body pb-0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.balance')}}</h6>
                                                    <div class="font-weight-bold">
                                                        <span class="voucher_balance_remaining">0.000</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.expiry')}}</h6>
                                                    <div class="font-weight-bold">
                                                        <span class="voucher_expiry_date">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.usage')}}</h6>
                                                    <div class="discount-box">
                                                        <span class="voucher_usage_count">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row advance_redeem_section hidden main_div_common_selection">
                            <div class="col-md-12 advance_amount_div">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="coupon_code">
                                        {{__('locale.advance_amount')}}
                                    </label>
                                    <input type="number" name="advance_amount" id="advance_amount"
                                           class="form-control invoice_input_advance_amount" value="">
                                    <p class="text-danger display_advance_amount_error hidden"></p>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="card card-custom gutter-b bg-light-primary">
                                    <div class="card-body pb-0">
                                        <div class="row">
                                            <div class="col-md-12 align-items">
                                                <h6>{{__('locale.available_balance')}}</h6>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6></h6>
                                                    <div class="font-weight-bold">
                                                        <span class="advance_balance_remaining">0.000</span><span>&nbsp; KD</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row loyalty_redeem_section hidden main_div_common_selection">
                            <div class="col-md-12 loyalty_amount_div">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="coupon_code">
                                        {{__('locale.loyalty_amount')}}
                                    </label>
                                    <input type="number" name="loyalty_amount" id="loyalty_amount"
                                           class="form-control invoice_input_loyalty_amount" value="">
                                    <p class="text-danger display_loyalty_amount_error hidden"></p>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="card card-custom gutter-b bg-light-primary">
                                    <div class="card-body pb-0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group" style=" text-align: center;">
                                                    <h6>{{__('locale.balance')}}</h6>
                                                    <div class="font-weight-bold">
                                                        <span class="loyalty_balance_remaining">0.000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row discount_section main_div_common_selection">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="radio-inline">
                                        @php $discountTypes = config('constants.DISCOUNT_TYPES');
                                             $discountTypes[] = 'coupon';
                                        @endphp
                                        @foreach(config('constants.DISCOUNT_TYPES') as $key => $type)
                                            <label class="radio discount-cls">
                                                <input type="radio" name="discount_type" id="discount_type"
                                                       value="{{ $type }}" {{ $key == 0 ? 'checked="checked"' : '' }}>
                                                <span></span>
                                                {{ ucwords($type) }}
                                            </label><br>
                                        @endforeach
                                        <label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row discount_section main_div_common_selection">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="discount_value">
                                        {{__('locale.discount_value')}}
                                    </label>
                                    <input type="number" name="discount" id="discount_value"
                                           class="form-control invoice_input_discount discount_value last_focused focused" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row redeem_section hidden main_div_common_selection">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="redeem">
                                        {{__('locale.redeem_amount')}}
                                    </label>
                                    <input type="number" name="redeem" id="redeem"
                                           class="form-control invoice_input_redeem" value="">
                                    <p class="text-danger display_redeem_error d-none"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h6>{{__('locale.notes')}}</h6>
                                    <div class="font-weight-bold">
                                        <textarea class="form-control notes" name="notes" id="notes"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">


                {{-- <div class="col-md-3 text-center border border-primary p-3  loyal_amount_div hidden">
                    <span class="font-size-lg font-weight-bold text-primary">
                        Available Loyalty Points: <span class="loyal_point_label">0</span><br />
                    </span>
                </div>
                <div class="col-md-3 text-center border border-primary p-3 loyal_amount_div hidden">
                    <span class="font-size-lg font-weight-bold text-primary">
                        Available Loyalty Amount: <span class="loyal_amount_label">0</span>
                    </span>
                </div> --}}
                <input type="hidden" name="search_bill_number" id="search_bill_number" value="">
                <a href="javascript:void(0)" id="proceed_to_pay" class="btn btn-primary font-size-h5 font-weight-bold">
                    {{__('locale.book_and_proceed')}}
                </a>

                <a href="javascript:void(0)" class="btn btn-outline-secondary font-size-h5 font-weight-bold"
                   data-dismiss="modal" aria-label="Close">
                   {{__('locale.cancel')}}
                </a>
            </div>
        </div>
    </div>
</div>
