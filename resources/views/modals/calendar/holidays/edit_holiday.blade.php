<div class="modal fade" id="edit_holiday_modal" tabindex="-1" role="dialog" aria-labelledby="updateholidayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_event_modal_label">Edit Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_holiday_form">
                    @csrf
                    <div class="form-group">
                        <label for="edit_holiday_name">Holiday Name</label>
                        <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="edit_holiday_name" name="holiday_name" required>
                        <span class="invalid-feedback" style="display: none;">Holiday Name is required.</span>
                    </div>
                    <div class="form-group">
                        <label for="edit_start_date">Start date</label>
                        <span class="text-danger">*</span>
                        <div class="input-group date">
                            <input type="text" class="form-control start" readonly id="edit_start_date" placeholder="Select start date" name="holiday_start_date" required/>
                            <span class="input-group-text">
                                <i class="la la-calendar-check-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label for="edit_end_date">End date</label>
                        <span class="text-danger">*</span>
                        <div class="input-group date">
                            <input type="text" class="form-control end" readonly id="edit_end_date" placeholder="Select end date" name="holiday_end_date" required/>
                            <span class="input-group-text">
                                <i class="la la-calendar-check-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_holiday_description">Holiday Description</label>
                        <span class="text-danger">*</span>
                        <textarea class="form-control" id="edit_holiday_description" name="holiday_description" rows="3" required></textarea>
                        <span class="invalid-feedback" style="display: none;">Holiday Description is required.</span>
                    </div> 
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit_holiday_button">Update</button>
            </div>
        </div>
    </div>
</div>
