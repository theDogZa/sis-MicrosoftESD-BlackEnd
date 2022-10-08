@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_users_roles')}} mr-2"></i>{{ ucfirst(__('users_roles.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('users_roles.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['user_id']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="user_id">{{ucfirst(__('users_roles.user_id.label'))}}
                        @if(__('users_roles.user_id.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users_roles.user_id.popover.title')) ,'content'=> ucfirst(__('users_roles.user_id.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="user_id" name="user_id" disabled value="{{ @$arrUser[$users_role->user_id] }}" placeholde="{{__('users_roles.user_id.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['role_id']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="role_id">{{ucfirst(__('users_roles.role_id.label'))}}
                        @if(__('users_roles.role_id.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users_roles.role_id.popover.title')) ,'content'=> ucfirst(__('users_roles.role_id.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="role_id" name="role_id" disabled value="{{ @$arrRole[$users_role->role_id] }}" placeholde="{{__('users_roles.role_id.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['active']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="active">{{ucfirst(__('users_roles.active.label'))}}
                        @if(__('users_roles.active.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('users_roles.active.popover.title')) ,'content'=> ucfirst(__('users_roles.active.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="active" disabled {!! ( @$users_role->active=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('users_roles.active.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger css-radio">
                            <input type="radio" class="css-control-input" value="0" name="active" disabled {!! ( @$users_role->active!='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('users_roles.active.text_radio.false'))}}
                        </label>
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
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 18/09/2020 10:51
 * Version : ver.1.00.00
 *
 * File Create : 2020-09-23 17:24:28 *
 */
-->