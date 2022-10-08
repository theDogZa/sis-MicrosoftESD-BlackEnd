@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container">
    @include('components._breadcrumb',['navigation'=> ['a','b']])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_changePasswords')}} mr-2"></i>{{ ucfirst(__('change_passwords.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('change_passwords.head_title.edit')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ route('changePasswords.store') }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                <div class="row form-group">
                    <div class="col-12 mb-3">
                        <label for="current_password">{{ucfirst(__('change_passwords.current_password.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('change_passwords.current_password.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('change_passwords.current_password.popover.title')) ,'content'=> ucfirst(__('change_passwords.current_password.popover.content'))])
                            @endif
                        </label>
                        <input type="password" class="form-control" id="current_password" value="" name="current_password" required  placeholde="{{__('change_passwords.current_password.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('change_passwords.current_password.label')) ])
                    </div>
                    <div class="col-12 mb-3">
                        <label for="password">{{ucfirst(__('change_passwords.password.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('change_passwords.password.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('change_passwords.password.popover.title')) ,'content'=> ucfirst(__('change_passwords.password.popover.content'))])
                            @endif
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required   placeholde="{{__('change_passwords.password.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('change_passwords.password.label')) ])
                    </div>
                    <div class="col-12 mb-3">
                        <label for="password_confirmation">{{ucfirst(__('change_passwords.password_confirmation.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('change_passwords.password_confirmation.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('change_passwords.username.popover.title')) ,'content'=> ucfirst(__('change_passwords.password_confirmation.popover.content'))])
                            @endif
                        </label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required   placeholde="{{__('change_passwords.password_confirmation.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('change_passwords.password_confirmation.label')) ])
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col">
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

@endsection
@section('js_after')
<script>
    (function() {
        'use strict';
        window.addEventListener('load',async function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms,async function(form) {
                form.addEventListener('submit',async function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }else{
                        event.preventDefault();
                        event.stopPropagation();

                        var ChkPass = await chkPassword();
                        if(ChkPass != true){
                            noitMessage('Error','error',"{{ucfirst(__('change_passwords.message_current_password_not_match'))}}");  
                            return;
                        }

                        var rePassword = await _c_password()
                        if(rePassword == false){
                            noitMessage('Error','error',"{{ucfirst(__('passwords.message_strong_password'))}}");
                            return;
                        }

                        var reConPassword = await _c_confirmpassword()
                        if(reConPassword == false){
                            noitMessage('Error','error',"{{ucfirst(__('users.message_password_not_match_confirmation'))}}");
                            return;
                        }

                        var con = await confirmMessage("{{ucfirst(__('change_passwords.message_confirm_change.title'))}}","{{ucfirst(__('change_passwords.message_confirm_change.message'))}}",'question');
                        if(con == true){
                            $('#form').submit();
                            return;   
                        } 
                    }

                    form.classList.add('was-validated');
                    }, false);
            }); 
        }, false);
        return false;
    })();

    async function chkPassword(){
        var url = "{{ route('chk.pass') }}";
        var current_password = $('#current_password').val();    
        res = $.post(url,{'current_password':current_password})
        .then(function(response) {
            var decodedResponse = atob(response);
            var obj = JSON.parse(decodedResponse);       
            if(obj.code === 200){          
                return obj.message;
            }else{         
                return false;
            }
        })
        .catch(function(err) {       
            return false;
        });
        return await res;
    }

    $('#password').on("focusout", async function () {
        await _c_password()
    });

    $('#password_confirmation').on("focusout", async function () {
        await _c_confirmpassword()
    });

    async function _c_password(){

        let password = $('#password').val(); 

        if(password){
            var cp = await checkPassword(password);

            if (cp != true) {
                var textPassword = "{{__('validation.required',['attribute'=> ucfirst(__('passwords.message_strong_password')) ])}} ";
                
                $('#password').removeClass('is-valid').addClass('is-invalid');
                $('#password').next('.invalid-feedback').text(textPassword);
                return false;
            } else {
                var textPassword = "{{__('validation.required',['attribute'=> ucfirst(__('users.password.label')) ])}} ";
                $('#password').removeClass('is-valid').removeClass('is-invalid');
                $('#password').next('.invalid-feedback').text(textPassword);
                return true;
            }
        }
    }

    async function _c_confirmpassword(){
        let password = $('#password').val(); 
        let password_confirmation = $('#password_confirmation').val();

        if(password !== password_confirmation){

            var textConPassword = "{{ ucfirst(__('users.message_password_not_match_confirmation')) }}";
            $('#password_confirmation').removeClass('is-valid').addClass('is-invalid');
            $('#password_confirmation').next('.invalid-feedback').text(textConPassword);
            return false;
        }else{
            var textConPassword = "{{__('validation.required',['attribute'=> ucfirst(__('users.password_confirmation.label')) ])}} ";
            $('#password_confirmation').removeClass('is-valid').removeClass('is-invalid');
            $('#password_confirmation').next('.invalid-feedback').text(textConPassword);
            return true;
        }
    }

</script>

@endsection
@section('js_after_noit')

@if(Session::has('noit_message'))
<script>
$(document).ready(async function(){

    var title = "{{ ucfirst(Session::get('noit_status')) }}";
    var type = "{{ Session::get('noit_status') }}";
    var message = "{{ ucfirst(Session::get('noit_message'))}}";

    var ok = await noitMessage(title,type,message);

    if(ok == true){
        window.location.href = "{{ route('logout') }}";
    }

});

</script>
@php
Session::forget('noit_message');
Session::forget('noit_status');
@endphp
@endif
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
 * File Create : 2020-09-18 17:11:34 *
 */
-->