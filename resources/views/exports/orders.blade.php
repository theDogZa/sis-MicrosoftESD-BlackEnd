<table>
    <thead>
        <tr>
            <th>
                {{ __('orders.customer_name.th') }}
            </th>
            <th>
                {{ __('orders.email.th') }}
            </th>
            <th>
                {{ __('orders.tel.th') }}
            </th>
            <th>
                {{ __('orders.path_no.th') }}
            </th>
            <th>
                {{ __('billings.material_desc.th') }}
            </th>
            <th>
                {{ __('inventory.serial.th') }}
            </th>
            <th>
                {{ __('orders.receipt_no.th') }}
            </th>
            <th>
                {{ __('orders.sale_uid.th') }}
            </th>
            <th>
                {{ __('orders.sale_at.th') }}
            </th>
            <th>
                {{__('billings.sold_to.th') }}
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>
                {{ @$order->customer_name }}
            </td>
            <td>
                {{ @$order->email }}
            </td>
            <td>
                {{ @$order->tel }}
            </td>
            <td>
                {{ @$order->path_no }}
            </td>
            <td>
                {{ @$order->material_desc }}
            </td>
            <td>
                {{ @$order->serial }}
            </td>
            <td>
                {{ @$order->receipt_no }}
            </td>
            <td>
                {{ @$order->Sale_uid->username }}
            </td>
            <td>
                {{ date_format(date_create(@$order->sale_at),config('theme.format.datetime')) }}
            </td>
            <td>
                {{ @$order->sold_to }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>