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
                @if(!isset($inventory))
                {{ ucfirst(__('inventory.head_title.add')) }}
                @else
                {{ ucfirst(__('inventory.head_title.edit')) }}
                @endif
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ url('/inventory'.( isset($inventory) ? '/' . $inventory->id : '')) }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                @if(isset($inventory))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row form-group">
                    @if($arrShowField['billing_id']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="billing_id">{{ucfirst(__('inventory.billing_id.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('inventory.billing_id.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('inventory.billing_id.popover.title')) ,'content'=> ucfirst(__('inventory.billing_id.popover.content'))])
                            @endif
                        </label>
                        <select class="form-control" id="billing_id" name="billing_id" required >
                            <option value="">all</option>
                            @include('components._option_select',['data'=>$arrBilling,'selected' => @$billing_id])
                        </select>
                         @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('inventory.billing_id.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['serial']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="serial">{{ucfirst(__('inventory.serial.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('inventory.serial.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('inventory.serial.popover.title')) ,'content'=> ucfirst(__('inventory.serial.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="serial" name="serial" required  value="{{ @$serial }}" placeholde="{{__('inventory.serial.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('inventory.serial.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['serial_long']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="serial_long">{{ucfirst(__('inventory.serial_long.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('inventory.serial_long.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('inventory.serial_long.popover.title')) ,'content'=> ucfirst(__('inventory.serial_long.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="serial_long" name="serial_long" required  value="{{ @$serial_long }}" placeholde="{{__('inventory.serial_long.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('inventory.serial_long.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['imei']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="imei">{{ucfirst(__('inventory.imei.label'))}}
                            @if(__('inventory.imei.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('inventory.imei.popover.title')) ,'content'=> ucfirst(__('inventory.imei.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="imei" name="imei"   value="{{ @$imei }}" placeholde="{{__('inventory.imei.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('inventory.imei.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['material_no']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="material_no">{{ucfirst(__('inventory.material_no.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('inventory.material_no.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('inventory.material_no.popover.title')) ,'content'=> ucfirst(__('inventory.material_no.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="material_no" name="material_no" required  value="{{ @$material_no }}" placeholde="{{__('inventory.material_no.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('inventory.material_no.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['serial_raw']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="serial_raw">{{ucfirst(__('inventory.serial_raw.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('inventory.serial_raw.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('inventory.serial_raw.popover.title')) ,'content'=> ucfirst(__('inventory.serial_raw.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="serial_raw" name="serial_raw" required  value="{{ @$serial_raw }}" placeholde="{{__('inventory.serial_raw.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('inventory.serial_raw.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="active">{{ucfirst(__('inventory.active.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('inventory.active.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('inventory.active.popover.title')) ,'content'=> ucfirst(__('inventory.active.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$active=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$active!='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.active.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['sale_status']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="sale_status">{{ucfirst(__('inventory.sale_status.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('inventory.sale_status.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('inventory.sale_status.popover.title')) ,'content'=> ucfirst(__('inventory.sale_status.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="sale_status" {!! ( @$sale_status=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('inventory.sale_status.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="0" name="sale_status" {!! ( @$sale_status!='1' ? 'checked' : '' ) !!}>
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
                        @include('components._btn_submit_form')
                        @include('components._btn_reset_form')
                    </div>
                </div>
            </form>
            <!-- END Content Data -->
        </div>
    </div>
    <!-- END Content Main -->
</div>
<!-- END Page Content -->
@endsection
@section('css_after')
<link rel="stylesheet" id="css-flatpickr" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection
@section('js_after')
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script>

    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();

    $(function($) {
        $(".input-datetime").flatpickr({
            allowInput: true,
            enableTime: true,
            time_24hr: true
            // minTime: "16:00",
            // maxTime: "22:30",
        });
        $('.input-datetime').keypress(function() {
            return false;
        });
        $(".input-date").flatpickr({
            allowInput: true,
            // altFormat: "F j, Y",
            // dateFormat: "Y-m-d",
            // minDate: "today",
            //maxDate: new Date().fp_incr(14) // 14 days from now
        });
        $('.input-date').keypress(function() {
            return false;
        });
        $(".input-time").flatpickr({
            allowInput: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
            // minTime: "16:00",
            // maxTime: "22:30",
        });
        $('.input-time').keypress(function() {
            return false;
        });

        $('.input-clear').click(function() {
            $(this).closest('.input-group').find('input').val("");     
        });
        $('.input-toggle').click(function() {
            var idInput = '#'+$(this).closest('.input-group').find('input').attr('id');    
            const calendar = document.querySelector(idInput)._flatpickr;
            calendar.toggle();
        });
    });
</script>
@endsection



<!--
/** 
 * CRUD Laravel
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 06/04/2018 13:51
 * Version : ver.1.00.00
 *
 * File Create : 2021-12-29 17:54:30 *
 */
-->