@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb')
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_users_permissions')}} mr-2"></i>{{ ucfirst(__('users_permissions.heading')) }}
        <small class="ml-2"><i>"{{$user->username}}"</i></small>
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('users_permissions.head_title.list_permissions',['role'=>''])) }}
                <small>  </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}   
                <table class="table {{config('theme.layout.table_list_item')}}">
                    <thead class="{{config('theme.layout.table_list_item_head')}}">
                        <tr>
                            <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                            <th>
                                {{__('users_permissions.roles_name.th')}}
                            </th>
                            <th>
                            {{__('users_permissions.roles_group_code.th')}}
                            </th>
                            <th>
                            {{__('users_permissions.permissions_name.th')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $role_name = "";
                        $old_role_name = "";
                    @endphp
                    @foreach ($collection as $key => $items)             
                    @php
                        if($old_role_name != $items->role->name){
                            $old_role_name = $items->role->name;
                            $role_name = $items->role->name;
                        }else{
                            $role_name = "";
                        }
                    @endphp
                    <tr id="row_{{$loop->iteration}}">  
                        <td> {!! $loop->iteration !!}</td>
                        <td>
                            {!! $role_name !!}
                        </td>
                        <td>{!! $permissionsGroup[$items->permission->group_code]['name'] !!}</td>
                        <td>{!! $items->permission->name !!}</td>
                    </tr> 
                    @endforeach
                    </tbody>
                </table>
                <hr>
                <div class="row mb-3">
                    <div class="col">
                        @include('components._btn_back')    
                    </div>
                </div>
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

<script>
   
  
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
 * File Create : 2020-09-22 16:55:35 *
 */
-->