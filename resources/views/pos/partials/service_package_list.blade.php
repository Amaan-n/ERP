<div class="card card-custom gutter-b">
        <div class="card-body">
            <table class="table table-bordered data_table">
                <thead>
                <tr>
                    <th>{{__('locale.name')}}</th>
                    <th>{{__('locale.used_service_session')}}</th>
                    <th>{{__('locale.service_session_count')}}</th>
                    <th>{{__('locale.used_package_session')}}</th>
                    <th>{{__('locale.package_session_count')}}</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($service_packages['package_service'] as $index => $service_package)
                        <tr class="service_package_tr cursor-pointer" data-service-id="{{$service_package['service_id']}}" data-package-id="{{$service_package['package_id']}}" data-salon-price="{{$service_package['salon_commission_price']}}" data-home-price="{{$service_package['home_commission_price']}}">
                            <td>
                                <strong>{{ !empty($service_package['service']) && !empty($service_package['service']['name']) ? $service_package['service']['name'] : '-' }}</strong>
                                <ul>
                                    <input class="common_radio_package" type="radio" name="{{str_replace(' ','_', $service_package['service']['name'])}}" value="" checked data-service-id="{{$service_package['service_id']}}" data-package-id="0"> Not To Redeem<br />
                                    <input class="common_radio_package" type="radio" name="{{str_replace(' ','_', $service_package['service']['name'])}}" value="{{$service_package['service_id']}}" data-service-id="{{$service_package['service_id']}}" data-package-id="{{$service_package['package_id']}}" data-salon-price="{{$service_package['salon_commission_price']}}" data-home-price="{{$service_package['home_commission_price']}}"> {{$service_package['package']['name']}}
                                </ul>
                            </td>
                            <td>
                                {{$service_package->used_session_count}}
                            </td>
                            <td>
                                {{$service_package->service_usage_count}}
                            </td>
                            <td>
                                {{$service_package->used_package_session_count}}
                            </td>
                            <td>
                                {{$service_package->package->session_count}}
                            </td>
                        </tr>
                @empty
                    <tr>
                        <td colspan="5">{{__('locale.no_record_found')}}.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
<script>

</script>