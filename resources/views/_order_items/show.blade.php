@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_order_items')}} mr-2"></i>{{ ucfirst(__('order_items.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('order_items.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['order_id']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="order_id">{{ucfirst(__('order_items.order_id.label'))}}
                        @if(__('order_items.order_id.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('order_items.order_id.popover.title')) ,'content'=> ucfirst(__('order_items.order_id.popover.content'))])
                        @endif
                    </label>
                    <input type="number" class="form-control" id="order_id" name="order_id" disabled value="{{@$orderitem->order_id}}" placeholde="{{__('order_items.order_id.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['inventory_id']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="inventory_id">{{ucfirst(__('order_items.inventory_id.label'))}}
                        @if(__('order_items.inventory_id.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('order_items.inventory_id.popover.title')) ,'content'=> ucfirst(__('order_items.inventory_id.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="inventory_id" name="inventory_id" disabled value="{{ @$arrInventory[$orderitem->inventory_id] }}" placeholde="{{__('order_items.inventory_id.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['license_key']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="license_key">{{ucfirst(__('order_items.license_key.label'))}}
                        @if(__('order_items.license_key.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('order_items.license_key.popover.title')) ,'content'=> ucfirst(__('order_items.license_key.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="license_key" name="license_key" disabled value="{{ @$orderitem->license_key }}" placeholde="{{__('order_items.license_key.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['license_at']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="license_at">{{ucfirst(__('order_items.license_at.label'))}}
                        @if(__('order_items.license_at.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('order_items.license_at.popover.title')) ,'content'=> ucfirst(__('order_items.license_at.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-datetime  js-flatpickr-enabled flatpickr-input" disabled id="license_at" name="license_at" value="{{@$orderitem->license_at}}">
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
 * File Create : 2022-01-05 12:25:55 *
 */
-->