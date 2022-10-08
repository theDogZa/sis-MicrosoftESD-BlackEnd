<div class="block block-rounded block-bordered">
    <div class="block-header block-header-default border-b bg-primary-light">
        <h3 class="block-title">Latest Inventory <small> (10 Record)</small></h3>
        <div class="block-options"></div>
    </div>
    <div class="block-content">
        <table class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th style="width: 100px;">Billing No</th>
                    <th>Serial</th>
                    <th>sale_status</th>
                    <th class="d-none d-sm-table-cell text-center">Date-Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Inventory as $item)
                <tr>
                    <td>
                        <a class="font-w600" href="{{route('billings.show',$item->Billing->id)}}">{{ @$item->Billing->billing_no}}</a>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <a class="font-w600" href="{{route('inventory.show',$item->id)}}"> {{$item->serial}}</a>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        {{$item->sale_status}}
                    </td>
                    <td class="text-center">
                        <span class="text-black ">
                            {!! date("d-m-Y H:i:s",strtotime($item->created_at)) !!}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>