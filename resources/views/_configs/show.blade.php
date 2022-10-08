@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_configs')}} mr-2"></i>{{ ucfirst(__('configs.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('configs.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['code']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="code">{{ucfirst(__('configs.code.label'))}}
                        @if(__('configs.code.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('configs.code.popover.title')) ,'content'=> ucfirst(__('configs.code.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="code" name="code" disabled value="{{ @$config->code }}" placeholde="{{__('configs.code.placeholder')}}">
                </div>
                @endif
                {{-- @if($arrShowField['type']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="type">{{ucfirst(__('configs.type.label'))}}
                        @if(__('configs.type.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('configs.type.popover.title')) ,'content'=> ucfirst(__('configs.type.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="type" name="type" disabled value="{{ @$config->type }}" placeholde="{{__('configs.type.placeholder')}}">
                </div>
                @endif --}}
                
                @if($arrShowField['name']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="name">{{ucfirst(__('configs.name.label'))}}
                        @if(__('configs.name.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('configs.name.popover.title')) ,'content'=> ucfirst(__('configs.name.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="name" name="name" disabled value="{{ @$config->name }}" placeholde="{{__('configs.name.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['des']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="des">{{ucfirst(__('configs.des.label'))}}
                        @if(__('configs.des.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('configs.des.popover.title')) ,'content'=> ucfirst(__('configs.des.popover.content'))])
                        @endif
                    </label>
                    <textarea class="form-control" id="des" name="des" rows="3" disabled placeholde="{{__('configs.des.placeholder')}}">{{@$config->des}}</textarea>
                </div>
                @endif
                @if($arrShowField['val']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="val">{{ucfirst(__('configs.val.label'))}}
                        @if(__('configs.val.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('configs.val.popover.title')) ,'content'=> ucfirst(__('configs.val.popover.content'))])
                        @endif
                    </label>
                    <input @if($config->type!='PASSWORD') type="text" @else type="password" @endif class="form-control" id="val" name="val" disabled value="{{ @$config->val }}" placeholde="{{__('configs.val.placeholder')}}">
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
 * File Create : 2022-01-19 19:14:35 *
 */
-->