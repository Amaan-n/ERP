<div class="modal fade edit_item_model" id="edit_item_modal" tabindex="-1" role="dialog"
     aria-labelledby="edit_item_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="quantity">Quantity</label>
                            <input type="number" class="form-control item_quantity" id="quantity"
                                   name="quantity" value="" min="1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="per_item_price">Per Item Price</label>
                            <input type="number" class="form-control per_item_price"
                                   name="price" value="" min="1" id="per_item_price">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-5">
                <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg edit_item_submit_button">
                    Update Item
                </button>
                <button type="button" class="btn btn-outline-secondary font-weight-bold font-size-lg"
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
