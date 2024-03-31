<div class="modal fade payment_control_modal" id="payment_control_modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl payment-model" role="document" style="">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="create_bookings_modal_popup">Payment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-10">
                    <div class="col-md-6 text-center">
                        <div class="form-group">
                            <input type="hidden" class="input_payment_types" value=""/>

                            <div class="d-flex flex-column">
                                <div class="numbers mb-2">
                                    <input type="button" class="w-70px h-45px font-size-h5" value="1"
                                           onclick="display(1)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="2"
                                           onclick="display(2)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="3"
                                           onclick="display(3)"/>
                                    <input type="button" class="w-70px h-45px font-size-h5" value="." disabled/>
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
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            @foreach(config('constants.PAYMENT_TYPES') as $index => $payment_type)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold" for="invoice_{{ $index }}">
                                            {{ $payment_type }}
                                        </label>
                                        <input type="number" name="{{ $payment_type }}"
                                               class="form-control payment_type_input last_focused focused"
                                               data-payment-type="{{ $payment_type }}" id="invoice_{{ $index }}"
                                               placeholder="0.000" value="" min="0">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="discount_type">
                                        Discount Type
                                    </label>
                                    <div class="radio-inline">
                                        @foreach(config('constants.DISCOUNT_TYPES') as $key => $discount_type)
                                            <label class="radio radio-outline radio-outline-2x radio-primary">
                                                <input type="radio" name="discount_type" id="discount_type"
                                                       class="invoice_input_discount_type"
                                                       value="{{ $discount_type }}" {{ $key == 0 ? 'checked="checked"' : '' }}>
                                                <span></span>
                                                {{ ucwords($discount_type) }}
                                            </label><br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="discount_value">
                                        Discount Value
                                    </label>
                                    <input type="number" name="discount" id="discount_value"
                                           class="form-control invoice_input_discount discount_value last_focused focused"
                                           value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold" for="notes">
                                        Notes
                                    </label>
                                    <div class="font-weight-bold">
                                        <textarea class="form-control notes" name="notes" id="notes"></textarea>
                                    </div>
                                </div>
                            </div>
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
                                            <h6>Total Invoice</h6>
                                            <div class="font-weight-bold">
                                                <span class="invoice_amount">0.000</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style=" text-align: center;">
                                            <h6>Total Payable</h6>
                                            <div class="font-weight-bold">
                                                <span class="invoice_payable_amount">0.000</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style=" text-align: center;">
                                            <h6>Total Discount</h6>
                                            <div class="discount-box">
                                                <span class="invoice_discount_amount">0.000</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style=" text-align: center;">
                                            <h6>Total Due</h6>
                                            <div class="font-weight-bold">
                                                <span class="invoice_due_amount">0.000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="javascript:void(0)"
                   class="btn btn-primary font-size-h5 font-weight-bold payment_popup_submit_button">
                    Book & Proceed
                </a>

                <a href="javascript:void(0)" class="btn btn-outline-secondary font-size-h5 font-weight-bold"
                   data-dismiss="modal" aria-label="Close">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>
