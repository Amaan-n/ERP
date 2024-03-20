@if(!empty($items) && count($items) > 0)
    @foreach($items as $item)
        <div
            class="m-1 w-150px h-162px d-flex justify-content-center align-items-center flex-wrap cursor-pointer item_selection bg-light-primary"
            style="border-radius: 5px"
            data-item-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}"
        >
            <img src="{{ asset($item->attachment) }}" alt="" class="mt-2 img-thumbnail"
                 style="height: 100px;width:110px">
            <a href="javascript:void(0);" class="btn text-uppercase font-weight-bold"
               data-toggle="popover" data-placement="top" data-content="{{ $item->name }}"
               style="font-size: 13px; word-break: break-word">
                <span>
                    {{ $item->name }} <br> ( {{number_format($item->price, 3) ?? 0.000}} )
                </span>
            </a>
        </div>
    @endforeach
@endif
