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
                {{ ucfirst(__('users.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['username']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="username">{{ucfirst(__('users.username.label'))}}
                        @if(__('users.username.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.username.popover.title')) ,'content'=> ucfirst(__('users.username.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="username" name="username" disabled value="{{ @$user->username }}" placeholde="{{__('users.username.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['first_name']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="first_name">{{ucfirst(__('users.first_name.label'))}}
                        @if(__('users.first_name.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.first_name.popover.title')) ,'content'=> ucfirst(__('users.first_name.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="first_name" name="first_name" disabled value="{{ @$user->first_name }}" placeholde="{{__('users.first_name.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['last_name']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="last_name">{{ucfirst(__('users.last_name.label'))}}
                        @if(__('users.last_name.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.last_name.popover.title')) ,'content'=> ucfirst(__('users.last_name.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="last_name" name="last_name" disabled value="{{ @$user->last_name }}" placeholde="{{__('users.last_name.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['email']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="email">{{ucfirst(__('users.email.label'))}}
                        @if(__('users.email.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.email.popover.title')) ,'content'=> ucfirst(__('users.email.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="email" name="email" disabled value="{{ @$user->email }}" placeholde="{{__('users.email.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['email_verified_at']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="email_verified_at">{{ucfirst(__('users.email_verified_at.label'))}}
                        @if(__('users.email_verified_at.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.email_verified_at.popover.title')) ,'content'=> ucfirst(__('users.email_verified_at.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time  js-flatpickr-enabled flatpickr-input" disabled id="email_verified_at" name="email_verified_at" value="{{@$user->email_verified_at}}">
                    </div>
                </div>
                @endif
                @if($arrShowField['password']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="password">{{ucfirst(__('users.password.label'))}}
                        @if(__('users.password.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.password.popover.title')) ,'content'=> ucfirst(__('users.password.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="password" name="password" disabled value="{{ @$user->password }}" placeholde="{{__('users.password.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['active']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="active">{{ucfirst(__('users.active.label'))}}
                        @if(__('users.active.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.active.popover.title')) ,'content'=> ucfirst(__('users.active.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="active" disabled {!! ( @$user->active=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('users.active.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger css-radio">
                            <input type="radio" class="css-control-input" value="0" name="active" disabled {!! ( @$user->active!='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('users.active.text_radio.false'))}}
                        </label>
                    </div>
                </div>
                @endif
                @if($arrShowField['activated']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="activated">{{ucfirst(__('users.activated.label'))}}
                        @if(__('users.activated.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.activated.popover.title')) ,'content'=> ucfirst(__('users.activated.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="activated" disabled {!! ( @$user->activated=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('users.activated.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger  css-radio">
                            <input type="radio" class="css-control-input" value="0" name="activated" disabled {!! ( @$user->activated!='1' ? 'checked' : '' ) !!}>
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
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="user_right" disabled {!! ( @$user->user_right=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.1'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-info  css-radio">
                                <input type="radio" class="css-control-input" value="5" name="user_right" disabled {!! ( @$user->user_right=='5' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.5'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="9" name="user_right" disabled {!! ( @$user->user_right=='9' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.9'))}}
                            </label>
                        </div>
                    </div>
                @endif
                @if($arrShowField['isChangePassword']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="is_chang_password">{{ucfirst(__('users.is_chang_password.label'))}}
                            @if(__('users.is_chang_password.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.is_chang_password.popover.title')) ,'content'=> ucfirst(__('users.is_chang_password.popover.content'))])
                            @endif
                        </label>
                        <div class="col-12">
                            <label class="css-control css-control-lg css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" name="isChangPassword" value="1" disabled @if(@$user->isChangePassword == 1) checked @endif >
                                    <span class="css-control-indicator"></span> {{ucfirst(__('users.is_chang_password.text_checkbox.check'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                @if($arrShowField['remember_token']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="remember_token">{{ucfirst(__('users.remember_token.label'))}}
                        @if(__('users.remember_token.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.remember_token.popover.title')) ,'content'=> ucfirst(__('users.remember_token.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="remember_token" name="remember_token" disabled value="{{ @$user->remember_token }}" placeholde="{{__('users.remember_token.placeholder')}}">
                </div>
                @endif  
                <hr>
                @if($arrShowField['created_uid']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="created_uid"> {{ucfirst(__('users.created_uid.label'))}}
                        @if(__('users.created_uid.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.created_uid.popover.title')) ,'content'=> ucfirst(__('users.created_uid.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" disabled id="created_uid" name="created_uid" value="@if($user->created_uid){{ $user->createdBy->username}} @else {{ ucfirst(__('users.created_uid.by_register')) }}@endif">
                    </div>
                </div>
                @endif

                @if($arrShowField['created_at']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="created_at"> {{ucfirst(__('users.created_at.label'))}}
                        @if(__('users.created_at.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.created_at.popover.title')) ,'content'=> ucfirst(__('users.created_at.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time js-flatpickr-enabled flatpickr-input" disabled id="created_at" name="created_at" value="{{@$user->created_at}}">
                    </div>
                </div>
                @endif

                @if($arrShowField['updated_uid']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="updated_uid"> {{ucfirst(__('users.updated_uid.label'))}}
                        @if(__('users.updated_uid.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.updated_uid.popover.title')) ,'content'=> ucfirst(__('users.updated_uid.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" disabled id="updated_uid" name="updated_uid" value="{{@$user->updatedBy->username}}">
                    </div>
                </div>
                @endif

                @if($arrShowField['updated_at']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="updated_at"> {{ucfirst(__('users.updated_at.label'))}}
                        @if(__('users.updated_at.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.updated_at.popover.title')) ,'content'=> ucfirst(__('users.updated_at.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time js-flatpickr-enabled flatpickr-input" disabled id="updated_at" name="updated_at" value="@if($user->updated_uid) @$user->updated_at @endif">
                    </div>
                </div>
                @endif
                
                @if($arrShowField['last_login']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="last_login"> {{ucfirst(__('users.last_login.label'))}}
                        @if(__('users.last_login.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users.last_login.popover.title')) ,'content'=> ucfirst(__('users.last_login.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time js-flatpickr-enabled flatpickr-input" disabled id="last_login" name="last_login" value="{{@$user->last_login}}">
                    </div>
                </div>
                @endif
            </div>
            <hr>
                <div class="row mb-3">
                    <div class="col">
                        @include('components._btn_back')
                    </div>
                </div>
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

@endsection



<!--
/** 
 * CRUD Laravel
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 14/12/2021 18:51
 * Version : ver.1.00.00
 *
 * File Create : 2020-09-18 17:11:34 *
 */
-->