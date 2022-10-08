@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> true])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_examples')}} mr-2"></i>{{ ucfirst(__('examples.heading')) }}
        <div class="bock-sub-menu">
            @permissions('create.examples')
            @include('components.button._add')
            @endpermissions
        </div>
        @if(View::exists('_examples._advanced_search'))
        @include('_examples._advanced_search')
        @endif
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('examples.head_title.list')) }}
                <small> ( {{$collection->total() }} {{ ucfirst(__('core.data_total_records')) }} ) </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <table class="table {{config('theme.layout.table_list_item')}}">
                <thead class="{{config('theme.layout.table_list_item_head')}}">
                    <tr>
                        <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                        @if($arrShowField['parent_id']==true)
                        <th class="text-center">
                            @sortablelink('parent_id',__('examples.parent_id.th'))
                        </th>
                        @endif
                        @if($arrShowField['users_id']==true)
                        <th class="text-center">
                            @sortablelink('users_id',__('examples.users_id.th'))
                        </th>
                        @endif
                        @if($arrShowField['title']==true)
                        <th class="text-center">
                            @sortablelink('title',__('examples.title.th'))
                        </th>
                        @endif
                        @if($arrShowField['body']==true)
                        <th class="text-center">
                            @sortablelink('body',__('examples.body.th'))
                        </th>
                        @endif
                        @if($arrShowField['amount']==true)
                        <th class="text-center">
                            @sortablelink('amount',__('examples.amount.th'))
                        </th>
                        @endif
                        @if($arrShowField['date']==true)
                        <th class="text-center">
                            @sortablelink('date',__('examples.date.th'))
                        </th>
                        @endif
                        @if($arrShowField['time']==true)
                        <th class="text-center">
                            @sortablelink('time',__('examples.time.th'))
                        </th>
                        @endif
                        @if($arrShowField['datetime']==true)
                        <th class="text-center">
                            @sortablelink('datetime',__('examples.datetime.th'))
                        </th>
                        @endif
                        @if($arrShowField['status']==true)
                        <th class="text-center">
                            @sortablelink('status',__('examples.status.th'))
                        </th>
                        @endif
                        @if($arrShowField['active']==true)
                        <th class="text-center">
                            @sortablelink('active',__('examples.active.th'))
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
                        @if(!empty( $arrShowField['parent_id'] ))
                        <td>
                            {!! @$item->Example->id !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['users_id'] ))
                        <td>
                            {!! @$item->User->id !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['title'] ))
                        <td>
                            {!! @$item->title !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['body'] ))
                        <td>
                            {!! Str::limit( @$item->body,config('theme.textarea.limit'),config('theme.textarea.end_str')) !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['amount'] ))
                        <td>
                            {!! @$item->amount !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['date'] ))
                        <td>
                            {!! date_format(date_create(@$item->date),config('theme.format.date')) !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['time'] ))
                        <td>
                            {!! date_format(date_create(@$item->time),config('theme.format.time')) !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['datetime'] ))
                        <td>
                            {!! date_format(date_create(@$item->datetime),config('theme.format.datetime')) !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['status'] ))
                        <td>
                            @include('components._badge_radio',['val'=>@$item->status,'tTrue'=>ucfirst(__('examples.status.text_radio.true')), 'tFalse'=>ucfirst(__('examples.status.text_radio.false'))])
                        </td>
                        @endif
                        @if(!empty( $arrShowField['active'] ))
                        <td>
                            @include('components._badge_radio',['val'=>@$item->active,'tTrue'=>ucfirst(__('examples.active.text_radio.true')), 'tFalse'=>ucfirst(__('examples.active.text_radio.false'))])
                        </td>
                        @endif
                        <td class="text-center">
                            <div class="btn-group">
                                @permissions('read.examples')
                                @include('components.button._view')
                                @endpermissions
                                @permissions('update.examples')
                                @include('components.button._edit')
                                @endpermissions
                                @permissions('del.examples')
                                @include('components.button._del')
                                @endpermissions
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">{{ ucfirst(__('core.no_records')) }}</td>
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
@include('components._form_del',['action'=> 'examples'])
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
 * File Create : 2020-09-18 17:10:04 *
 */
-->