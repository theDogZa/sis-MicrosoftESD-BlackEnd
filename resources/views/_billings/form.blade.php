@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_billings')}} mr-2"></i>{{ ucfirst(__('billings.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                @if(!isset($billing))
                {{ ucfirst(__('billings.head_title.add')) }}
                @else
                {{ ucfirst(__('billings.head_title.edit')) }}
                @endif
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ url('/billings'.( isset($billing) ? '/' . $billing->id : '')) }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                @if(isset($billing))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row form-group">
                    @if($arrShowField['sold_to']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="sold_to">{{ucfirst(__('billings.sold_to.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.sold_to.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.sold_to.popover.title')) ,'content'=> ucfirst(__('billings.sold_to.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="sold_to" name="sold_to" required  value="{{ @$sold_to }}" placeholde="{{__('billings.sold_to.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.sold_to.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['billing_no']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="billing_no">{{ucfirst(__('billings.billing_no.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.billing_no.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.billing_no.popover.title')) ,'content'=> ucfirst(__('billings.billing_no.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="billing_no" name="billing_no" required  value="{{ @$billing_no }}" placeholde="{{__('billings.billing_no.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.billing_no.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['billing_item']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="billing_item">{{ucfirst(__('billings.billing_item.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.billing_item.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.billing_item.popover.title')) ,'content'=> ucfirst(__('billings.billing_item.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="billing_item" name="billing_item" required  value="{{ @$billing_item }}" placeholde="{{__('billings.billing_item.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.billing_item.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['billing_at']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="billing_at">{{ucfirst(__('billings.billing_at.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.billing_at.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.billing_at.popover.title')) ,'content'=> ucfirst(__('billings.billing_at.popover.content'))])
                            @endif
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control input-date bg-white js-flatpickr-enabled flatpickr-input" required  id="billing_at" name="billing_at" value="{{@$billing_at}}" data-default-date="{{@$billing_at}}">
                            <div class="input-group-append">
                                <span class="input-group-text input-toggle" title="toggle">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <span class="input-group-text input-clear" title="clear">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>
                            @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.billing_at.label')) ])
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['material_no']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="material_no">{{ucfirst(__('billings.material_no.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.material_no.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.material_no.popover.title')) ,'content'=> ucfirst(__('billings.material_no.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="material_no" name="material_no" required  value="{{ @$material_no }}" placeholde="{{__('billings.material_no.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.material_no.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['material_desc']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="material_desc">{{ucfirst(__('billings.material_desc.label'))}}
                            @if(__('billings.material_desc.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.material_desc.popover.title')) ,'content'=> ucfirst(__('billings.material_desc.popover.content'))])
                            @endif
                        </label>
                        <textarea class="form-control" id="material_desc" name="material_desc" rows="3"   placeholde="{{__('billings.material_desc.placeholder')}}">{{@$material_desc}}</textarea>
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('billings.material_desc.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['qty']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="qty">{{ucfirst(__('billings.qty.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.qty.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.qty.popover.title')) ,'content'=> ucfirst(__('billings.qty.popover.content'))])
                            @endif
                        </label>
                        <input type="number" class="form-control" id="qty" name="qty" required  value="{{@$qty}}" placeholde="{{__('billings.qty.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.qty.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['po_no']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="po_no">{{ucfirst(__('billings.po_no.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.po_no.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.po_no.popover.title')) ,'content'=> ucfirst(__('billings.po_no.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="po_no" name="po_no" required  value="{{ @$po_no }}" placeholde="{{__('billings.po_no.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.po_no.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['vendor_article']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="vendor_article">{{ucfirst(__('billings.vendor_article.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.vendor_article.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.vendor_article.popover.title')) ,'content'=> ucfirst(__('billings.vendor_article.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="vendor_article" name="vendor_article" required  value="{{ @$vendor_article }}" placeholde="{{__('billings.vendor_article.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.vendor_article.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['sale_count']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="sale_count">{{ucfirst(__('billings.sale_count.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.sale_count.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.sale_count.popover.title')) ,'content'=> ucfirst(__('billings.sale_count.popover.content'))])
                            @endif
                        </label>
                        <input type="number" class="form-control" id="sale_count" name="sale_count" required  value="{{@$sale_count}}" placeholde="{{__('billings.sale_count.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.sale_count.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['remaining_amount']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="remaining_amount">{{ucfirst(__('billings.remaining_amount.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.remaining_amount.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.remaining_amount.popover.title')) ,'content'=> ucfirst(__('billings.remaining_amount.popover.content'))])
                            @endif
                        </label>
                        <input type="number" class="form-control" id="remaining_amount" name="remaining_amount" required  value="{{@$remaining_amount}}" placeholde="{{__('billings.remaining_amount.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('billings.remaining_amount.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="active">{{ucfirst(__('billings.active.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('billings.active.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('billings.active.popover.title')) ,'content'=> ucfirst(__('billings.active.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$active=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('billings.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$active!='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('billings.active.text_radio.false'))}}
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
 * File Create : 2021-12-29 17:59:13 *
 */
-->