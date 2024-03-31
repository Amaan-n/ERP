<div class="modal fade customers_listing" id="customers_listing" tabindex="-1" role="dialog"
     aria-labelledby="customers_listing" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">List Of Customers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <table class="table table-bordered data_table">
                            <thead>
                            <tr>
                                <th>Index</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Providers\FormList::getCustomers() as $index => $customer)
                                <tr class="select_customer cursor-pointer" data-phone="{{$customer->phone}}">
                                    <td>{{ ++$index }}</td>
                                    <td>{{ !empty($customer->name) ? $customer->name : '-' }}</td>
                                    <td>{{ !empty($customer->phone) ? $customer->phone : '-' }}</td>
                                    <td>{{ !empty($customer->email) ? $customer->email : '-' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
