@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> true])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_billings')}} mr-2"></i>{{ ucfirst(__('billings.heading')) }}
        <div class="bock-sub-menu">
            @permissions('create.billings')
            @include('components.button._add')
            @endpermissions
        </div>
        @if(View::exists('_billings._advanced_search'))
        @include('_billings._advanced_search')
        @endif
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('billings.head_title.list')) }}
                <small> ( {{$collection->total() }} {{ ucfirst(__('core.data_total_records')) }} ) </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <table class="table {{config('theme.layout.table_list_item')}}">
                <thead class="{{config('theme.layout.table_list_item_head')}}">
                    <tr>
                        <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                        @if($arrShowField['sold_to']==true)
                        <th class="text-center">
                            @sortablelink('sold_to',__('billings.sold_to.th'))
                        </th>
                        @endif
                        @if($arrShowField['billing_no']==true)
                        <th class="text-center">
                            @sortablelink('billing_no',__('billings.billing_no.th'))
                        </th>
                        @endif
                        @if($arrShowField['billing_item']==true)
                        <th class="text-center">
                            @sortablelink('billing_item',__('billings.billing_item.th'))
                        </th>
                        @endif
                        @if($arrShowField['billing_at']==true)
                        <th class="text-center">
                            @sortablelink('billing_at',__('billings.billing_at.th'))
                        </th>
                        @endif
                        @if($arrShowField['material_no']==true)
                        <th class="text-center">
                            @sortablelink('material_no',__('billings.material_no.th'))
                        </th>
                        @endif
                        @if($arrShowField['material_desc']==true)
                        <th class="text-center">
                            @sortablelink('material_desc',__('billings.material_desc.th'))
                        </th>
                        @endif
                        @if($arrShowField['qty']==true)
                        <th class="text-center">
                            @sortablelink('qty',__('billings.qty.th'))
                        </th>
                        @endif
                        @if($arrShowField['po_no']==true)
                        <th class="text-center">
                            @sortablelink('po_no',__('billings.po_no.th'))
                        </th>
                        @endif
                        @if($arrShowField['vendor_article']==true)
                        <th class="text-center">
                            @sortablelink('vendor_article',__('billings.vendor_article.th'))
                        </th>
                        @endif
                        @if($arrShowField['active']==true)
                        <th class="text-center">
                            @sortablelink('active',__('billings.active.th'))
                        </th>
                        @endif
                        @if($arrShowField['sale_count']==true)
                        <th class="text-center">
                            @sortablelink('sale_count',__('billings.sale_count.th'))
                        </th>
                        @endif
                        @if($arrShowField['remaining_amount']==true)
                        <th class="text-center">
                            @sortablelink('remaining_amount',__('billings.remaining_amount.th'))
                        </th>
                        
                        @endif
                        <th width="10px;" class="text-center">{{ucfirst(__('core.th_actions'))}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($collection->total())
                    @foreach ($collection as $item)
                    <tr id="row_{{$item->id}}">
                        <td>{!! $loop->iteration+(($collection->currentPage()-1)*$collection->perPage()) !!}</td>
                        @if(!empty( $arrShowField['sold_to'] ))
                        <td>
                            {!! @$item->sold_to !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['billing_no'] ))
                        <td>
                            {!! @$item->billing_no !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['billing_item'] ))
                        <td>
                            {!! @$item->billing_item !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['billing_at'] ))
                        <td>
                            {!! date_format(date_create(@$item->billing_at),config('theme.format.date')) !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['material_no'] ))
                        <td>
                            {!! @$item->material_no !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['material_desc'] ))
                        <td>
                            {!! Str::limit( @$item->material_desc,config('theme.textarea.limit'),config('theme.textarea.end_str')) !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['qty'] ))
                        <td class="text-center">
                            {!! @$item->qty !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['po_no'] ))
                        <td >
                            {!! @$item->po_no !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['vendor_article'] ))
                        <td>
                            {!! @$item->vendor_article !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['active'] ))
                        <td class="text-center">
                            @include('components._badge_radio',['val'=>@$item->active,'tTrue'=>ucfirst(__('billings.active.text_radio.true')), 'tFalse'=>ucfirst(__('billings.active.text_radio.false'))])
                        </td>
                        @endif
                        @if(!empty( $arrShowField['sale_count'] ))
                        <td class="text-center">
                            {!! @$item->sale_count !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['remaining_amount'] ))
                        <td class="text-center">
                            {!! @$item->remaining_amount !!}
                        </td>
                        @endif
                        <td class="text-center">
                            <div class="btn-group">
                                @permissions('read.billings')
                                @include('components.button._view')
                                @endpermissions
                                @permissions('update.billings')
                                @include('components.button._edit')
                                @endpermissions
                                @permissions('del.billings')
                                @include('components.button._del')
                                @endpermissions
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="14" class="text-center">{{ ucfirst(__('core.no_records')) }}</td>
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
@include('components._form_del',['action'=> 'billings'])
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
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 06/04/2018 13:51
 * Version : ver.1.00.00
 *
 * File Create : 2021-12-29 17:59:13 *
 */
-->