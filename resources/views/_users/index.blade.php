@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> true])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_users')}} mr-2"></i>{{ ucfirst(__('users.heading')) }}
        <div class="bock-sub-menu">
            @permissions('create.users')
            @include('components.button._add')
            @endpermissions
        </div>
        @if(View::exists('_users._advanced_search'))
        @include('_users._advanced_search')
        @endif
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('users.head_title.list')) }}
                <small> ( {{$collection->total() }} {{ ucfirst(__('core.data_total_records')) }} ) </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <table class="table {{config('theme.layout.table_list_item')}}">
                <thead class="{{config('theme.layout.table_list_item_head')}}">
                    <tr>
                        <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                        @if($arrShowField['username']==true)
                        <th>
                            @sortablelink('username',__('users.username.th'))
                        </th>
                        @endif
                        @if($arrShowField['first_name']==true)
                        <th>
                            @sortablelink('first_name',__('users.first_name.th'))
                        </th>
                        @endif
                        @if($arrShowField['last_name']==true)
                        <th>
                            @sortablelink('last_name',__('users.last_name.th'))
                        </th>
                        @endif
                        @if($arrShowField['email']==true)
                        <th>
                            @sortablelink('email',__('users.email.th'))
                        </th>
                        @endif
                        @if($arrShowField['email_verified_at']==true)
                        <th class="text-center">
                            @sortablelink('email_verified_at',__('users.email_verified_at.th'))
                        </th>
                        @endif
                        @if($arrShowField['password']==true)
                        <th class="text-center">
                            @sortablelink('password',__('users.password.th'))
                        </th>
                        @endif
                        @if($arrShowField['active']==true)
                        <th class="text-center">
                            @sortablelink('active',__('users.active.th'))
                        </th>
                        @endif
                        @if($arrShowField['activated']==true)
                        <th class="text-center">
                            @sortablelink('activated',__('users.activated.th'))
                        </th>
                        @endif
                        @if($arrShowField['user_right']==true)
                        <th class="text-center">
                            @sortablelink('user_right',__('users.user_right.th'))
                        </th>
                        @endif
                        @if($arrShowField['remember_token']==true)
                        <th class="text-center">
                            @sortablelink('remember_token',__('users.remember_token.th'))
                        </th>
                        @endif
                        @if($arrShowField['last_login']==true)
                        <th class="text-center">
                            @sortablelink('last_login',__('users.last_login.th'))
                        </th>
                        @endif
                        <th width="10px;" class="text-center">{{ucfirst(__('core.th_actions'))}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($collection->total())
                    @foreach ($collection as $item) 
                    @if(@$arrIsUse[$item->id]) 
                    @php
                    $item->isUse = true; 
                    @endphp
                    @endif 
                    <tr id="row_{{$item->id}}">
                        <td>{!! $loop->iteration+(($collection->currentPage()-1)*$collection->perPage()) !!}</td>
                        @if(!empty( $arrShowField['username'] ))
                        <td>
                            {!! @$item->username !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['first_name'] ))
                        <td>
                            {!! @$item->first_name !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['last_name'] ))
                        <td>
                            {!! @$item->last_name !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['email'] ))
                        <td>
                            {!! @$item->email !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['email_verified_at'] ))
                        <td>
                            {!! date_format(date_create(@$item->email_verified_at),config('theme.format.time')) !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['password'] ))
                        <td>
                            {!! @$item->password !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['auth_code'] ))
                        <td>
                            {!! @$item->auth_code !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['active'] ))
                        <td class="text-center">
                            @include('components._badge_radio',['val'=>@$item->active,'tTrue'=>ucfirst(__('users.active.text_radio.true')), 'tFalse'=>ucfirst(__('users.active.text_radio.false'))])
                        </td>
                        @endif
                        @if(!empty( $arrShowField['activated'] ))
                        <td class="text-center">
                            @include('components._badge_radio',['val'=>@$item->activated,'tTrue'=>ucfirst(__('users.activated.text_radio.true')), 'tFalse'=>ucfirst(__('users.activated.text_radio.false'))])
                        </td>
                        @endif
                        @if(!empty( $arrShowField['user_right'] ))
                        <td class="text-center">
                            @include('components._badge_array',['val'=>@$item->user_right,'aText'=>__('users.user_right.text_right'), 'aBadge'=> []])
                        </td>
                        @endif
                        @if(!empty( $arrShowField['remember_token'] ))
                        <td>
                            {!! @$item->remember_token !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['last_login'] ))
                        <td>
                            {!! date_format(date_create(@$item->last_login),config('theme.format.time')) !!}
                        </td>
                        @endif
                        <td class="text-center">
                            <div class="btn-group">
                                @permissions('read.users')
                                @include('components.button._view')
                                @endpermissions
                                @permissions('update.users')
                                @include('components.button._edit')
                                @endpermissions
                                @permissions('permission.users')
                                <button type="button" class="btn btn-sm btn-outline-success js-tooltip-enabled " 
                                data-toggle="tooltip" title="View User Permissions" data-original-title="View User Permissions" 
                                onclick="document.location = '{{ route('users.list_permissions',['id' => $item->id]) }}'
                                ">
                                <i class="fa fa-lock"></i>
                                </button>
                                @endpermissions
                                @permissions('del.users')
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
@include('components._form_del',['action'=> 'users'])
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
 * File Create : 2020-09-18 17:11:34 *
 */
-->