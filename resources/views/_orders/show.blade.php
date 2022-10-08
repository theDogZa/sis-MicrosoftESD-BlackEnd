@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_orders')}} mr-2"></i>{{ ucfirst(__('orders.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('orders.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="row form-group">
                @if($arrShowField['customer_name']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="customer_name">{{ucfirst(__('orders.customer_name.label'))}}
                        @if(__('orders.customer_name.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('orders.customer_name.popover.title')) ,'content'=> ucfirst(__('orders.customer_name.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" disabled value="{{ @$order->customer_name }}" placeholde="{{__('orders.customer_name.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['email']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="email">{{ucfirst(__('orders.email.label'))}}
                        @if(__('orders.email.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('orders.email.popover.title')) ,'content'=> ucfirst(__('orders.email.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="email" name="email" disabled value="{{ @$order->email }}" placeholde="{{__('orders.email.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['tel']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="tel">{{ucfirst(__('orders.tel.label'))}}
                        @if(__('orders.tel.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('orders.tel.popover.title')) ,'content'=> ucfirst(__('orders.tel.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="tel" name="tel" disabled value="{{ @$order->tel }}" placeholde="{{__('orders.tel.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['path_no']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="path_no">{{ucfirst(__('orders.path_no.label'))}}
                        @if(__('orders.path_no.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('orders.path_no.popover.title')) ,'content'=> ucfirst(__('orders.path_no.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="path_no" name="path_no" disabled value="{{ @$order->path_no }}" placeholde="{{__('orders.path_no.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['receipt_no']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="receipt_no">{{ucfirst(__('orders.receipt_no.label'))}}
                        @if(__('orders.receipt_no.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('orders.receipt_no.popover.title')) ,'content'=> ucfirst(__('orders.receipt_no.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="receipt_no" name="receipt_no" disabled value="{{ @$order->receipt_no }}" placeholde="{{__('orders.receipt_no.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['sale_uid']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="sale_uid">{{ucfirst(__('orders.sale_uid.label'))}}
                        @if(__('orders.sale_uid.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('orders.sale_uid.popover.title')) ,'content'=> ucfirst(__('orders.sale_uid.popover.content'))])
                        @endif
                    </label>
                    <input type="text" class="form-control" id="sale_uid" name="sale_uid" disabled value="{{ @$arrSaleu[$order->sale_uid] }}" placeholde="{{__('orders.sale_uid.placeholder')}}">
                </div>
                @endif
                @if($arrShowField['sale_at']==true)
                <div class="{{config('theme.layout.view')}}">
                    <label for="sale_at">{{ucfirst(__('orders.sale_at.label'))}}
                        @if(__('orders.sale_at.popover.title') != "")
                        @include('components._popover_info', ['title' => ucfirst(__('orders.sale_at.popover.title')) ,'content'=> ucfirst(__('orders.sale_at.popover.content'))])
                        @endif
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control input-datetime  js-flatpickr-enabled flatpickr-input" disabled id="sale_at" name="sale_at" value="{{@$order->sale_at}}">
                    </div>
                </div>
                @endif
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col block-content">
                    <table class="table {{config('theme.layout.table_list_item')}}">
                        <thead class="{{config('theme.layout.table_list_item_head')}}">
                            <tr>
                                <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                                <th>{{ucfirst(__('billings.sold_to.th'))}}</th>
                                <th>
                                    {{ucfirst(__('inventory.serial.th'))}}
                                </th>
                                <th>
                                    {{ucfirst(__('order_items.license_key.th'))}}
                                </th>
                                <th class="text-center">
                                    {{ucfirst(__('order_items.license_at.th'))}}
                                </th>
                                <th class="text-center">
                                    {{ucfirst(__('order_items.count_resend.th'))}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($orderItems))
                        @foreach ($orderItems as $item)
                        <tr id="row_{{$item->id}}">
                            <td></td>
                            <td>
                                {!! @$item->Inventory->Billing->sold_to !!}
                            </td>
                            <td>
                                {!! @$item->Inventory->serial !!}
                            </td>
                            <td>
                                {!! @$item->license_key !!}
                            </td>
                            <td class="text-center">
                                {!! date_format(date_create(@$item->license_at),config('theme.format.datetime')) !!}
                            </td>   
                            <td class="text-center">
                                {!! @$item->count_resend !!}
                            </td>                    
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center">{{ ucfirst(__('core.no_records')) }}</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
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
 * File Create : 2022-01-05 11:35:12 *
 */
-->