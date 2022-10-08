@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_roles')}} mr-2"></i>{{ ucfirst(__('roles.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                {{ ucfirst(__('roles.head_title.view')) }}
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-block js-tabs-enabled" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-static-detail">Detail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-static-permissions">Permissions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-static-users">{{ ucfirst(__('users_roles.head_title.sub')) }}</a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active show " id="btabs-static-detail" role="tabpanel">
                        <div class="row form-group">
                            @if($arrShowField['slug']==true)
                            <div class="{{config('theme.layout.view')}}">
                                <label for="slug">{{ucfirst(__('roles.slug.label'))}}
                                    @if(__('roles.slug.popover.title') != "")
                                    @include('components._popover_info', ['title' => ucfirst(__('roles.slug.popover.title')) ,'content'=> ucfirst(__('roles.slug.popover.content'))])
                                    @endif
                                </label>
                                <input type="text" class="form-control" id="slug" name="slug" disabled value="{{ @$role->slug }}" placeholde="{{__('roles.slug.placeholder')}}">
                            </div>
                            @endif
                            @if($arrShowField['name']==true)
                            <div class="{{config('theme.layout.view')}}">
                                <label for="name">{{ucfirst(__('roles.name.label'))}}
                                    @if(__('roles.name.popover.title') != "")
                                    @include('components._popover_info', ['title' => ucfirst(__('roles.name.popover.title')) ,'content'=> ucfirst(__('roles.name.popover.content'))])
                                    @endif
                                </label>
                                <input type="text" class="form-control" id="name" name="name" disabled value="{{ @$role->name }}" placeholde="{{__('roles.name.placeholder')}}">
                            </div>
                            @endif
                            @if($arrShowField['description']==true)
                            <div class="{{config('theme.layout.view')}}">
                                <label for="description">{{ucfirst(__('roles.description.label'))}}
                                    @if(__('roles.description.popover.title') != "")
                                    @include('components._popover_info', ['title' => ucfirst(__('roles.description.popover.title')) ,'content'=> ucfirst(__('roles.description.popover.content'))])
                                    @endif
                                </label>
                                <input type="text" class="form-control" id="description" name="description" disabled value="{{ @$role->description }}" placeholde="{{__('roles.description.placeholder')}}">
                            </div>
                            @endif
                            @if($arrShowField['active']==true)
                            <div class="{{config('theme.layout.view')}}">
                                <label for="active">{{ucfirst(__('roles.active.label'))}}
                                    @if(__('roles.active.popover.title') != "")
                                    @include('components._popover_info', ['title' => ucfirst(__('roles.active.popover.title')) ,'content'=> ucfirst(__('roles.active.popover.content'))])
                                    @endif
                                </label>
                                <div>
                                    <label class="css-control css-control-lg css-control-success css-radio">
                                        <input type="radio" class="css-control-input" value="1" name="active" disabled {!! ( @$role->active=='1' ? 'checked' : '' ) !!}>
                                        <span class="css-control-indicator"></span> {{ucfirst(__('roles.active.text_radio.true'))}}
                                    </label>
                                    <label class="css-control css-control-lg css-control-danger css-radio">
                                        <input type="radio" class="css-control-input" value="0" name="active" disabled {!! ( @$role->active!='1' ? 'checked' : '' ) !!}>
                                        <span class="css-control-indicator"></span> {{ucfirst(__('roles.active.text_radio.false'))}}
                                    </label>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-static-permissions" role="tabpanel">
                        @php
                            $chk = "";
                            $old_group_code = "";
                           
                        @endphp
                        @foreach ($rolesPermission as $items)         
                        @php
                            if($old_group_code != $items->group_code){
                                $old_group_code = $items->group_code;
                                $chk = true;
                            }else{
                                $chk = false;
                            }
                        @endphp
                        @if($chk && $loop->iteration != 1)
                            </div>
                        @endif
                        @if($chk)
                            <div class="row m-1 mt-4 form-group border rounded" style="margin-bottom: 40px !important;">    
                                <div class="col-12 p-3 pl-4">
                                    <h4 style="margin-top:-30px;">
                                        <span class="pl-4 pr-4 bg-white">{{ucfirst($permissionsGuoup[$items->group_code]['name'])}}</span>
                                    </h4>
                                </div>
                        @endif
                                <div class="col-3 mb-4">
                                   {{$items->name}}
                                </div>
                        @if($loop->iteration == count($rolesPermission))
                            </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="tab-pane" id="btabs-static-users" role="tabpanel">
                        <div class="row m-1 mt-4 pb-3 form-group border rounded" style="margin-bottom: 20px !important;">  
                            <div class="col-12 p-3">
                                <h4 style="margin-top:-30px;">
                                    <span class="pl-4 pr-4 bg-white">{{ ucfirst(__('users_roles.head_title.sub')) }}</span>
                                </h4>
                            </div> 
                            @foreach ($usersRole as $key => $item)
                            <div class="col-3 mb-4 pl-4 pb-4">
                                <span class="pl-2 position-absolute" style="margin-top: -10px">
                                    <b>{{$item->username}}</b><br>
                                    <small>{{$item->first_name}}&nbsp;{{$item->last_name}}</small>
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
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
 * File Create : 2020-09-22 15:47:51 *
 */
-->