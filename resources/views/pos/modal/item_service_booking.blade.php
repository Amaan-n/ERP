<div class="modal fade item_service_booking" id="item_service_booking" tabindex="-1" role="dialog"
     aria-labelledby="item_service_booking" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Service Slot
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row d-none item_selection_popup_validation">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="worker_id">Worker</label>
                            <span class="text-danger">*</span>
                            <select name="worker_id" class="worker_id form-control">
                                <option value="">Please select a value</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="schedule_date">Schedule Date</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control date_picker service_schedule_date"
                                    name="schedule_date" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="worker_id">Schedule Time</label>
                            <span class="text-danger">*</span>
                            <select name="schedule_time" id="schedule_time" class="form-control schedule_time">
                                <option value="">Please select a value</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="supporting_staff_ids">Suppoting Staff</label>
                            <select name="supporting_staff_ids[]"
                                    class="form-control supporting_staff_ids select2" multiple>
                                <option value="">Please select a value</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-primary font-size-h5 font-weight-bold book_button"
                   data-service-category-type="service">
                    Book Now
                </a>
                <a href="javascript:void(0)" class="btn btn-outline-secondary font-size-h5 font-weight-bold"
                   data-dismiss="modal" aria-label="Close">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>
