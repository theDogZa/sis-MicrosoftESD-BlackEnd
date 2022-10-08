@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_permissions')}} mr-2"></i>{{ ucfirst(__('permissions.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('permissions.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['slug']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="slug">{{ucfirst(__('permissions.slug.label'))}}
                        @if(__('permissions.slug.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('permissions.slug.popover.title')) ,'content'=> ucfirst(__('permissions.slug.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="slug" name="slug" disabled value="{{ @$permission->slug }}" placeholde="{{__('permissions.slug.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['name']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="name">{{ucfirst(__('permissions.name.label'))}}
                        @if(__('permissions.name.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('permissions.name.popover.title')) ,'content'=> ucfirst(__('permissions.name.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="name" name="name" disabled value="{{ @$permission->name }}" placeholde="{{__('permissions.name.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['description']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="description">{{ucfirst(__('permissions.description.label'))}}
                        @if(__('permissions.description.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('permissions.description.popover.title')) ,'content'=> ucfirst(__('permissions.description.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="description" name="description" disabled value="{{ @$permission->description }}" placeholde="{{__('permissions.description.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['group_code']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="group_code">{{ucfirst(__('permissions.group_code.label'))}}
                        @if(__('permissions.group_code.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('permissions.group_code.popover.title')) ,'content'=> ucfirst(__('permissions.group_code.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="group_code" name="group_code" disabled value="{{ @$permission->group_code }}" placeholde="{{__('permissions.group_code.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['active']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="active">{{ucfirst(__('permissions.active.label'))}}
                        @if(__('permissions.active.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('permissions.active.popover.title')) ,'content'=> ucfirst(__('permissions.active.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="active" disabled {!! ( @$permission->active=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('permissions.active.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger css-radio">
                            <input type="radio" class="css-control-input" value="0" name="active" disabled {!! ( @$permission->active!='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('permissions.active.text_radio.false'))}}
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
 * File Create : 2020-09-23 13:57:26 *
 */
-->