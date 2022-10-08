@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> true])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_config')}} mr-2"></i>{{ ucfirst(__('view_logs.heading')) }}
        <div class="bock-sub-menu"></div>
        @if(View::exists('_view_logs._advanced_search'))
        @include('_view_logs._advanced_search')
        @endif
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('view_logs.head_title.list')) }}
                <small> ( {{$total}} {{ ucfirst(__('core.data_total_records')) }} ) </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <table class="table {{config('theme.layout.table_list_item')}}">
                <thead class="{{config('theme.layout.table_list_item_head')}}">
                    <tr>
                        <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                        <th>App</th>
                        @if($arrShowField['date']==true)
                        <th>
                            {{__('view_logs.syslogs.date.th')}}
                        </th>
                        @endif
                        @if($arrShowField['ip']==true)
                        <th>
                            {{__('view_logs.syslogs.ip.th')}}
                        </th>
                        @endif
                        @if($arrShowField['username']==true)
                        <th>
                            {{__('view_logs.syslogs.username.th')}}
                        </th>
                        @endif
                        @if($arrShowField['action']==true )
                        <th>
                            {{__('view_logs.syslogs.action.th')}}
                        </th>
                        @endif
                        @if($arrShowField['uri']==true)
                        <th>
                            {{__('view_logs.syslogs.uri.th')}}
                        </th>
                        @endif
                        @if($arrShowField['response_code']==true)
                        <th>
                            {{__('view_logs.syslogs.response_code.th')}}
                        </th>
                        @endif
                        @if($arrShowField['detial']==true)
                        <th>
                            {{__('view_logs.syslogs.detial.th')}}
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($collection)
                    @foreach ($collection as $item)
                    <tr id="row_{{$loop->iteration}}">
                        <td>{!! $loop->iteration !!}</td>
                        <td>{!! @$item->app !!}</td>
                        @if(!empty( $arrShowField['date'] ))
                        <td>
                            {!! @$item->date !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['ip'] ))
                        <td>
                            {!! @$item->ip !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['username'] ))
                        <td>
                            {!! @$item->username !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['action'] ))
                        <td>
                            @php
                            $arrAction = explode(".",@$item->action);
                            @endphp
                            @if(isset($mapMenu[$arrAction[0]]))
                                {!! ucfirst(@$mapMenu[$arrAction[0]]) !!}
                            @else
                                {!! ucfirst($arrAction[0]) !!}
                            @endif
                            @if(@$arrAction[0])
                            @endif
                            @if(isset($arrAction[1]))
                                @if(isset($mapAction[$arrAction[1]]))
                                    {!! @$mapAction[$arrAction[1]] !!}
                                @else
                                    {!! ucfirst($arrAction[1]) !!}
                                @endif
                            @else
                                {!!  ucfirst(@$item->action) !!}
                            @endif
                        </td>
                        @endif

                        @if(!empty( $arrShowField['uri'] ))
                        <td>
                            @if(isset($item->url))
                            {!! @$item->url !!}
                            @else
                            {!! @$item->uri !!}
                            @endif
                        </td>
                        @endif
                        
                        @if(!empty( $arrShowField['response_code'] ))
                        <td>
                            {!! @$item->response_code !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['detial'] ))
                        <td class="p-2">
                            @if((@$item->data || @$item->request) && @$item->url != 'login')  
                            @include('components.modal._detial_log', ['action' => @$item->action,'id' => $loop->iteration, 'data' => @$item->response, 'request' => @$item->request])
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10" class="text-center">{{ ucfirst(__('core.no_records')) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <!-- END Content Data -->
            <div class="d-none" id="list-date-log"><span class="pt-2">Date :</span> 
                <select name="search" class="form-control ml-2" onchange="this.form.submit()">
                    @foreach ($selectDate as $sd)
                        <option value="{{$sd}}" @if($sd==$sDate) selected @endif>{{$sd}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <!-- END Content Main -->
</div>
<!-- END Page Content -->
@include('components._notify_message')
@endsection

@section('css_after')
<link rel="stylesheet" id="css-flatpickr" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection
@section('js_after')
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script>
    $(function($) {
        $('#form-easy-search #block-input').html($('#list-date-log').html())
    });
    var strDate = [{!! $strDate !!}];
    console.log(strDate);
     $(".input-datetime").flatpickr({
            allowInput: true,
            enableTime: false,
            time_24hr: false,
            altInputClass: 'flatpickr-alt',
            enable: strDate,

            onReady: function(dateObj, dateStr, instance) {
                $('.flatpickr-calendar').each(function() {
                    var $this = $(this);
                    if ($this.find('.flatpickr-ok').length < 1) {
                        $this.append('<div class="flatpickr-ok btn btn-sm btn-rounded btn-success min-width-125 mb-10">OK</div>');
                        $this.find('.flatpickr-ok').on('click', function() {
                            instance.close();
                        }); 
                    }
                });
            }
        });
        $('.input-datetime').keypress(function() {
            return false;
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