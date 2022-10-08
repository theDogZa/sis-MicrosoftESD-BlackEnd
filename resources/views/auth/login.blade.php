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
                        <div><span class="font-size-xl text-dark">Backend System</span></div>
                    </a>
                    <h1 class="h4 font-w700 mt-30 mb-10">{{ucfirst(__('users.login.heading'))}}</h1>
                    <h2 class="h5 font-w400 text-muted mb-0">{{ucfirst(__('users.login.heading_sub'))}}</h2>
                </div>
                @if (session('register'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ session('register') }}</li>
                        </ul>
                    </div>
                    @php
                    Session()->flush();
                    @endphp
                @elseif($errors->any() || session('error'))
                <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            @if( session('error'))
                                <li>{{ session('error') }}</li>
                            @endif
                        </ul>
                    </div>
                @endif
                <form class="js-validation-signin" action="{{ route('login') }}" method="post" novalidate="novalidate" autocomplete="off">
                    @csrf
                    <div class="block block-themed block-rounded block-shadow">
                        <div class="block-header bg-gd-dusk">
                            <h3 class="block-title">{{ucfirst(__('users.login.title'))}}</h3>
                            {{-- <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div> --}}
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-username">{{ucfirst(__('users.username.label'))}}</label>
                                    <input type="text" class="form-control" id="login-username" name="username">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-password">{{ucfirst(__('users.password.label'))}}</label>
                                    <input type="password" class="form-control" id="login-password" name="password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                {{-- <div class="col-sm-6 d-sm-flex align-items-center push">
                                    <div class="custom-control custom-checkbox mr-auto ml-0 mb-0">
                                        <input type="checkbox" class="custom-control-input" id="login-remember-me" name="login-remember-me">
                                        <label class="custom-control-label" for="login-remember-me">Remember Me</label>
                                    </div>
                                </div> --}}
                                <div class="col-12 text-center push">
                                    <button type="submit" class="btn btn-alt-primary">
                                        <i class="si si-login mr-10"></i> {{ucfirst(__('users.login.button'))}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="form-group text-center">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="/register">
                                    <i class="fa fa-plus mr-5"></i> {{ucfirst(__('users.register.link'))}}
                                </a>
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{ route('password.request') }}">
                                    <i class="fa fa-warning mr-5"></i>  {{ __('Forgot Your Password?') }}
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
