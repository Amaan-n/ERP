<div class="modal fade create_customer_model" id="create_customer_modal" tabindex="-1" role="dialog"
     aria-labelledby="create_customer_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>
            <div class="modal-body create_customer_modal_body">
                <form action="{{ route('customers.store') }}" method="post"
                      enctype="multipart/form-data" class="customer_form" id="customer_form">
                    {{ csrf_field() }}

                    <input type="hidden" name="redirect_back" value="pos.create">
                    <input type="hidden" name="_method" value="">

                    @include('customers.form')

                    <button type="submit"
                            class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                        Create Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
