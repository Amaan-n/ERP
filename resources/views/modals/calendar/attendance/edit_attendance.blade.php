<div class="modal fade" id="edit_attendance_modal" tabindex="-1" role="dialog" aria-labelledby="updateLeaveAbsentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLeaveAbsentModalLabel">Update Leave/Absent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_attendance_form">
                    <input type="hidden" id="edit_attendance_id" name="id">
                    @if($is_root_user == 1)
                        <div class="form-group">
                            <label for="edit_user_name">Name</label>
                            <span class="text-danger">*</span>
                            <select class="form-control" id="edit_attendance_user_id" name="user_id" required>
                                <option value="">Select Name</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_type">Type</label>
                            <span class="text-danger">*</span>
                            <select class="form-control" id="edit_attendance_type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="leave">Leave</option>
                                <option value="absent">Absent</option>
                            </select>
                            <span class="invalid-feedback" style="display: none;"></span>
                        </div>
                    @else
                        <div class="form-group">
                            <label for="edit_user_name">Name</label>
                            <span class="text-danger">*</span>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="{{ Auth::id() }}">{{ Auth::user()->name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <span class="text-danger">*</span>
                            <select  class="form-control" id="type" name="type" required>
                                <option value="leave" selected>Leave</option>
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="edit_attendance_start_date">Start date</label>
                        <span class="text-danger">*</span>
                        <div class="input-group date">
                            <input type="text" class="form-control datepicker " id="edit_attendance_start_date" name="start_date" readonly required>
                            <label  class="invalid-feedback text-danger" style="display: none;"></label>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>   
                    <div class="form-group"> 
                        <label for="edit_attendance_end_date">End date</label>
                        <span class="text-danger">*</span>
                        <div class="input-group date">
                            <input type="text" class="form-control datepicker" id="edit_attendance_end_date" name="end_date" readonly required>
                            <label for="edit_attendance_start_date" class="invalid-feedback text-danger" style="display: none;"></label>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_shift">Shift</label>
                        <span class="text-danger">*</span>
                        <select class="form-control" id="edit_attendance_shift" name="shift" required>
                            <option value="">Select Shift</option>
                            <option value="First-half">First Half</option>
                            <option value="Second-half">Second Half</option>
                            <option value="Full-shift">Full Shift</option>
                        </select>
                        <span class="invalid-feedback" style="display: none;"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_reason">Reason</label>
                        <span class="text-danger">*</span>
                        <textarea class="form-control" id="edit_attendance_reason" name="reason" rows="3" required></textarea>
                        <span class="invalid-feedback" style="display: none;"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit_attendance_button">Update</button>
            </div>
        </div>
    </div>
</div>
