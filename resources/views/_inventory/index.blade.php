@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> true])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_inventory')}} mr-2"></i>{{ ucfirst(__('inventory.heading')) }}
        <div class="bock-sub-menu">
            @permissions('create.inventory')
            @include('components.button._add')
            @endpermissions
        </div>
        @if(View::exists('_inventory._advanced_search'))
        @include('_inventory._advanced_search')
        @endif
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('inventory.head_title.list')) }}
                <small> ( {{$collection->total() }} {{ ucfirst(__('core.data_total_records')) }} ) </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <table class="table {{config('theme.layout.table_list_item')}}">
                <thead class="{{config('theme.layout.table_list_item_head')}}">
                    <tr>
                        <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                        @if($arrShowField['billing_id']==true)
                        <th class="text-center">
                            @sortablelink('billing_id',__('inventory.billing_id.th'))
                        </th>
                        @endif
                        @if($arrShowField['serial']==true)
                        <th class="text-center">
                            @sortablelink('serial',__('inventory.serial.th'))
                        </th>
                        @endif
                        @if($arrShowField['serial_long']==true)
                        <th class="text-center">
                            @sortablelink('serial_long',__('inventory.serial_long.th'))
                        </th>
                        @endif
                        @if($arrShowField['imei']==true)
                        <th class="text-center">
                            @sortablelink('imei',__('inventory.imei.th'))
                        </th>
                        @endif
                        @if($arrShowField['material_no']==true)
                        <th class="text-center">
                            @sortablelink('material_no',__('inventory.material_no.th'))
                        </th>
                        @endif
                        @if($arrShowField['serial_raw']==true)
                        <th class="text-center">
                            @sortablelink('serial_raw',__('inventory.serial_raw.th'))
                        </th>
                        @endif
                        @if($arrShowField['active']==true)
                        <th class="text-center">
                            @sortablelink('active',__('inventory.active.th'))
                        </th>
                        @endif
                        @if($arrShowField['sale_status']==true)
                        <th class="text-center">
                            @sortablelink('sale_status',__('inventory.sale_status.th'))
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
                        @if(!empty( $arrShowField['billing_id'] ))
                        <td>
                            {!! @$item->Billing->billing_no !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['serial'] ))
                        <td>
                            {!! @$item->serial !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['serial_long'] ))
                        <td>
                            {!! @$item->serial_long !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['imei'] ))
                        <td>
                            {!! @$item->imei !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['material_no'] ))
                        <td>
                            {!! @$item->material_no !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['serial_raw'] ))
                        <td>
                            {!! @$item->serial_raw !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['active'] ))
                        <td class="text-center">
                            @include('components._badge_radio',['val'=>@$item->active,'tTrue'=>ucfirst(__('inventory.active.text_radio.true')), 'tFalse'=>ucfirst(__('inventory.active.text_radio.false'))])
                        </td>
                        @endif
                        @if(!empty( $arrShowField['sale_status'] ))
                        <td class="text-center">
                            @include('components._badge_radio',['val'=>@$item->sale_status,'tTrue'=>ucfirst(__('inventory.sale_status.text_radio.true')), 'tFalse'=>ucfirst(__('inventory.sale_status.text_radio.false'))])
                        </td>
                        @endif
                        <td class="text-center">
                            <div class="btn-group">
                                @permissions('read.inventory')
                                @include('components.button._view')
                                @endpermissions
                                @permissions('update.inventory')
                                @include('components.button._edit')
                                @endpermissions
                                @permissions('del.inventory')
                                @include('components.button._del')
                                @endpermissions
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="12" class="text-center">{{ ucfirst(__('core.no_records')) }}</td>
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
@include('components._form_del',['action'=> 'inventory'])
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
 * File Create : 2021-12-29 17:54:30 *
 */
-->