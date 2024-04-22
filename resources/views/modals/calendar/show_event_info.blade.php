<div class="modal fade" id="event_modal" tabindex="-1" role="dialog" aria-labelledby="event-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="event-modal-label">Event Details</h5>
                @if($is_root_user == 1)
                <div class="ml-auto">
                    <button type="button" class="btn btn-warning mr-2" id="edit_event_btn">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" id="delete_event_btn">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            @else
                <div id="edit_delete_buttons" class="ml-auto"></div>
            @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong class="text-dark" >Title:</strong>
                            </div>
                            <div class="col-md-9">
                                <span id="event_title" class="text-primary" ></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong class="text-dark">Start Date:</strong>
                            </div>
                            <div class="col-md-9">
                                <span id="event_start" ></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong class="text-dark">End Date:</strong>
                            </div>
                            <div class="col-md-9">
                                <span id="event_end" ></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong class="text-dark">Type:</strong>
                            </div>
                            <div class="col-md-9">
                                <span id="event_type" class="text-danger" ></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong class="text-dark">Shift:</strong>
                            </div>
                            <div class="col-md-9">
                                <span id="event_shift" class="text-secondary" ></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong class="text-dark">Description:</strong>
                            </div>
                            <div class="col-md-9">
                                <span id="event_description" ></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>