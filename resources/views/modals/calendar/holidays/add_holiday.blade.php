<div class="modal fade" id="add_holiday_modal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_event_modal_label">Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_holiday_form">
                    @csrf
                    <div class="form-group">
                        <label for="holiday_name">Holiday Title</label>
                        <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="holiday_name" name="title" required>
                        <span class="invalid-feedback" style="display: none;"></span>
                    </div>
                    <div class="form-group">
                        <label for="holiday_start_date">Start date</label>
                        <span class="text-danger">*</span>
                        <div class="input-group date">
                            <input type="text" class="form-control datepicker" name="start_date" id="holiday_start_date" readonly  placeholder="Select start date" required/>
                            <span class="invalid-feedback" style="display: none;"></span>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>   
                    <div class="form-group"> 
                        <label for="holiday_end_date">End date</label>
                        <span class="text-danger">*</span>
                        <div class="input-group date">
                            <input type="text" class="form-control datepicker" readonly name="end_date" id="holiday_end_date"  placeholder="Select end date" required/>
                            <span class="invalid-feedback" style="display: none;"></span>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="holiday_description">Holiday Description</label>
                        <span class="text-danger">*</span>
                        <textarea class="form-control" id="holiday_description" name="description" rows="3" required></textarea>
                        <span class="invalid-feedback" style="display: none;"></span>
                    </div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_holiday_button">Save</button>
            </div>
        </div>
    </div>
</div>