@foreach($items['result'] as $item)
    <?php
    $item_name = ($local_value == 'ar' && in_array($data['item_type'], ['service', 'product']))
    ? (($item->a_name ?? (strlen($item->name) > 15 ? substr(strtoupper($item->name), 0, 15) . '...' : strtoupper($item->name))) ?? $item->name)
    : (strlen($item->name) > 15 ? substr(strtoupper($item->name), 0, 15) . '...' : strtoupper($item->name));

    $price_for_home_service = isset($item) && $item->price_for_home_service > 0 ? $item->price_for_home_service : 0;
    $price_for_branch = isset($item) && $item->price_for_branch > 0 ? $item->price_for_branch : 0;
    if (!empty($item->branches) && count($item->branches) > 0) {
        $price_for_home_service = $item->branches[0]->price_for_home_service > 0 ? $item->branches[0]->price_for_home_service : $price_for_home_service;
        $price_for_branch       = $item->branches[0]->price_for_branch > 0 ? $item->branches[0]->price_for_branch : $price_for_branch;
    }

    if(($data['service_type'] == 'salon' || $data['service_type'] == '' || $data['service_type'] == null) && $data['item_type'] == 'service'){
        $item_price = $price_for_branch;
    }elseif ($data['service_type'] == 'home' && $data['item_type'] == 'service'){
        $item_price = $price_for_home_service;
    }else{
        $item_price = $item->price;
    }
    ?>
    <div class="m-1 w-150px h-162px d-flex justify-content-center align-items-center flex-wrap cursor-pointer item_selection bg-light-primary"
         style="border-radius: 5px"
         data-item-id="{{ $item->id }}"
         data-name="{{ $item_name }}"
         data-price="{{ $item->price }}"
         data-days="{{ ($item->expiry_days) ?? 0 }}"
         data-price-for-home-service="{{ $price_for_home_service }}"
         data-price-for-branch="{{ $price_for_branch }}"
         data-value="{{ ($item->value) ?? 0 }}"
         data-available="{{ ($item->available_count) ?? 0 }}"
    >
        <img src="{{asset($item->attachment)}}" alt="" class="mt-2 img-thumbnail" style="height: 100px;width:110px">
        <a href="javascript:void(0);" class="btn text-uppercase font-weight-bold"
           data-toggle="popover" data-placement="top" data-content="{{ $item_name }}"
           style="font-size: 13px; word-break: break-word">
            <span>
                @if($data['item_type'] == 'product')
                    {{$item->barcode}} <br />
                @endif
                {{ $item_name }}({{number_format($item_price, 3) ?? 0.000}})</span>
        </a>
        @if($data['item_type'] == 'product')
            @php $color = '' @endphp
            @if((int)$item->available_count <= $item->minimum_quantity)
                @php $color = 'color:red' @endphp
            @endif
        <p style="{{$color}}">{{__('locale.available_qty')}}: {{ ($item->available_count) ?? 0 }}</p>
        @endif

    </div>
@endforeach
