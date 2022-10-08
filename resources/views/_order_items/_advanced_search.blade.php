<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('order_items.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['order_id']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="order_id">{{ucfirst(__('order_items.order_id.label'))}}</label>
                        <div class="input-daterange input-group">
                            <input type="number" class="form-control" id="order_id_start" name="order_id_start" value="{{@$search->order_id_start}}" placeholder="From">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="number" class="form-control" id="order_id_end" name="order_id_end" value="{{@$search->order_id_end}}" placeholder="To">
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['inventory_id']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="inventory_id">{{ucfirst(__('order_items.inventory_id.label'))}}</label>
                        <select class="form-control" id="inventory_id" name="inventory_id">
                            <option value="">All</option>
                            @include('components._option_select',['data'=>$arrInventory,'selected' => @$search->inventory_id])
                        </select>
                    </div>
                    @endif
                    @if($arrShowField['license_key']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="license_key">{{ucfirst(__('order_items.license_key.label'))}}</label>
                        <input type="text" class="form-control" id="license_key" name="license_key" value="{{@$search->license_key}}">
                    </div>
                    @endif
                    @if($arrShowField['license_at']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="license_at">{{ucfirst(__('order_items.license_at.label'))}}</label>
                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-datetime bg-white js-flatpickr-enabled flatpickr-input" id="license_at_start" name="license_at_start" value="{{@$search->license_at_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control input-datetime bg-white js-flatpickr-enabled flatpickr-input" id="license_at_end" name="license_at_end" value="{{@$search->license_at_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                    </div>
                    @endif
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            @include('components.button._submin_search')
                            @include('components.button._reset',['class'=>'btn-sm btn-reset-search'])
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>