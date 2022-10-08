<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('billings.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['sold_to']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="sold_to">{{ucfirst(__('billings.sold_to.label'))}}</label>
                        <input type="text" class="form-control" id="sold_to" name="sold_to" value="{{@$search->sold_to}}">
                    </div>
                    @endif
                    @if($arrShowField['billing_no']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="billing_no">{{ucfirst(__('billings.billing_no.label'))}}</label>
                        <input type="text" class="form-control" id="billing_no" name="billing_no" value="{{@$search->billing_no}}">
                    </div>
                    @endif
                    @if($arrShowField['billing_item']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="billing_item">{{ucfirst(__('billings.billing_item.label'))}}</label>
                        <input type="text" class="form-control" id="billing_item" name="billing_item" value="{{@$search->billing_item}}">
                    </div>
                    @endif
                    @if($arrShowField['billing_at']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="billing_at">{{ucfirst(__('billings.billing_at.label'))}}</label>
                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-date bg-white js-flatpickr-enabled flatpickr-input" id="billing_at_start" name="billing_at_start" value="{{@$search->billing_at_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control input-date bg-white js-flatpickr-enabled flatpickr-input" id="billing_at_end" name="billing_at_end" value="{{@$search->billing_at_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['material_no']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="material_no">{{ucfirst(__('billings.material_no.label'))}}</label>
                        <input type="text" class="form-control" id="material_no" name="material_no" value="{{@$search->material_no}}">
                    </div>
                    @endif
                    @if($arrShowField['material_desc']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="material_desc">{{ucfirst(__('billings.material_desc.label'))}}</label>
                        <input type="text" class="form-control" id="material_desc" name="material_desc" value="{{@$search->material_desc}}">
                    </div>
                    @endif
                    @if($arrShowField['qty']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="qty">{{ucfirst(__('billings.qty.label'))}}</label>
                        <div class="input-daterange input-group">
                            <input type="number" class="form-control" id="qty_start" name="qty_start" value="{{@$search->qty_start}}" placeholder="From">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="number" class="form-control" id="qty_end" name="qty_end" value="{{@$search->qty_end}}" placeholder="To">
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['po_no']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="po_no">{{ucfirst(__('billings.po_no.label'))}}</label>
                        <input type="text" class="form-control" id="po_no" name="po_no" value="{{@$search->po_no}}">
                    </div>
                    @endif
                    @if($arrShowField['vendor_article']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="vendor_article">{{ucfirst(__('billings.vendor_article.label'))}}</label>
                        <input type="text" class="form-control" id="vendor_article" name="vendor_article" value="{{@$search->vendor_article}}">
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="active">{{ucfirst(__('billings.active.label'))}}</label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all" value="" name="active" {!! ( @$search->active != 'Y' && @$search->active!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('billings.active.text_radio.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$search->active=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('billings.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$search->active=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('billings.active.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['sale_count']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="sale_count">{{ucfirst(__('billings.sale_count.label'))}}</label>
                        <div class="input-daterange input-group">
                            <input type="number" class="form-control" id="sale_count_start" name="sale_count_start" value="{{@$search->sale_count_start}}" placeholder="From">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="number" class="form-control" id="sale_count_end" name="sale_count_end" value="{{@$search->sale_count_end}}" placeholder="To">
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['remaining_amount']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="remaining_amount">{{ucfirst(__('billings.remaining_amount.label'))}}</label>
                        <div class="input-daterange input-group">
                            <input type="number" class="form-control" id="remaining_amount_start" name="remaining_amount_start" value="{{@$search->remaining_amount_start}}" placeholder="From">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="number" class="form-control" id="remaining_amount_end" name="remaining_amount_end" value="{{@$search->remaining_amount_end}}" placeholder="To">
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