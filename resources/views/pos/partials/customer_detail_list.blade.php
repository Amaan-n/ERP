<!-- Nav tabs -->
@php $is_ul_enable = false @endphp
<ul class="nav nav-tabs" role="tablist">
    @if($organization_data->is_package_enabled)
    @php $is_ul_enable = true @endphp
        <li class="nav-item" role="presentation">
        <button class="nav-link {{$is_ul_enable ?  'active' : ''}}" id="active-packages-tab" data-toggle="tab" data-target="#active-packages" type="button" role="tab" aria-controls="active-packages" aria-selected="true">{{ __('locale.active_packages') }}</button>
        </li>

        <li class="nav-item" role="presentation">
        <button class="nav-link" id="package_usage_history" data-toggle="tab" data-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">{{ __('locale.package_usage_history') }}</button>
        
        </li>
    @endif
    @if($organization_data->is_voucher_enabled)
        <li class="nav-item" role="presentation">
        <button class="nav-link {{!$is_ul_enable ?  'active' : ''}}" id="voucher_history_tab" data-toggle="tab" data-target="#voucher_history" type="button" role="tab" aria-controls="tab2" aria-selected="false">{{ __('locale.voucher_history') }}</button>
        </li>
        @php $is_ul_enable = true @endphp
    @endif
    @if($organization_data->is_advance_enabled)
        <li class="nav-item" role="presentation">
        <button class="nav-link {{!$is_ul_enable ?  'active' : ''}}" id="balance_tab" data-toggle="tab" data-target="#balance" type="button" role="tab" aria-controls="tab2" aria-selected="false">{{ __('locale.balance') }}</button>
        </li>
        @php $is_ul_enable = true @endphp
    @endif
</ul>

<!-- Tab panes -->
@php $is_enable = false @endphp
<div class="tab-content">
    @if($organization_data->is_package_enabled)
    @php $is_enable = true @endphp
        <div class="tab-pane fade {{$is_enable ?  'show active' : ''}}" id="active-packages" role="tabpanel" aria-labelledby="active-packages-tab">
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.package') }}</th>
                            <th>{{ __('locale.sold') }}</th>
                            <th>{{ __('locale.used') }}</th>
                            <th>{{ __('locale.bal') }}</th>
                            <th>{{ __('locale.issued') }}</th>
                            <th>{{ __('locale.expiry') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($service_packages['package_service'] as $index => $service_package)
                                <tr class="service_package_tr cursor-pointer" data-service-id="{{$service_package['service_id']}}" data-package-id="{{$service_package['package_id']}}">
                                    <td>
                                        <strong>{{ !empty($service_package['service']) && !empty($service_package['service']['name']) ? $service_package['service']['name'] : '-' }}</strong>
                                        <ul>
                                            <label> {{$service_package['package']['name']}} </label>
                                        </ul>
                                    </td>
                                    <td>
                                        {{$service_package->service_usage_count}}
                                    </td>
                                    <td>
                                        {{$service_package->used_session_count}}
                                    </td>
                                    
                                    <td>
                                        {{$service_package->service_usage_count - $service_package->used_session_count}}
                                    </td>
                                    <td>
                                        {{$service_package->issued}}
                                    </td>
                                    <td>
                                        {{$service_package->expiry}}
                                    </td>
                                </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ __('locale.no_record_found') }}.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="package_usage_history">
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.date') }}</th>
                            <th>{{ __('locale.package_name') }}</th>
                            <th>{{ __('locale.service_name') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($service_packages['package_usage_history'] as $index => $package_usage_history)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($package_usage_history->created_at)->format('d-M-Y')  }}
                                    </td>
                                    <td>
                                        {{$package_usage_history->package->name}}
                                    </td>
                                    <td>
                                        {{$package_usage_history->service->name}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">{{ __('locale.no_record_found') }}.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if($organization_data->is_voucher_enabled)
        <div class="tab-pane fade {{!$is_enable ? 'show active' : ''}}" id="voucher_history" role="tabpanel" aria-labelledby="voucher_history">
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.date') }}</th>
                            <th>{{ __('locale.voucher_code') }}</th>
                            <th>{{ __('locale.amount') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($customer_voucher as $index => $voucher_history)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($voucher_history->created_at)->format('d-M-Y')  }}
                                    </td>
                                    <td>
                                        {{$voucher_history->voucher_code}}
                                    </td>
                                    <td>
                                        {{$voucher_history->amount}}
                                    </td>
                                </tr>    
                            @empty
                            <tr>
                                <td colspan="3">{{ __('locale.no_record_found') }}.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @php $is_enable = true @endphp
    @endif
    @if($organization_data->is_advance_enabled)
        <div class="tab-pane fade {{!$is_enable ? 'show active' : ''}}" id="balance" role="tabpanel" aria-labelledby="balance">
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 align-items">
                            <h6>Balance</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-bordered data_table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('locale.index') }}</th>
                                        <th>{{ __('locale.date') }}</th>
                                        <th>{{ __('locale.type') }}</th>
                                        <th>{{ __('locale.amount') }}</th>
                                        <th>{{ __('locale.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customer_wallet as $index => $balance)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ \Carbon\Carbon::parse($balance->created_at)->tz('Asia/Kuwait')->format('dS F, Y h:i A') }}</td>
                                            <td>{{ $balance->type  }}</td>
                                            <td>{{ $balance->amount  }}</td>
                                            <td><i class="fa fa-solid fa-print balance_receipt" data-invoice="{{$balance->invoice_number}}"></i></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2"> </th>
                                            <th>{{ __('locale.available_balance') }}</th>
                                            <th id="customer_available_balance">{{ $customer_advance_balance }}</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<script>
    $(document).ready(function() {
        $(document).off('click', '.balance_receipt');
        $(document).on('click', '.balance_receipt', function (e) {
            printInvoice($(this).data('invoice'));
        });
    });

    function printInvoice(invoice_number) {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            type: 'GET',
            url: '{{ route('customer.balance.invoice') }}',
            data: {
                invoice_number: invoice_number
            },
            success: function (response) {
                if (!response.success) {
                    swal('Error...', response.message, 'error')
                    return false;
                }

                if (response.data) {
                    let custom_window = window.open('', '', 'height=5000, width=1000');
                     custom_window.document.write(response.data.html);
                     custom_window.document.close();
                     custom_window.print();
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error('Network/Server Error:', textStatus, errorThrown);
                swal('Error...', 'An error occurred while processing your request.', 'error');
            }
        });
    }
</script>