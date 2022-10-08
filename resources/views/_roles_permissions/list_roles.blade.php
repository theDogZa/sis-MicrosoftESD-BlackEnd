@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb')
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_roles_permissions')}} mr-2"></i>{{ ucfirst(__('roles_permissions.heading')) }}
        <small class="ml-2"><i>"{{$role->name}}"</i></small>
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('roles_permissions.head_title.list_roles',['role'=>$role->name])) }}
                <small>  </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
        <form action="{{ route('rolesPermission.storeRoles') }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
            {{ csrf_field() }}   
                @foreach ($collection as $key => $items)
                @if($permissionsGuoup[$key]['active'] == true)
                    <div class="row m-1 mt-4 form-group border rounded" style="margin-bottom: 40px !important;">    
                            @if($permissionsGuoup[$key]['type'] == "checkbox")
                                <div class="col-12 p-3">
                                    <h4 style="margin-top:-30px;">
                                        <span class="pl-4 pr-4 bg-white">{{ucfirst($permissionsGuoup[$key]['name'])}}</span>
                                    </h4>
                                </div>
                                @foreach ($items as $item)
                                <div class="col-3 mb-4">
                                    <label class="css-control css-control-lg css-control-primary css-checkbox">
                                    <input type="checkbox" class="css-control-input" name="permissions[]" value="{{$item->id}}" 
                                    {{ isset($rolesPermission[$item->id])? 'checked' : '' }} 
                                    >
                                        <span class="css-control-indicator"></span> {{$item->name}}
                                    </label>
                                </div>
                                @endforeach
                            @endif
                    </div>
                @endif
                @endforeach
                <hr>
                <div class="row mb-3">
                    <div class="col">
                        @include('components._btn_back')
                        @include('components._btn_submit_form')
                        @include('components._btn_reset_form')
                    </div>
                </div>
                <input type="hidden" name="role_id" value="{{$role_id}}">
            </form>
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
 * File Create : 2020-09-22 16:55:35 *
 */
-->