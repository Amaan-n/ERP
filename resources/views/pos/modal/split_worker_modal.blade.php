<div class="modal fade split_worker_modal" id="split_worker_modal" tabindex="-1" role="dialog"
     aria-labelledby="split_worker_modal" aria-hidden="true">
     <input type="hidden" name="selected_service_final_price" class="selected_service_final_price" id="selected_service_final_price">
    <form id="split_worker_form">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('locale.split_worker')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"> </i>
                    </button>
                </div>
                <div class="modal-body split_worker_modal_body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{__('locale.type')}}: </label><br />
                                <input class="split_type" type="radio" name="split_type" value="fixed" checked> {{__('locale.fixed')}} 
                                <input class="split_type" type="radio" name="split_type" value="percentage"> {{__('locale.percentage')}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="worker_ids">
                                    {{__('locale.workers')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="worker_ids[]" id=" worker_ids" class="form-control select2 worker_ids" multiple required>
                                    @foreach(\App\Providers\FormList::getWorkers() as $worker)
                                        <option value="{{ $worker->id }}">
                                            {{ $worker->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="worker_section">
                        <div class="row worker_container_main">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary split_worker_submit_button">{{__('locale.submit')}}</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{__('locale.close')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>
