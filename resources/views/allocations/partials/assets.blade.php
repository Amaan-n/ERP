@if(!empty($allocations) && count($allocations) > 0)
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Allocated Assets</h3>
            </div>
        </div>
        <div class="card-body pb-0">
            @foreach($allocations as $index => $allocation)
                <button type="button" class="btn btn-outline-primary mr-3 mt-5 mb-10 position-relative" data-toggle="modal"
                        data-target="#allocation_{{ $index }}">
                    {{ $allocation->asset->code ?? '' }}

                    <a href="javascript:void(0);">
                        <i class="fa fa-times position-absolute right-0 text-danger" style="top: -20px"> </i>
                    </a>
                </button>

                <div class="modal fade" id="allocation_{{ $index }}" data-backdrop="static" tabindex="-1" role="dialog"
                     aria-labelledby="staticBackdrop" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $allocation->asset->code ?? '' }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-close"> </i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group list-group-flush">
                                    @if(isset($allocation->asset) && !empty($allocation->asset->parameters) && count($allocation->asset->parameters) > 0)
                                        @foreach($allocation->asset->parameters as $key => $parameter)
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                                        <span
                                                            class="font-weight-bold">{{ $parameter['key'] ?? '' }}</span>
                                                <span class="text-secondary">
                                            {{ $parameter['value'] ?? '' }}
                                        </span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold"
                                        data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
