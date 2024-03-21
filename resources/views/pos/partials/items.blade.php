@if(!empty($items) && count($items) > 0)
    @foreach($items as $item)
        <div
            class="d-flex justify-content-between align-items-center cursor-pointer item_selection bg-light-primary p-3 mb-3"
            style="border-radius: 10px; width: 49%; max-height: 120px;"
            data-item-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}"
        >
            <img src="{{ asset($item->attachment) }}" alt="" class="img-thumbnail"
                 style="width:110px">
            <a href="javascript:void(0);" class="btn text-uppercase font-weight-bold text-left"
               data-toggle="popover" data-placement="top" data-content="{{ $item->name }}"
               style="font-size: 13px; word-break: break-word">
                <span>
                    {{ $item->name }} <br> ( {{number_format($item->price, 3) ?? 0.000}} )
                </span>
            </a>
        </div>
    @endforeach
@endif
