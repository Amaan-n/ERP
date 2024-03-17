<div class="modal fade edit_item_model" id="edit_item_modal" tabindex="-1" role="dialog"
     aria-labelledby="edit_item_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('locale.edit_item')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>
            <div class="modal-body edit_item_modal_body">
                <div class="row">
                        <div class="col-md-4 edit_quantity_modal" id="edit_quantity_modal">
                            <div class="form-group">
                                <label class="form-label">
                                    {{__('locale.quantity')}}
                                </label>
                                <input type="number" class="form-control item_quantity"
                                       name="quantity"
                                       value="" min="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    {{__('locale.unit_price')}}
                                </label>
                                <input type="number" class="form-control item_price"
                                       name="price"
                                       value="" min="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <div class="form-check form-switch">
                                        {{__('locale.discount')}} : 
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input class="form-check-input" type="checkbox" role="switch" id="item_discount_type">
                                        <label class="form-check-label" for="flexSwitchCheckChecked">{{__('locale.is_percentage')}}?</label>
                                      </div>
                                </label>
                                <input type="number" class="form-control item_discount_value"
                                       name="item_discount_value"
                                       value="" step="0.01" min="0">
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary edit_item_submit_button">{{__('locale.submit')}}</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{__('locale.close')}}</button>
            </div>
        </div>
    </div>
</div>
