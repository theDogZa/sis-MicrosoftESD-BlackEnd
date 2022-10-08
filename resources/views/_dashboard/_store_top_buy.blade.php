<div class="block block-rounded block-bordered">
    <div class="block-header block-header-default border-b bg-primary-light">
        <h3 class="block-title">Top Orders By Store<small> (10 Record)</small></h3>
        <div class="block-options"></div>
    </div>
    <div class="block-content">
        <table class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th>Store</th>
                    <th class="text-right">TOTAL ORDER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($storeTopBuy as $store)
                <tr>
                    <td>        
                        <a class="font-w600" href="{{route('stores.show',$store->id)}}">{{$store->store_name}}</a>
                    </td>
                    <td class="text-right">
                        <span class="text-black ">{{$store->count_order}}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
