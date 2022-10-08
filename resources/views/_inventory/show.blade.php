@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_inventory')}} mr-2"></i>{{ ucfirst(__('inventory.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('inventory.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['billing_id']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="billing_id">{{ucfirst(__('inventory.billing_id.label'))}}
                        @if(__('inventory.billing_id.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('inventory.billing_id.popover.title')) ,'content'=> ucfirst(__('inventory.billing_id.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="billing_id" name="billing_id" disabled value="{{ @$arrBilling[$inventory->billing_id] }}" placeholde="{{__('inventory.billing_id.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['serial']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="serial">{{ucfirst(__('inventory.serial.label'))}}
                        @if(__('inventory.serial.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('inventory.serial.popover.title')) ,'content'=> ucfirst(__('inventory.serial.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="serial" name="serial" disabled value="{{ @$inventory->serial }}" placeholde="{{__('inventory.serial.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['serial_long']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="serial_long">{{ucfirst(__('inventory.serial_long.label'))}}
                        @if(__('inventory.serial_long.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('inventory.serial_long.popover.title')) ,'content'=> ucfirst(__('inventory.serial_long.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="serial_long" name="serial_long" disabled value="{{ @$inventory->serial_long }}" placeholde="{{__('inventory.serial_long.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['imei']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="imei">{{ucfirst(__('inventory.imei.label'))}}
                        @if(__('inventory.imei.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('inventory.imei.popover.title')) ,'content'=> ucfirst(__('inventory.imei.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="imei" name="imei" disabled value="{{ @$inventory->imei }}" placeholde="{{__('inventory.imei.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['material_no']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="material_no">{{ucfirst(__('inventory.material_no.label'))}}
                        @if(__('inventory.material_no.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('inventory.material_no.popover.title')) ,'content'=> ucfirst(__('inventory.material_no.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="material_no" name="material_no" disabled value="{{ @$inventory->material_no }}" placeholde="{{__('inventory.material_no.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['serial_raw']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="serial_raw">{{ucfirst(__('inventory.serial_raw.label'))}}
                        @if(__('inventory.serial_raw.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('inventory.serial_raw.popover.title')) ,'content'=> ucfirst(__('inventory.serial_raw.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="serial_raw" name="serial_raw" disabled value="{{ @$inventory->serial_raw }}" placeholde="{{__('inventory.serial_raw.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['active']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="active">{{ucfirst(__('inventory.active.label'))}}
                        @if(__('inventory.active.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('inventory.active.popover.title')) ,'content'=> ucfirst(__('inventory.active.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="active" disabled {!! ( @$inventory->active=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('inventory.active.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger css-radio">
                            <input type="radio" class="css-control-input" value="0" name="active" disabled {!! ( @$inventory->active!='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('inventory.active.text_radio.false'))}}
                        </label>
                    </div>
                </div>
                @endif
                @if($arrShowField['sale_status']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="sale_status">{{ucfirst(__('inventory.sale_status.label'))}}
                        @if(__('inventory.sale_status.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('inventory.sale_status.popover.title')) ,'content'=> ucfirst(__('inventory.sale_status.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="sale_status" disabled {!! ( @$inventory->sale_status=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('inventory.sale_status.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger  css-radio">
                            <input type="radio" class="css-control-input" value="0" name="sale_status" disabled {!! ( @$inventory->sale_status!='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('inventory.sale_status.text_radio.false'))}}
                        </label>
                    </div>
                </div>
                @endif
            </div>
            <hr>
                <div class="row mb-3">
                    <div class="col">
                        @include('components._btn_back')
                    
                    </div>
                </div>
            <!-- END Content Data -->
        </div>
       
    </div>
    <!-- END Content Main -->
</div>
<!-- END Page Content -->
@endsection
@section('css_after')

@endsection
@section('js_after')

@endsection



<!--
/** 
 * CRUD Laravel
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 18/09/2020 10:51
 * Version : ver.1.00.00
 *
 * File Create : 2021-12-29 17:54:30 *
 */
-->