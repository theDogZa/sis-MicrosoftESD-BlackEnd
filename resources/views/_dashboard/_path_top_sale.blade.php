<div class="block block-rounded block-bordered">
    <div class="block-header block-header-default border-b bg-primary-light">
        <h3 class="block-title">Path No Top Sales <small> (10 Record)</small> </h3>
        <div class="block-options">
            <button type="button" class="btn-block-option">
                <i class="fa fa-pie-chart icon-ats" id="ats-icon-chart" style="display: none"> Display chart</i>
                <i class="fa fa-table icon-ats" id="ats-icon-table"> Display table</i>
            </button>
        </div>
    </div>
    <div class="block-content" id="ats_content">

        <table class="table table-borderless table-striped ats-content" id="ats-content-table" style="display: none;">
            <thead>
                <tr>
                    <th>Part no</th>
                    <th class="text-right">QTY</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pathTopSale as $item)
                <tr>
                    <td>
                        {{$item->path_no}}
                    </td>
                    <td class="text-right">
                        <span class="text-black"> {{ number_format($item->TOTALQTY) }} </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div id="ats-content-chart" class="ats-content pl-2 pr-2 pb-2">
            <canvas id="ats-chart" width="400" height="400"></canvas>
        </div>
    </div>
</div>