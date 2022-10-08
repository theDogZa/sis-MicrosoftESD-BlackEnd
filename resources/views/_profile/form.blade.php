@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container">
    @include('components._breadcrumb')
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_profiles')}} mr-2"></i>{{ ucfirst(__('profiles.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('profiles.head_title')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ route('profiles.store') }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}

                <div class="row form-group">
                    @if($arrShowField['username']==true)
                    <div class="col-12 mb-3">
                        <label for="username">{{ucfirst(__('profiles.username.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('profiles.username.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('profiles.username.popover.title')) ,'content'=> ucfirst(__('profiles.username.popover.content'))])
                            @endif
                        </label>
                        <input type="hidden" id="old_username" value="{{ @$username }}" >
                        <input type="text" class="form-control" id="username" name="username" required  value="{{ @$username }}" placeholde="{{__('profiles.username.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('profiles.username.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['password']==true)
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
                    @endif
                    @if($arrShowField['first_name']==true)
                    <div class="col-12 mb-3">
                        <label for="first_name">{{ucfirst(__('profiles.first_name.label'))}}
                            @if(__('profiles.first_name.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('profiles.first_name.popover.title')) ,'content'=> ucfirst(__('profiles.first_name.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="first_name" name="first_name"   value="{{ @$first_name }}" placeholde="{{__('profiles.first_name.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('profiles.first_name.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['last_name']==true)
                    <div class="col-12 mb-3">
                        <label for="last_name">{{ucfirst(__('profiles.last_name.label'))}}
                            @if(__('profiles.last_name.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('profiles.last_name.popover.title')) ,'content'=> ucfirst(__('profiles.last_name.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="last_name" name="last_name"   value="{{ @$last_name }}" placeholde="{{__('profiles.last_name.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('profiles.last_name.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['email']==true)
                    <div class="col-12 mb-3">
                        <label for="email">{{ucfirst(__('profiles.email.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('profiles.email.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('profiles.email.popover.title')) ,'content'=> ucfirst(__('profiles.email.popover.content'))])
                            @endif
                        </label>
                        <input type="hidden" id="old_email" value="{{ @$email }}" >
                        <input type="text" class="form-control" id="email" name="email" required  value="{{ @$email }}" placeholde="{{__('profiles.email.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('profiles.email.label')) ])
                    </div>
                    @endif

                    @if($arrShowField['last_login']==true)
                    <div class="col-12 mb-3">
                        <label for="last_login">{{ucfirst(__('profiles.last_login.label'))}}
                            @if(__('profiles.last_login.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('profiles.last_login.popover.title')) ,'content'=> ucfirst(__('profiles.last_login.popover.content'))])
                            @endif
                        </label>
                        <div class="input-group">
                            <input type="text" disabled class="form-control" id="last_login" value="{{ @session('last_login') }}" >          
                        </div>
                    </div>
                    @endif
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
{{-- @include('components._notify_message') --}}
<!-- END Page Content -->
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
               
                var username = $('#username').val(); 
                if (username.length < 4) {
                    noitMessage('Error','error',"{{ucfirst(__('profiles.message_username_min_characters'))}}");  
                    return;
                }

                var ChkUser = await chkUsername();
                if(ChkUser != true){
                    var username = $('#username').val(); 
                    var textInUse = "{{ ucfirst(__('profiles.username.label')) }} '"+ username +"' {{ __('profiles.message_username_inuse') }} ";
                    $('#username').removeClass('is-valid').addClass('is-invalid');
                    $('#username').next('.invalid-feedback').text(textInUse);
                    noitMessage('Error','error',"''"+username+"''"+ textInUse); 
                    return;
                }else{
                    var textUsername = "{{__('validation.required',['attribute'=> ucfirst(__('profiles.username.label')) ])}} ";
                    $('#username').removeClass('is-valid').removeClass('is-invalid');
                    $('#username').next('.invalid-feedback').text(textUsername);
                }

                var ChkPass = await chkPassword();
                if(ChkPass != true){
                    noitMessage('Error','error',"{{ucfirst(__('change_passwords.message_current_password_not_match'))}}");  
                    return;
                }

                var email = $('#email').val(); 
                var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
                if(!pattern.test(email))
                {
                    noitMessage('Error','error',"{{ucfirst(__('profiles.message_email_valid'))}}");  
                    return;
                }

                var ChkEmail = await chkEmail();
                if(ChkEmail != true){
                    var email = $('#email').val(); 
                    var textInUse = "{{ ucfirst(__('profiles.email.label')) }} '"+ email +"' {{ __('profiles.message_email_inuse') }} ";
                    noitMessage('Error','error',textInUse);  
                    $('#email').removeClass('is-valid').addClass('is-invalid');
                    $('#email').next('.invalid-feedback').text(textInUse);
                    return;
                }else{
                    var textEmail = "{{__('validation.required',['attribute'=> ucfirst(__('profiles.email.label')) ])}} ";
                    $('#email').removeClass('is-valid').removeClass('is-invalid');
                    $('#email').next('.invalid-feedback').text(textEmail);
                }
                var confirm = await confirmMessage("{{ucfirst(__('profiles.message_confirm_change.title'))}}","{{ucfirst(__('profiles.message_confirm_change.message'))}}",'question');
                if(confirm == true){
                    $('#form').submit();
                    return;   
                }    
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();

    $('#username').on("focusout",async function(){
        var ChkUser = await chkUsername();
        if(ChkUser != true){
            var username = $('#username').val(); 
            var textInUse = "{{ ucfirst(__('profiles.username.label')) }} '"+ username +"' {{ __('profiles.message_username_inuse') }} ";
            $('#username').removeClass('is-valid').addClass('is-invalid');
            $('#username').next('.invalid-feedback').text(textInUse);
        }else{
           var textUsername = "{{__('validation.required',['attribute'=> ucfirst(__('profiles.username.label')) ])}} ";
            $('#username').removeClass('is-valid').removeClass('is-invalid');
            $('#username').next('.invalid-feedback').text(textUsername);
        }
    });

    $('#current_password').on("focusout",async function(){
        var ChkUser = await chkPassword();
        if(ChkUser != true){
            noitMessage('Error','error',"{{ucfirst(__('change_passwords.message_current_password_not_match'))}}");  
            return;
        }
    });

    $('#email').on("focusout",async function(){
        var ChkEmail = await chkEmail();
        if(ChkEmail !== true){
            var email = $('#email').val(); 
            var textInUse = "{{ ucfirst(__('profiles.email.label')) }} '"+ email +"' {{ __('profiles.message_email_inuse') }} ";
            $('#email').removeClass('is-valid').addClass('is-invalid');
            $('#email').next('.invalid-feedback').text(textInUse);
        }else{
            var textEmail = "{{__('validation.required',['attribute'=> ucfirst(__('profiles.email.label')) ])}} ";
            $('#email').removeClass('is-valid').removeClass('is-invalid');
            $('#email').next('.invalid-feedback').text(textEmail);  
        }
    });

    async function chkUsername(){

        var url = "{{ route('chk.username') }}";
        var username = $('#username').val(); 
        var old_username = $('#old_username').val();        
        if(old_username !== username){
  
            res = $.post(url,{'username':username})
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

        }else{
            return await true;
        }
    }

    async function chkEmail(){

        var url = "{{ route('chk.email') }}";
        var email = $('#email').val(); 
        var old_email = $('#old_email').val();
        if(old_email !== email){
  
            res = $.post(url,{'email':email})
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

        }else{
            return await true;
        }
    } 
    
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

    ///----- on login notes is use chang profile
  
</script>
<style>
.was-validated .form-control:invalid, .form-control.is-invalid, .was-validated .custom-select:invalid, .custom-select.is-invalid {
    border-color: #ef5350 !important;
}
</style>
@endsection
@section('js_after_noit')

@if(Session::has('noit_message'))
<script>

$(document).ready(async function(){

  var title = "{{ ucfirst(Session::get('noit_status')) }}";
  var type = "{{ Session::get('noit_status') }}";
  var message = "{{ ucfirst(Session::get('noit_message'))}}";

  var ok = await noitMessage(title,type,message);
  console.log('hkjhk');
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