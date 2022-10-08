@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_billings')}} mr-2"></i>{{ ucfirst(__('billings.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('billings.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['sold_to']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="sold_to">{{ucfirst(__('billings.sold_to.label'))}}
                        @if(__('billings.sold_to.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.sold_to.popover.title')) ,'content'=> ucfirst(__('billings.sold_to.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="sold_to" name="sold_to" disabled value="{{ @$billing->sold_to }}" placeholde="{{__('billings.sold_to.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['billing_no']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="billing_no">{{ucfirst(__('billings.billing_no.label'))}}
                        @if(__('billings.billing_no.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.billing_no.popover.title')) ,'content'=> ucfirst(__('billings.billing_no.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="billing_no" name="billing_no" disabled value="{{ @$billing->billing_no }}" placeholde="{{__('billings.billing_no.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['billing_item']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="billing_item">{{ucfirst(__('billings.billing_item.label'))}}
                        @if(__('billings.billing_item.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.billing_item.popover.title')) ,'content'=> ucfirst(__('billings.billing_item.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="billing_item" name="billing_item" disabled value="{{ @$billing->billing_item }}" placeholde="{{__('billings.billing_item.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['billing_at']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="billing_at">{{ucfirst(__('billings.billing_at.label'))}}
                        @if(__('billings.billing_at.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.billing_at.popover.title')) ,'content'=> ucfirst(__('billings.billing_at.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-date  js-flatpickr-enabled flatpickr-input" disabled id="billing_at" name="billing_at" value="{{@$billing->billing_at}}">
                    </div>
                </div>
                @endif
                @if($arrShowField['material_no']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="material_no">{{ucfirst(__('billings.material_no.label'))}}
                        @if(__('billings.material_no.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.material_no.popover.title')) ,'content'=> ucfirst(__('billings.material_no.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="material_no" name="material_no" disabled value="{{ @$billing->material_no }}" placeholde="{{__('billings.material_no.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['material_desc']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="material_desc">{{ucfirst(__('billings.material_desc.label'))}}
                        @if(__('billings.material_desc.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.material_desc.popover.title')) ,'content'=> ucfirst(__('billings.material_desc.popover.content'))])
                        @endif
                    </label>
                    <textarea class="form-control" id="material_desc" name="material_desc" rows="3" disabled placeholde="{{__('billings.material_desc.placeholder')}}">{{@$billing->material_desc}}</textarea>
                </div>
                @endif
                @if($arrShowField['qty']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="qty">{{ucfirst(__('billings.qty.label'))}}
                        @if(__('billings.qty.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.qty.popover.title')) ,'content'=> ucfirst(__('billings.qty.popover.content'))])
                        @endif
                    </label>
                    <input type="number" class="form-control" id="qty" name="qty" disabled value="{{@$billing->qty}}" placeholde="{{__('billings.qty.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['po_no']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="po_no">{{ucfirst(__('billings.po_no.label'))}}
                        @if(__('billings.po_no.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.po_no.popover.title')) ,'content'=> ucfirst(__('billings.po_no.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="po_no" name="po_no" disabled value="{{ @$billing->po_no }}" placeholde="{{__('billings.po_no.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['vendor_article']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="vendor_article">{{ucfirst(__('billings.vendor_article.label'))}}
                        @if(__('billings.vendor_article.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.vendor_article.popover.title')) ,'content'=> ucfirst(__('billings.vendor_article.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="vendor_article" name="vendor_article" disabled value="{{ @$billing->vendor_article }}" placeholde="{{__('billings.vendor_article.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['sale_count']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="sale_count">{{ucfirst(__('billings.sale_count.label'))}}
                        @if(__('billings.sale_count.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.sale_count.popover.title')) ,'content'=> ucfirst(__('billings.sale_count.popover.content'))])
                        @endif
                    </label>
                    <input type="number" class="form-control" id="sale_count" name="sale_count" disabled value="{{@$billing->sale_count}}" placeholde="{{__('billings.sale_count.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['remaining_amount']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="remaining_amount">{{ucfirst(__('billings.remaining_amount.label'))}}
                        @if(__('billings.remaining_amount.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.remaining_amount.popover.title')) ,'content'=> ucfirst(__('billings.remaining_amount.popover.content'))])
                        @endif
                    </label>
                    <input type="number" class="form-control" id="remaining_amount" name="remaining_amount" disabled value="{{@$billing->remaining_amount}}" placeholde="{{__('billings.remaining_amount.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['active']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="active">{{ucfirst(__('billings.active.label'))}}
                        @if(__('billings.active.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('billings.active.popover.title')) ,'content'=> ucfirst(__('billings.active.popover.content'))])
                        @endif
                    </label>
                    <div>
                        <label class="css-control css-control-lg css-control-success css-radio">
                            <input type="radio" class="css-control-input" value="1" name="active" disabled {!! ( @$billing->active=='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('billings.active.text_radio.true'))}}
                        </label>
                        <label class="css-control css-control-lg css-control-danger css-radio">
                            <input type="radio" class="css-control-input" value="0" name="active" disabled {!! ( @$billing->active!='1' ? 'checked' : '' ) !!}>
                            <span class="css-control-indicator"></span> {{ucfirst(__('billings.active.text_radio.false'))}}
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
 * File Create : 2021-12-29 17:59:13 *
 */
-->