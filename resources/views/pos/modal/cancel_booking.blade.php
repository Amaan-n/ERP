<div class="modal fade cancel_booking_modal" id="cancel_booking_modal" tabindex="-1" role="dialog"
     aria-labelledby="cancel_booking_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('locale.cancel_booking')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>
            <div class="modal-body cancel_booking_modal_body">
                <div class="d-flex flex-column-fluid">
                    <div class="container">
                @include('pos.index_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
