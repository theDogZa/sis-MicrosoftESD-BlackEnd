@extends('layouts.auth')

@section('content')
<div class="bg-body-dark bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
    <div class="row mx-0 justify-content-center">
        <div class="hero-static col-lg-6 col-xl-4">
            <div class="content content-full overflow-hidden">
                <div class="py-30 text-center">
                    <a class="link-effect font-w700" href="index.php">
                        <i class="{{config('theme.icon.app')}}"></i>
                        <span class="font-size-xl text-danger">{{ strtoupper(explode(' ', Config::get('app.name'))[0]) }}</span>
                        <span class="font-size-xl">{{ strtoupper(explode(' ', Config::get('app.name'))[1]) }}</span>
                    </a>
                    <h1 class="h4 font-w700 mt-30 mb-10">{{ucfirst(__('users.register.heading'))}}</h1>
                    <h2 class="h5 font-w400 text-muted mb-0">{{ucfirst(__('users.register.heading_sub'))}}</h2>
                </div>

                <form action="{{ route('register') }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate autocomplete="off">
                    @csrf
                    <div class="block block-themed block-rounded block-shadow">
                        <div class="block-header bg-gd-emerald">
                            <h3 class="block-title">{{ucfirst(__('users.register.title'))}}</h3>
                            {{-- <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div> --}}
                        </div>

                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="username">{{ucfirst(__('users.username.label'))}}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="username" name="username" required placeholde="{{__('users.username.placeholder')}}">
                                    @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('users.username.label')) ])
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="first_name">{{ucfirst(__('users.first_name.label'))}}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="first_name" name="first_name"  required placeholde="{{__('users.first_name.placeholder')}}">
                                    @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('users.first_name.label')) ])
                                </div>
                            </div>

                            <div class="form-group row">    
                                <div class="col-12">
                                    <label for="last_name">{{ucfirst(__('users.last_name.label'))}}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required placeholde="{{__('users.last_name.placeholder')}}">
                                    @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('users.last_name.label')) ])
                                </div>
                            </div>

                            <div class="form-group row">    
                                <div class="col-12">
                                    <label for="email">{{ucfirst(__('users.email.label'))}}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="email" name="email" required  value="" placeholde="{{__('users.email.placeholder')}}">
                                    @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('users.email.label')) ])
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="password">{{ucfirst(__('users.password.label'))}}</label>
                                    <span class="text-danger">*</span>
                                    <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password" placeholde="{{__('change_passwords.password.placeholder')}}">
                                    @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('change_passwords.password.label')) ])
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="password-confirm">{{ucfirst(__('users.password_confirmation.label'))}}</label>
                                    <span class="text-danger">*</span>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholde="{{__('change_passwords.password_confirmation.placeholder')}}">
                                    @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('change_passwords.password_confirmation.label')) ])
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-12 text-center push">
                                    <button type="submit" class="btn btn-alt-success">
                                    <i class="fa fa-plus mr-10"></i> {{ucfirst(__('users.register.button'))}}
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="form-group text-center">
                                {{-- <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#" data-toggle="modal" data-target="#modal-terms">
                                    <i class="fa fa-book text-muted mr-5"></i> Read Terms
                                </a> --}}
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="/login">
                                    <i class="fa fa-user text-muted mr-5"></i> {{ucfirst(__('users.login.link'))}}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_after')
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script>
    let urlChkUsername = "{{ route('chk.username') }}";
let urlChkEmail = "{{ route('chk.email') }}";
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

                        var title = "{{ucfirst(__('users.message_confirm_register.title'))}}"
                            var message = "{{ucfirst(__('users.message_confirm_register.message'))}}"

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

$('#password').on("focusout", async function () {
    await _c_password()
});

$('#password_confirmation').on("focusout", async function () {
    await _c_confirmpassword()
});

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

        if(!password_confirmation){
            var textConPassword = "{{__('validation.required',['attribute'=> ucfirst(__('users.password_confirmation.label')) ])}} ";
            $('#password_confirmation').removeClass('is-valid').removeClass('is-invalid');
            $('#password_confirmation').next('.invalid-feedback').text(textConPassword);
            return false;
        }else if(password !== password_confirmation){

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
