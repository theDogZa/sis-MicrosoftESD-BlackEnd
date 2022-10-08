@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_examples')}} mr-2"></i>{{ ucfirst(__('examples.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('examples.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['parent_id']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="parent_id">{{ucfirst(__('examples.parent_id.label'))}}
                        @if(__('examples.parent_id.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.parent_id.popover.title')) ,'content'=> ucfirst(__('examples.parent_id.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="parent_id" name="parent_id" disabled value="{{ @$arrParent[$example->parent_id] }}" placeholde="{{__('examples.parent_id.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['users_id']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="users_id">{{ucfirst(__('examples.users_id.label'))}}
                        @if(__('examples.users_id.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.users_id.popover.title')) ,'content'=> ucfirst(__('examples.users_id.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="users_id" name="users_id" disabled value="{{ @$arrUsers[$example->users_id] }}" placeholde="{{__('examples.users_id.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['title']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="title">{{ucfirst(__('examples.title.label'))}}
                        @if(__('examples.title.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.title.popover.title')) ,'content'=> ucfirst(__('examples.title.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="title" name="title" disabled value="{{ @$example->title }}" placeholde="{{__('examples.title.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['body']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="body">{{ucfirst(__('examples.body.label'))}}
                        @if(__('examples.body.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.body.popover.title')) ,'content'=> ucfirst(__('examples.body.popover.content'))])
                        @endif
                    </label>
                    <textarea class="form-control" id="body" name="body" rows="3" disabled placeholde="{{__('examples.body.placeholder')}}">{{@$example->body}}</textarea>
                </div>
                @endif
                @if($arrShowField['amount']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="amount">{{ucfirst(__('examples.amount.label'))}}
                        @if(__('examples.amount.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.amount.popover.title')) ,'content'=> ucfirst(__('examples.amount.popover.content'))])
                        @endif
                    </label>
                    <input type="number" class="form-control" id="amount" name="amount" disabled value="{{@$example->amount}}" placeholde="{{__('examples.amount.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['date']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="date">{{ucfirst(__('examples.date.label'))}}
                        @if(__('examples.date.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.date.popover.title')) ,'content'=> ucfirst(__('examples.date.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-date  js-flatpickr-enabled flatpickr-input" disabled id="date" name="date" value="{{@$example->date}}">
                    </div>
                </div>
                @endif
                @if($arrShowField['time']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="time">{{ucfirst(__('examples.time.label'))}}
                        @if(__('examples.time.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.time.popover.title')) ,'content'=> ucfirst(__('examples.time.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time  js-flatpickr-enabled flatpickr-input" disabled id="time" name="time" value="{{@$example->time}}">
                    </div>
                </div>
                @endif
                @if($arrShowField['datetime']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="datetime">{{ucfirst(__('examples.datetime.label'))}}
                        @if(__('examples.datetime.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.datetime.popover.title')) ,'content'=> ucfirst(__('examples.datetime.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-datetime  js-flatpickr-enabled flatpickr-input" disabled id="datetime" name="datetime" value="{{@$example->datetime}}">
                    </div>
                </div>
                @endif
                @if($arrShowField['status']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="status">{{ucfirst(__('examples.status.label'))}}
                        @if(__('examples.status.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.status.popover.title')) ,'content'=> ucfirst(__('examples.status.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="status" disabled {!! ( @$example->status=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('examples.status.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger  css-radio">
                            <input type="radio" class="css-control-input" value="0" name="status" disabled {!! ( @$example->status!='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('examples.status.text_radio.false'))}}
                        </label>
                    </div>
                </div>
                @endif
                @if($arrShowField['active']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="active">{{ucfirst(__('examples.active.label'))}}
                        @if(__('examples.active.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('examples.active.popover.title')) ,'content'=> ucfirst(__('examples.active.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="active" disabled {!! ( @$example->active=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('examples.active.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger css-radio">
                            <input type="radio" class="css-control-input" value="0" name="active" disabled {!! ( @$example->active!='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('examples.active.text_radio.false'))}}
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
 * File Create : 2020-09-18 17:10:04 *
 */
-->