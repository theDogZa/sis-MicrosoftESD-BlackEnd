<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('inventory.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['billing_id']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="billing_id">{{ucfirst(__('inventory.billing_id.label'))}}</label>
                        <select class="form-control" id="billing_id" name="billing_id">
                            <option value="">All</option>
                            @include('components._option_select',['data'=>$arrBilling,'selected' => @$search->billing_id])
                        </select>
                    </div>
                    @endif
                    @if($arrShowField['serial']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="serial">{{ucfirst(__('inventory.serial.label'))}}</label>
                        <input type="text" class="form-control" id="serial" name="serial" value="{{@$search->serial}}">
                    </div>
                    @endif
                    @if($arrShowField['serial_long']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="serial_long">{{ucfirst(__('inventory.serial_long.label'))}}</label>
                        <input type="text" class="form-control" id="serial_long" name="serial_long" value="{{@$search->serial_long}}">
                    </div>
                    @endif
                    @if($arrShowField['imei']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="imei">{{ucfirst(__('inventory.imei.label'))}}</label>
                        <input type="text" class="form-control" id="imei" name="imei" value="{{@$search->imei}}">
                    </div>
                    @endif
                    @if($arrShowField['material_no']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="material_no">{{ucfirst(__('inventory.material_no.label'))}}</label>
                        <input type="text" class="form-control" id="material_no" name="material_no" value="{{@$search->material_no}}">
                    </div>
                    @endif
                    @if($arrShowField['serial_raw']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="serial_raw">{{ucfirst(__('inventory.serial_raw.label'))}}</label>
                        <input type="text" class="form-control" id="serial_raw" name="serial_raw" value="{{@$search->serial_raw}}">
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="active">{{ucfirst(__('inventory.active.label'))}}</label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all" value="" name="active" {!! ( @$search->active != 'Y' && @$search->active!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.active.text_radio.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$search->active=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$search->active=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.active.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['sale_status']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="sale_status">{{ucfirst(__('inventory.sale_status.label'))}}</label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all" value="" name="sale_status" {!! ( @$search->sale_status                                != 'Y' && @$search->sale_status!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.sale_status.text_radio.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="sale_status" {!! ( @$search->sale_status=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.sale_status.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="0" name="sale_status" {!! ( @$search->sale_status=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.sale_status.text_radio.false'))}}
                            </label>
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