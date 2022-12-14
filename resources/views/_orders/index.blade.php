@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> true])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_orders')}} mr-2"></i>{{ ucfirst(__('orders.heading')) }}
        <div class="bock-sub-menu">
            @permissions('create.orders')
            @include('components.button._add')
            @endpermissions
            @include('components.button._export',['searchStr'=>$searchStr, 'type' => 'xls','text'=>ucfirst(__('core.button_export_xls'))])
            @include('components.button._export',['searchStr'=>$searchStr, 'type' => 'csv','text'=>ucfirst(__('core.button_export_csv'))])
        </div>
        @if(View::exists('_orders._advanced_search'))
        @include('_orders._advanced_search')
        @endif
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('orders.head_title.list')) }}
                <small> ( {{$collection->total() }} {{ ucfirst(__('core.data_total_records')) }} ) </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <table class="table {{config('theme.layout.table_list_item')}}">
                <thead class="{{config('theme.layout.table_list_item_head')}}">
                    <tr>
                        <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                        @if($arrShowField['customer_name']==true)
                        <th class="text-center">
                            @sortablelink('customer_name',__('orders.customer_name.th'))
                        </th>
                        @endif
                        @if($arrShowField['email']==true)
                        <th class="text-center">
                            @sortablelink('email',__('orders.email.th'))
                        </th>
                        @endif
                        @if($arrShowField['tel']==true)
                        <th class="text-center">
                            @sortablelink('tel',__('orders.tel.th'))
                        </th>
                        @endif
                        @if($arrShowField['path_no']==true)
                        <th class="text-center">
                            @sortablelink('path_no',__('orders.path_no.th'))
                        </th>
                        @endif
                        @if($arrShowField['serial']==true)
                        <th>
                            @sortablelink('serial',__('inventory.serial.th'))
                        </th>
                        @endif
                        @if($arrShowField['receipt_no']==true)
                        <th class="text-center">
                            @sortablelink('receipt_no',__('orders.receipt_no.th'))
                        </th>
                        @endif
                        @if($arrShowField['sale_uid']==true)
                        <th class="text-center">
                            @sortablelink('sale_uid',__('orders.sale_uid.th'))
                        </th>
                        @endif
                        
                        @if($arrShowField['sale_at']==true)
                        <th class="text-center">
                            @sortablelink('sale_at',__('orders.sale_at.th'))
                        </th>
                        @endif
                        <th class="text-center">
                            @sortablelink('sold_to',__('billings.sold_to.th'))
                        </th>
                        <th width="10px;" class="text-center">{{ucfirst(__('core.th_actions'))}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($collection->total())
                    @foreach ($collection as $item)
                    <tr id="row_{{$item->id}}">
                        <td>{!! $loop->iteration+(($collection->currentPage()-1)*$collection->perPage()) !!}</td>
                        @if(!empty( $arrShowField['customer_name'] ))
                        <td>
                            {!! @$item->customer_name !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['email'] ))
                        <td>
                            {!! @$item->email !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['tel'] ))
                        <td>
                            {!! @$item->tel !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['path_no'] ))
                        <td>
                            {!! @$item->path_no !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['serial'] ))
                        <td>
                        {!! @$item->OrderItem->Inventory->serial !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['receipt_no'] ))
                        <td>
                            {!! @$item->receipt_no !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['sale_uid'] ))
                        <td>
                            {!! @$item->Sale_uid->username !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['sale_at'] ))
                        <td>
                            {!! date_format(date_create(@$item->sale_at),config('theme.format.datetime')) !!}
                        </td>
                        <td>
                            {!! @$item->OrderItem->Inventory->Billing->sold_to !!}
                        </td>
                        @endif
                        <td class="text-center">
                            <div class="btn-group">
                                @permissions('read.orders')
                                @include('components.button._view')
                                @endpermissions
                                @permissions('update.orders')
                                @include('components.button._edit')
                                @endpermissions
                                @permissions('del.orders')
                                @include('components.button._del')
                                @endpermissions
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="11" class="text-center">{{ ucfirst(__('core.no_records')) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <!-- END Content Data -->
            @include('components._pagination', ['data' => $collection])
        </div>
    </div>
    <!-- END Content Main -->
</div>
<!-- END Page Content -->
@include('components._form_del',['action'=> 'orders'])
@include('components._notify_message')
@endsection

@section('css_after')
<link rel="stylesheet" id="css-flatpickr" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection
@section('js_after')
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script>
    $(function($) {
        $(".input-datetime").flatpickr({
            allowInput: true,
            enableTime: true,
            time_24hr: true,
            altInputClass: 'flatpickr-alt',
            // minTime: "16:00",
            // maxTime: "22:30",
            onReady: function(dateObj, dateStr, instance) {
                $('.flatpickr-calendar').each(function() {
                    var $this = $(this);
                    if ($this.find('.flatpickr-clear').length < 1) {
                        $this.append('<div class="flatpickr-clear btn btn-sm btn-rounded btn-warning min-width-125 mb-10">Clear</div>');
                        $this.find('.flatpickr-clear').on('click', function() {
                            instance.clear();
                            instance.close();
                        });
                    }
                });
            }
        });
        $('.input-datetime').keypress(function() {
            return false;
        });
        $(".input-date").flatpickr({
            allowInput: true,
            altInputClass: 'flatpickr-alt',
            // altFormat: "F j, Y",
            // dateFormat: "Y-m-d",
            // minDate: "today",
            //maxDate: new Date().fp_incr(14) // 14 days from now
            onReady: function(dateObj, dateStr, instance) {
                $('.flatpickr-calendar').each(function() {
                    var $this = $(this);
                    if ($this.find('.flatpickr-clear').length < 1) {
                        $this.append('<div class="flatpickr-clear btn btn-sm btn-rounded btn-warning min-width-125 mb-10">Clear</div>');
                        $this.find('.flatpickr-clear').on('click', function() {
                            instance.clear();
                            instance.close();
                        });
                    }
                });
            }
        });
        $('.input-date').keypress(function() {
            return false;
        });
        $(".input-time").flatpickr({
            allowInput: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            altInputClass: 'flatpickr-alt',
            // minTime: "16:00",
            // maxTime: "22:30",
            onReady: function(dateObj, dateStr, instance) {
                $('.flatpickr-calendar').each(function() {
                    var $this = $(this);
                    if ($this.find('.flatpickr-clear').length < 1) {
                        $this.append('<div class="flatpickr-clear btn btn-sm btn-rounded btn-warning min-width-125 mb-10">Clear</div>');
                        $this.find('.flatpickr-clear').on('click', function() {
                            instance.clear();
                            instance.close();
                        });
                    }
                });
            }
        });
        $('.input-time').keypress(function() {
            return false;
        });
    });
</script>
@endsection
<!--
/** 
 * CRUD Laravel
 * Master ???BY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 06/04/2018 13:51
 * Version : ver.1.00.00
 *
 * File Create : 2022-01-05 11:35:12 *
 */
-->