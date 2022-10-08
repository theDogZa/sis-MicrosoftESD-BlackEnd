@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb')
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_config')}} mr-2"></i>{{ ucfirst(__('viewlog.heading')) }}
        <div class="bock-sub-menu">
            <form action="{{ route('logs.sysLogs') }}" method="POST">
                {{ csrf_field() }}
                <select name="date" class="form-control" onchange="this.form.submit()">
                    @foreach ($selectDate as $sd)
                        <option value="{{$sd}}" @if($sd==$sDate) selected @endif>{{$sd}}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('config.head_title.list')) }}
                <small> ( {{$total}} {{ ucfirst(__('core.data_total_records')) }} ) </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <table class="table {{config('theme.layout.table_list_item')}}">
                <thead class="{{config('theme.layout.table_list_item_head')}}">
                    <tr>
                        <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                        @if($arrShowField['date']==true)
                        <th>
                            {{__('logs.syslogs.date.th')}}
                        </th>
                        @endif
                        @if($arrShowField['ip']==true)
                        <th>
                           {{__('logs.syslogs.ip.th')}}
                        </th>
                        @endif
                        @if($arrShowField['username']==true)
                        <th>
                            {{__('logs.syslogs.username.th')}}
                        </th>
                        @endif
                        @if($arrShowField['uri']==true)
                        <th>
                            {{__('logs.syslogs.uri.th')}}
                        </th>
                        @endif
                        @if($arrShowField['methods']==true)
                        <th>
                            {{__('logs.syslogs.methods.th')}}
                        </th>
                        @endif
                        @if($arrShowField['response_code']==true)
                        <th>
                            {{__('logs.syslogs.response_code.th')}}
                        </th>
                        @endif
                       
                    </tr>
                </thead>
                <tbody>
                    @if($collection)
                    @foreach ($collection as $item)
                    <tr id="row_{{$loop->iteration}}">
                        <td>{!! $loop->iteration !!}</td>
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
                        @if(!empty( $arrShowField['uri'] ))
                        <td>
                            {!! @$item->action !!}
                        </td>
                         @endif
                         @if(!empty( $arrShowField['methods'] ))
                        <td>
                            {!! @$item->methods[0] !!}
                        </td>
                        @endif
                        @if(!empty( $arrShowField['response_code'] ))
                        <td>
                            {!! @$item->response_code !!}
                        </td>
                        @endif

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
            
        </div>
    </div>
    <!-- END Content Main -->
</div>
<!-- END Page Content -->
@include('components._notify_message')
@endsection

@section('css_after')

@endsection
@section('js_after')

<script>
    $(function($) {
        
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