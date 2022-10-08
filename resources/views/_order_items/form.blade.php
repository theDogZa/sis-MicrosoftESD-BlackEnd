@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_order_items')}} mr-2"></i>{{ ucfirst(__('order_items.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                @if(!isset($orderitem))
                {{ ucfirst(__('order_items.head_title.add')) }}
                @else
                {{ ucfirst(__('order_items.head_title.edit')) }}
                @endif
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ url('/order_items'.( isset($orderitem) ? '/' . $orderitem->id : '')) }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                @if(isset($orderitem))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row form-group">
                    @if($arrShowField['order_id']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="order_id">{{ucfirst(__('order_items.order_id.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('order_items.order_id.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('order_items.order_id.popover.title')) ,'content'=> ucfirst(__('order_items.order_id.popover.content'))])
                            @endif
                        </label>
                        <input type="number" class="form-control" id="order_id" name="order_id" required  value="{{@$order_id}}" placeholde="{{__('order_items.order_id.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('order_items.order_id.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['inventory_id']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="inventory_id">{{ucfirst(__('order_items.inventory_id.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('order_items.inventory_id.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('order_items.inventory_id.popover.title')) ,'content'=> ucfirst(__('order_items.inventory_id.popover.content'))])
                            @endif
                        </label>
                        <select class="form-control" id="inventory_id" name="inventory_id" required >
                            <option value="">all</option>
                            @include('components._option_select',['data'=>$arrInventory,'selected' => @$inventory_id])
                        </select>
                         @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('order_items.inventory_id.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['license_key']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="license_key">{{ucfirst(__('order_items.license_key.label'))}}
                            @if(__('order_items.license_key.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('order_items.license_key.popover.title')) ,'content'=> ucfirst(__('order_items.license_key.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="license_key" name="license_key"   value="{{ @$license_key }}" placeholde="{{__('order_items.license_key.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('order_items.license_key.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['license_at']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="license_at">{{ucfirst(__('order_items.license_at.label'))}}
                            @if(__('order_items.license_at.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('order_items.license_at.popover.title')) ,'content'=> ucfirst(__('order_items.license_at.popover.content'))])
                            @endif
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control input-datetime bg-white js-flatpickr-enabled flatpickr-input"   id="license_at" name="license_at" value="{{@$license_at}}" data-default-date="{{@$license_at}}">
                            <div class="input-group-append">
                                <span class="input-group-text input-toggle" title="toggle">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <span class="input-group-text input-clear" title="clear">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>
                            @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('order_items.license_at.label')) ])
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
 * File Create : 2022-01-05 12:25:55 *
 */
-->