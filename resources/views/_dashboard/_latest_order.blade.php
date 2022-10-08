<div class="block block-rounded block-bordered">
    <div class="block-header block-header-default border-b bg-primary-light">
        <h3 class="block-title">Latest Orders <small> (10 Record)</small></h3>
        <div class="block-options"></div>
    </div>
    <div class="block-content">
        <table class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th style="width: 100px;">Part No</th>
                    <th>Serial</th>
                    <th>User Name</th>
                    <th class="d-none d-sm-table-cell text-center">Date-Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>
                        <a class="font-w600" href="{{route('orders.show',$order->id)}}">{{$order->path_no}}</a>
                    </td>
                    <td>
                        <a class="font-w600" href="{{route('inventory.show',$order->OrderItem->Inventory->id)}}">{{@$order->OrderItem->Inventory->serial}}</a>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        {{$order->Sale_uid->username}}
                    </td>
                    <td class="text-center">
                        <span class="text-black ">
                            {!! date("d-m-Y H:i:s",strtotime($order->sale_at)) !!}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>