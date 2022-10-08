@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_roles_permissions')}} mr-2"></i>{{ ucfirst(__('roles_permissions.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                @if(!isset($roles_permission))
                {{ ucfirst(__('roles_permissions.head_title.add')) }}
                @else
                {{ ucfirst(__('roles_permissions.head_title.edit')) }}
                @endif
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ url('/roles_permissions'.( isset($roles_permission) ? '/' . $roles_permission->id : '')) }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                @if(isset($roles_permission))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row form-group">
                    @if($arrShowField['role_id']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="role_id">{{ucfirst(__('roles_permissions.role_id.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('roles_permissions.role_id.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('roles_permissions.role_id.popover.title')) ,'content'=> ucfirst(__('roles_permissions.role_id.popover.content'))])
                            @endif
                        </label>
                        <select class="form-control" id="role_id" name="role_id" required >
                            <option value="">all</option>
                            @include('components._option_select',['data'=>$arrRole,'selected' => @$role_id])
                        </select>
                         @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('roles_permissions.role_id.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['permission_id']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="permission_id">{{ucfirst(__('roles_permissions.permission_id.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('roles_permissions.permission_id.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('roles_permissions.permission_id.popover.title')) ,'content'=> ucfirst(__('roles_permissions.permission_id.popover.content'))])
                            @endif
                        </label>
                        <select class="form-control" id="permission_id" name="permission_id" required >
                            <option value="">all</option>
                            @include('components._option_select',['data'=>$arrPermission,'selected' => @$permission_id])
                        </select>
                         @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('roles_permissions.permission_id.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="active">{{ucfirst(__('roles_permissions.active.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('roles_permissions.active.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('roles_permissions.active.popover.title')) ,'content'=> ucfirst(__('roles_permissions.active.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$active=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('roles_permissions.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$active!='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('roles_permissions.active.text_radio.false'))}}
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
 * File Create : 2020-09-22 16:55:35 *
 */
-->