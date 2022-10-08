@extends('layouts.auth')

@section('content')
<div class="bg-body-dark bg-pattern" style="background-image: url('');">
    <div class="row mx-0 justify-content-center">
        <div class="hero-static col-lg-6 col-xl-4">
            <div class="content content-full overflow-hidden">
                <div class="py-30 text-center">
                    <a class="link-effect font-w700" href="/">
                        <i class="{{config('theme.icon.app')}}"></i>
                        <span class="font-size-xl text-danger">{{ strtoupper(explode(' ', Config::get('app.name'))[0]) }}</span>
                        <span class="font-size-xl">{{ strtoupper(explode(' ', Config::get('app.name'))[1]) }}</span>
                    </a>
                </div>
                {{-- <form class="js-validation-signin" action="{{ route('password.update') }}" method="post" novalidate="novalidate" autocomplete="off"> --}}
                <form action="{{ route('password.update') }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="block block-themed block-rounded block-shadow">
                        <div class="block-header bg-gd-dusk">
                            <h3 class="block-title"><i class="fa fa-warning mr-5"></i> {{ucfirst(__('change_passwords.reset.title'))}}</h3>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="email">{{ucfirst(__('change_passwords.email.label'))}}</label>
                                    <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <div class="col-12">
                                    <label for="username">{{ __('User Name') }}</label>
                                    <input id="username" type="text" readonly class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $username ?? old('username') }}" required autocomplete="username" autofocus>
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="password">{{ucfirst(__('change_passwords.password.label'))}}</label>
                                    <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password" placeholde="{{__('change_passwords.password.placeholder')}}">
                                    @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('change_passwords.password.label')) ])
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="password-confirm">{{ucfirst(__('change_passwords.password_confirmation.label'))}}</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholde="{{__('change_passwords.password_confirmation.placeholder')}}">
                                    @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('change_passwords.password_confirmation.label')) ])
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-12 text-center push">
                                    <button type="submit" class="btn btn-alt-primary">
                                    <i class="fa fa-send-o mr-10"></i> {{ucfirst(__('change_passwords.reset.button'))}}
                                    </button>
                                </div>
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