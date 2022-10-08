@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_users')}} mr-2"></i>{{ ucfirst(__('users.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                @if(!isset($user))
                {{ ucfirst(__('users.head_title.add')) }}
                @else
                {{ ucfirst(__('users.head_title.edit')) }}
                @endif
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ url('/users'.( isset($user) ? '/' . $user->id : '')) }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                @if(isset($user))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row form-group">
                    @if($arrShowField['username']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="username">{{ucfirst(__('users.username.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('users.username.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.username.popover.title')) ,'content'=> ucfirst(__('users.username.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="username" name="username" required @if(@$username) readonly @endif  value="{{ @$username }}" placeholde="{{__('users.username.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('users.username.label')) ])
                        <input type="hidden" id="old_username" value="{{ @$username }}" >
                    </div>
                    @endif
                    @if($arrShowField['first_name']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="first_name">{{ucfirst(__('users.first_name.label'))}}
                            @if(__('users.first_name.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.first_name.popover.title')) ,'content'=> ucfirst(__('users.first_name.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="first_name" name="first_name"   value="{{ @$first_name }}" placeholde="{{__('users.first_name.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('users.first_name.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['last_name']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="last_name">{{ucfirst(__('users.last_name.label'))}}
                            @if(__('users.last_name.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.last_name.popover.title')) ,'content'=> ucfirst(__('users.last_name.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="last_name" name="last_name"   value="{{ @$last_name }}" placeholde="{{__('users.last_name.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('users.last_name.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['email']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="email">{{ucfirst(__('users.email.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('users.email.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.email.popover.title')) ,'content'=> ucfirst(__('users.email.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="email" name="email" required  @if(@$email) readonly @endif  value="{{ @$email }}" placeholde="{{__('users.email.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('users.email.label')) ])
                        <input type="hidden" id="old_email" value="{{ @$email }}" >
                    </div>
                    @endif
                    @if($arrShowField['email_verified_at']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="email_verified_at">{{ucfirst(__('users.email_verified_at.label'))}}
                            @if(__('users.email_verified_at.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.email_verified_at.popover.title')) ,'content'=> ucfirst(__('users.email_verified_at.popover.content'))])
                            @endif
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input"  id="email_verified_at" name="email_verified_at" value="{{@$email_verified_at}}" data-default-date="{{@$email_verified_at}}">
                            <div class="input-group-append">
                                <span class="input-group-text input-toggle" title="toggle">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <span class="input-group-text input-clear" title="clear">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>
                            @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('users.email_verified_at.label')) ])
                        </div>
                    </div>
                    @endif
                    @if(!isset($user))
                    <div class="{{config('theme.layout.form')}}">
                        <label for="password">{{ucfirst(__('users.password.label'))}}
                            @if(__('users.password.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.password.popover.title')) ,'content'=> ucfirst(__('users.password.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="password" name="password" required readonly  value="{{ @$password }}" autocomplete="false" placeholde="{{__('users.password.placeholder')}}">
                    </div>
                    @endif
                    {{-- @if($arrShowField['password']==true && !isset($user))
                    <div class="{{config('theme.layout.form')}}">
                        <label for="password">{{ucfirst(__('users.password.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('users.password.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.password.popover.title')) ,'content'=> ucfirst(__('users.password.popover.content'))])
                            @endif
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required  value="{{ @$password }}" autocomplete="false" placeholde="{{__('users.password.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('users.password.label')) ])
                    </div>
                    <div class="{{config('theme.layout.form')}}">
                        <label for="password_confirmation">{{ucfirst(__('users.password_confirmation.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('users.password_confirmation.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.password_confirmation.popover.title')) ,'content'=> ucfirst(__('users.password_confirmation.popover.content'))])
                            @endif
                        </label>
                        <input type="password" class="form-control" id="password_confirmation" required autocomplete="false" value="{{ @$password_confirmation }}" placeholde="{{__('users.password_confirmation.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('users.password_confirmation.label')) ])
                    </div>
                    @endif --}}
                    @if($arrShowField['active']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="active">{{ucfirst(__('users.active.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('users.active.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.active.popover.title')) ,'content'=> ucfirst(__('users.active.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$active=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$active!='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.active.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['activated']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="activated">{{ucfirst(__('users.activated.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('users.activated.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.activated.popover.title')) ,'content'=> ucfirst(__('users.activated.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="activated" {!! ( @$activated=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.activated.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="0" name="activated" {!! ( @$activated!='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.activated.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['user_right']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="user_right">{{ucfirst(__('users.user_right.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('users.user_right.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.user_right.popover.title')) ,'content'=> ucfirst(__('users.user_right.popover.content'))])
                            @endif
                        </label>
                        <div>
                            @php if(!@$user_right) $user_right = 1 @endphp
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="user_right" {!! ( @$user_right=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.1'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-info  css-radio">
                                <input type="radio" class="css-control-input" value="5" name="user_right" {!! ( @$user_right=='5' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.5'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="9" name="user_right" {!! ( @$user_right=='9' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.9'))}}
                            </label>
                        </div>
                    </div>
                    @endif

                    @if($arrShowField['isChangePassword']==true && isset($user))

                    <div class="{{config('theme.layout.form')}}">
                        <label for="is_chang_password">{{ucfirst(__('users.is_chang_password.label'))}}
                            @if(__('users.is_chang_password.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.is_chang_password.popover.title')) ,'content'=> ucfirst(__('users.is_chang_password.popover.content'))])
                            @endif
                        </label>
                        <div class="col-12">
                            <label class="css-control css-control-lg css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" name="isChangePassword"  value="1" {!! (@$isChangePassword==1 ? 'checked' : '' ) !!}>
                                    <span class="css-control-indicator"></span> {{ucfirst(__('users.is_chang_password.text_checkbox.check'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['remember_token']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="remember_token">{{ucfirst(__('users.remember_token.label'))}}
                            @if(__('users.remember_token.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.remember_token.popover.title')) ,'content'=> ucfirst(__('users.remember_token.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="remember_token" name="remember_token"   value="{{ @$remember_token }}" placeholde="{{__('users.remember_token.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('users.remember_token.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['last_login']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="last_login">{{ucfirst(__('users.last_login.label'))}}
                            @if(__('users.last_login.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.last_login.popover.title')) ,'content'=> ucfirst(__('users.last_login.popover.content'))])
                            @endif
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input"   id="last_login" name="last_login" value="{{@$last_login}}" data-default-date="{{@$last_login}}">
                            <div class="input-group-append">
                                <span class="input-group-text input-toggle" title="toggle">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <span class="input-group-text input-clear" title="clear">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>
                            @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('users.last_login.label')) ])
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
@section('js_before')
<script>
let urlChkUsername = "{{ route('chk.username') }}";
let urlChkEmail = "{{ route('chk.email') }}";
</script>
@endsection
@section('js_after')
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
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

                        var reUsername = await _c_username()
                        if(reUsername == false){
                            return;
                        }

                        var reEmail = await _c_email()
                        if(reEmail == false){
                            return;
                        }
                        var oldUsername = $('#old_username').val();

                        if(!oldUsername){

                            // var rePassword = await _c_password()
                            // if(rePassword == false){
                            //     noitMessage('Error','error',"{{ucfirst(__('passwords.message_strong_password'))}}");
                            //     return;
                            // }
                            
                            // var reConPassword = await _c_confirmpassword()
                            // if(reConPassword == false){
                            //     noitMessage('Error','error',"{{ucfirst(__('users.message_password_not_match_confirmation'))}}");
                            //     return;
                            // }

                            var title = "{{ucfirst(__('users.message_confirm_create.title'))}}"
                            var message = "{{ucfirst(__('users.message_confirm_create.message'))}}"
                        }else{
                            var title = "{{ucfirst(__('users.message_confirm_update.title'))}}"
                            var message = "{{ucfirst(__('users.message_confirm_update.message'))}}"
                        }

                        var confirm = await confirmMessage(title,message,'question');
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

    
$('#username').on("focusout", async function () {
    await _c_username()
});

$('#email').on("focusout", async function () {
    await _c_email()
});

// $('#password').on("focusout", async function () {
//     await _c_password()
// });

async function _c_username(){

    var username = $('#username').val(); 
    var oldUsername = $('#old_username').val();
    if (username.length < 4) {
        noitMessage('Error','error',"{{ucfirst(__('users.message_username_min_characters'))}}");  
        return false;
    }

    var ChkUser = await checkUsername();
    if (ChkUser != true) {

        var textInUse = "{{ ucfirst(__('users.username.label')) }} '" + username + "' {{ __('users.message_username_inuse') }} ";
        $('#username').removeClass('is-valid').addClass('is-invalid');
        $('#username').next('.invalid-feedback').text(textInUse);
        return false;
    } else {
        var textUsername = "{{__('validation.required',['attribute'=> ucfirst(__('users.username.label')) ])}} ";
        $('#username').removeClass('is-valid').removeClass('is-invalid');
        $('#username').next('.invalid-feedback').text(textUsername);
        return true;
    }
}
async function _c_email(){

    var email = $('#email').val(); 
    var old_email = $('#old_email').val(); 

    if(email != old_email) {
        var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        if(!pattern.test(email)) {
            noitMessage('Error','error',"{{ucfirst(__('users.message_email_valid'))}}");  
            return false;
        }

        var ChkEmail = await checkEmail();
        if (ChkEmail !== true) {
            var textInUse = "{{ ucfirst(__('users.email.label')) }} '" + email + "' {{ __('users.message_email_inuse') }} ";
            $('#email').removeClass('is-valid').addClass('is-invalid');
            $('#email').next('.invalid-feedback').text(textInUse);
            return false;
        } else {
            var textEmail = "{{__('validation.required',['attribute'=> ucfirst(__('users.email.label')) ])}} ";
            $('#email').removeClass('is-valid').removeClass('is-invalid');
            $('#email').next('.invalid-feedback').text(textEmail);
            return true;
        }
    }
}

// async function _c_password(){

//     let password = $('#password').val(); 

//     if(password){
//         var cp = await checkPassword(password);

//         if (cp != true) {
//             var textPassword = "{{__('validation.required',['attribute'=> ucfirst(__('passwords.message_strong_password')) ])}} ";
            
//             $('#password').removeClass('is-valid').addClass('is-invalid');
//             $('#password').next('.invalid-feedback').text(textPassword);
//             return false;
//         } else {
//         // var textPassword = "{{ ucfirst(__('passwords.strong_password')) }}";
//             var textPassword = "{{__('validation.required',['attribute'=> ucfirst(__('users.password.label')) ])}} ";
//             $('#password').removeClass('is-valid').removeClass('is-invalid');
//             $('#password').next('.invalid-feedback').text(textPassword);
//             return true;
//         }
//     }
// }

// async function _c_confirmpassword(){
//     let password = $('#password').val(); 
//     let password_confirmation = $('#password_confirmation').val();

//     if(password !== password_confirmation){

//         var textConPassword = "{{ ucfirst(__('users.message_password_not_match_confirmation')) }}";
//         $('#password_confirmation').removeClass('is-valid').addClass('is-invalid');
//         $('#password_confirmation').next('.invalid-feedback').text(textConPassword);
//         return false;
//     }else{
//         var textConPassword = "{{__('validation.required',['attribute'=> ucfirst(__('users.password_confirmation.label')) ])}} ";
//         $('#password_confirmation').removeClass('is-valid').removeClass('is-invalid');
//         $('#password_confirmation').next('.invalid-feedback').text(textConPassword);
//         return true;
//     }

// }
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
 * File Create : 2020-09-18 17:11:34 *
 */
-->