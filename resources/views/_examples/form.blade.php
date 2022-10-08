@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_examples')}} mr-2"></i>{{ ucfirst(__('examples.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                @if(!isset($example))
                {{ ucfirst(__('examples.head_title.add')) }}
                @else
                {{ ucfirst(__('examples.head_title.edit')) }}
                @endif
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ url('/examples'.( isset($example) ? '/' . $example->id : '')) }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                @if(isset($example))
                <input type="hidden" name="_method" value="'PUT'">
                @endif
                <div class="row form-group">
                    @if($arrShowField['parent_id']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="parent_id">{{ucfirst(__('examples.parent_id.label'))}}
                            @if(__('examples.parent_id.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.parent_id.popover.title')) ,'content'=> ucfirst(__('examples.parent_id.popover.content'))])
                            @endif
                        </label>
                        <select class="form-control" id="parent_id" name="parent_id"  >
                            <option value="">all</option>
                            @include('components._option_select',['data'=>$arrParent,'selected' => @$parent_id])
                        </select>
                         @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('examples.parent_id.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['users_id']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="users_id">{{ucfirst(__('examples.users_id.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('examples.users_id.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.users_id.popover.title')) ,'content'=> ucfirst(__('examples.users_id.popover.content'))])
                            @endif
                        </label>
                        <select class="form-control" id="users_id" name="users_id" required >
                            <option value="">all</option>
                            @include('components._option_select',['data'=>$arrUsers,'selected' => @$users_id])
                        </select>
                         @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('examples.users_id.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['title']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="title">{{ucfirst(__('examples.title.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('examples.title.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.title.popover.title')) ,'content'=> ucfirst(__('examples.title.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="title" name="title" required  value="{{ @$title }}" placeholde="{{__('examples.title.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('examples.title.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['body']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="body">{{ucfirst(__('examples.body.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('examples.body.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.body.popover.title')) ,'content'=> ucfirst(__('examples.body.popover.content'))])
                            @endif
                        </label>
                        <textarea class="form-control" id="body" name="body" rows="3" required  placeholde="{{__('examples.body.placeholder')}}">{{@$body}}</textarea>
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('examples.body.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['amount']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="amount">{{ucfirst(__('examples.amount.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('examples.amount.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.amount.popover.title')) ,'content'=> ucfirst(__('examples.amount.popover.content'))])
                            @endif
                        </label>
                        <input type="number" class="form-control" id="amount" name="amount" required  value="{{@$amount}}" placeholde="{{__('examples.amount.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('examples.amount.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['date']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="date">{{ucfirst(__('examples.date.label'))}}
                            @if(__('examples.date.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.date.popover.title')) ,'content'=> ucfirst(__('examples.date.popover.content'))])
                            @endif
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control input-date bg-white js-flatpickr-enabled flatpickr-input"   id="date" name="date" value="{{@$date}}" data-default-date="{{@$date}}">
                            <div class="input-group-append">
                                <span class="input-group-text input-toggle" title="toggle">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <span class="input-group-text input-clear" title="clear">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>
                            @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('examples.date.label')) ])
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['time']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="time">{{ucfirst(__('examples.time.label'))}}
                            @if(__('examples.time.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.time.popover.title')) ,'content'=> ucfirst(__('examples.time.popover.content'))])
                            @endif
                        </label>
                         <div class="input-group">
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input"   id="time" name="time" value="{{@$time}}" data-default-date="{{@$time}}">
                            <div class="input-group-append">
                                <span class="input-group-text input-toggle" title="toggle">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <span class="input-group-text input-clear" title="clear">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>
                            @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('examples.time.label')) ])
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['datetime']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="datetime">{{ucfirst(__('examples.datetime.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('examples.datetime.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.datetime.popover.title')) ,'content'=> ucfirst(__('examples.datetime.popover.content'))])
                            @endif
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control input-datetime bg-white js-flatpickr-enabled flatpickr-input" required  id="datetime" name="datetime" value="{{@$datetime}}" data-default-date="{{@$datetime}}">
                            <div class="input-group-append">
                                <span class="input-group-text input-toggle" title="toggle">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <span class="input-group-text input-clear" title="clear">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>
                            @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('examples.datetime.label')) ])
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['status']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="status">{{ucfirst(__('examples.status.label'))}}
                            @if(__('examples.status.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.status.popover.title')) ,'content'=> ucfirst(__('examples.status.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="status" {!! ( @$status=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.status.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="0" name="status" {!! ( @$status!='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.status.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="active">{{ucfirst(__('examples.active.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('examples.active.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('examples.active.popover.title')) ,'content'=> ucfirst(__('examples.active.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$active=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$active!='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.active.text_radio.false'))}}
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
 * File Create : 2020-09-18 17:10:04 *
 */
-->