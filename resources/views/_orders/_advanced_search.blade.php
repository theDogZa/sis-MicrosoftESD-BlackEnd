<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('orders.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['customer_name']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="customer_name">{{ucfirst(__('orders.customer_name.label'))}}</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{@$search->customer_name}}">
                    </div>
                    @endif
                    @if($arrShowField['email']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="email">{{ucfirst(__('orders.email.label'))}}</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{@$search->email}}">
                    </div>
                    @endif
                    @if($arrShowField['tel']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="tel">{{ucfirst(__('orders.tel.label'))}}</label>
                        <input type="text" class="form-control" id="tel" name="tel" value="{{@$search->tel}}">
                    </div>
                    @endif
                    @if($arrShowField['path_no']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="path_no">{{ucfirst(__('orders.path_no.label'))}}</label>
                        <input type="text" class="form-control" id="path_no" name="path_no" value="{{@$search->path_no}}">
                    </div>
                    @endif
                    @if($arrShowField['serial']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="serial">{{ucfirst(__('inventory.serial.label'))}}</label>
                        <input type="text" class="form-control" id="serial" name="serial" value="{{@$search->serial}}">
                    </div>
                    @endif
                    @if($arrShowField['receipt_no']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="receipt_no">{{ucfirst(__('orders.receipt_no.label'))}}</label>
                        <input type="text" class="form-control" id="receipt_no" name="receipt_no" value="{{@$search->receipt_no}}">
                    </div>
                    @endif
                    @if($arrShowField['sale_uid']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="sale_uid">{{ucfirst(__('orders.sale_uid.label'))}}</label>
                        <select class="form-control" id="sale_uid" name="sale_uid">
                            <option value="">All</option>
                            @include('components._option_select',['data'=>$arrSaleu,'selected' => @$search->sale_uid])
                        </select>
                    </div>
                    @endif
                    @if($arrShowField['sale_at']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="sale_at">{{ucfirst(__('orders.sale_at.label'))}}</label>
                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-date bg-white js-flatpickr-enabled flatpickr-input" id="sale_at_start" name="sale_at_start" value="{{@$search->sale_at_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control input-date bg-white js-flatpickr-enabled flatpickr-input" id="sale_at_end" name="sale_at_end" value="{{@$search->sale_at_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                    </div>
                    @endif

                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="sold_to">{{ucfirst(__('billings.sold_to.label'))}}</label>
                        <select class="form-control" id="sold_to" name="sold_to">
                            <option value="">All</option>
                            @include('components._option_select',['data'=>$arrSoldTo,'selected' => @$search->sold_to])
                        </select>
                    </div>
                    
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