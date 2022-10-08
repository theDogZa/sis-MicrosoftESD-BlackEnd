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
                @if (session('status'))
                    <div class="alert alert-success mt-3 mb-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="js-validation-signin" action="{{ route('password.email') }}" method="post" novalidate="novalidate" autocomplete="off">
                    @csrf
                    <div class="block block-themed block-rounded block-shadow">
                        <div class="block-header bg-gd-dusk">
                            <h3 class="block-title"><i class="fa fa-warning mr-5"></i> {{ __('Reset Password') }}</h3>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                     @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row mb-0">
                                <div class="col-12 text-center push">
                                    <button type="submit" class="btn btn-alt-primary">
                                    <i class="fa fa-send-o mr-10"></i> {{ __('Send Password Reset Link') }}
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
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
