<div id="kt_quick_cart" class="offcanvas offcanvas-right p-10 hide_print">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7" kt-hidden-height="50">
        <h4 class="font-weight-bold m-0">
            Sticky Notes
        </h4>
        <div>
            <a href="javascript:void(0)" class="btn btn-sm btn-outline-dark" id="kt_quick_cart_close">
                <i class="fa fa-times"></i>
                Close
            </a>

            @if($is_root_user == 1 || in_array('notes.create', $accesses_urls))
                <button type="button" class="btn btn-sm btn-outline-primary add_note">
                    <i class="fa fa-plus"></i>
                    Add
                </button>
            @endif
        </div>
    </div>

    <div class="offcanvas-content">
        <div class="offcanvas-wrapper mb-5 notes_container">
            <div data-scroll="true" data-height="700">
                @include('layouts.notes')
            </div>
        </div>
    </div>
</div>

<div class="modal fade notes_modal" id="notes_modal" tabindex="-1" role="dialog"
     aria-labelledby="notes_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="" method="post" class="notes_form" id="notes_form">
                {{ csrf_field() }}

                <input type="hidden" name="id" value="">

                <div class="modal-header">
                    <h4 class="modal-title">Add Note</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="title">
                                    Title
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control time_picker" id="title"
                                       name="title" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="description">
                                    Description
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                                          placeholder="Type here something...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="button" class="btn btn-primary note_submit" value="Submit"/>
                </div>
            </form>
        </div>
    </div>
</div>
