<div class="card card-custom gutter-b">
        <div class="card-body">
            <table class="table table-bordered data_table">
                <thead>
                <tr>
                    <th>{{__('locale.index')}}</th>
                    <th>{{__('locale.name')}}</th>
                    <th>{{__('locale.phone')}}</th>
                    <th>{{__('locale.email')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $index => $customer)
                    <tr class="customers_tr cursor-pointer" data-phone="{{$customer->phone}}">
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
<script>
    $('.data_table').DataTable({
            responsive: true,
            filter: true,
            search: true,
            bSearch: true,
            dom: `<'row'<'col-sm-12'ftr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50, 100],
            pageLength: 10,
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            order: [],
            destroy: true
            // order: [[0, 'desc']],
        });
</script>