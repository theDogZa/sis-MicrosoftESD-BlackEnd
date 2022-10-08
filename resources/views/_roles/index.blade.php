@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> true])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_roles')}} mr-2"></i>{{ ucfirst(__('roles.heading')) }}
        <div class="bock-sub-menu">
            @permissions('create.roles')
            @include('components.button._add')
            @endpermissions
        </div>
        @if(View::exists('_roles._advanced_search'))
        @include('_roles._advanced_search')
        @endif
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('roles.head_title.list')) }}
                <small> ( {{$collection->total() }} {{ ucfirst(__('core.data_total_records')) }} ) </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <table class="table {{config('theme.layout.table_list_item')}}">
                <thead class="{{config('theme.layout.table_list_item_head')}}">
                    <tr>
                        <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                        @if($arrShowField['slug']==true)
                        <th>
                            @sortablelink('slug',__('roles.slug.th'))
                        </th>
                        @endif
                        @if($arrShowField['name']==true)
                        <th>
                            @sortablelink('name',__('roles.name.th'))
                        </th>
                        @endif
                        @if($arrShowField['description']==true)
                        <th>
                            @sortablelink('description',__('roles.description.th'))
                        </th>
                        @endif
                        @if($arrShowField['active']==true)
                        <th class="text-center">
                            @sortablelink('active',__('roles.active.th'))
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
                        @if(!empty( $arrShowField['slug'] ))
                        <td>
                            {!! @$item->slug !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['name'] ))
                        <td>
                            {!! @$item->name !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['description'] ))
                        <td>
                            {!! @$item->description !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['active'] ))
                        <td class="text-center">
                            @include('components._badge_radio',['val'=>@$item->active,'tTrue'=>ucfirst(__('roles.active.text_radio.true')), 'tFalse'=>ucfirst(__('roles.active.text_radio.false'))])
                        </td>
                        @endif
                        <td class="text-center">
                            <div class="btn-group">
                                @permissions('read.roles')
                                @include('components.button._view')
                                @endpermissions
                                @permissions('update.roles')
                                @include('components.button._edit')
                                @endpermissions
                                @permissions('permission.roles')
                                <button type="button" class="btn btn-sm btn-outline-success js-tooltip-enabled " 
                                data-toggle="tooltip" title="Role Permissions" data-original-title="Role Permissions" 
                                onclick="document.location = '{{ route('roles.update_permissions_roles',['id' => $item->id]) }}'
                                ">
                                <i class="fa fa-lock"></i>
                                </button>
                                @endpermissions
                                @permissions('users.roles')
                                <button type="button" class="btn btn-sm btn-outline-primary js-tooltip-enabled " 
                                data-toggle="tooltip" title="Role Users" data-original-title="Role Users" 
                                onclick="document.location = '{{ route('roles.update_user_roles',['id' => $item->id]) }}'
                                ">
                                <i class="fa fa-user"></i>
                                </button>
                                @endpermissions
                                @permissions('del.roles')
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
@include('components._form_del',['action'=> 'roles'])
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
 * File Create : 2020-09-22 15:47:51 *
 */
-->