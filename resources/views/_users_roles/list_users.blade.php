@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb')
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_users_roles')}} mr-2"></i>{{ ucfirst(__('users_roles.heading')) }} 
        <small class="ml-2"><i>"{{$role->name}}"</i></small>
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_list')}} mr-2"></i>
                {{ ucfirst(__('users_roles.head_title.list_roles',['role'=>$role->name])) }}        
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ route('userRoles.storeRoles') }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}   
                <div class="row m-1 mt-4 form-group border rounded" style="margin-bottom: 40px !important;">  
                    <div class="col-12 p-3">
                        <h4 style="margin-top:-30px;">
                            <span class="pl-4 pr-4 bg-white">{{ ucfirst(__('users_roles.head_title.sub')) }}</span>
                        </h4>
                    </div> 
                    @foreach ($collection as $key => $item)
                    <div class="col-4 mb-4">
                        <label class="css-control css-control-lg css-control-primary css-checkbox">
                            <input type="checkbox" class="users-checkbox css-control-input" name="users[]" value="{{$item->id}}" 
                                {{ isset($usersRole[$item->id])? 'checked' : '' }} 
                            >
                            <span class="css-control-indicator  position-absolute" style="margin-top: 10px"></span>
                            <span class="pl-2" style="margin-left: 30px;">
                                <b>{{$item->username}}</b><br>
                                <small style="margin-left: 38px;">{{$item->first_name}}&nbsp;{{$item->last_name}}</small>
                            </span>
                            
                        </label>
                    </div>
                    @endforeach
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col">
                        @include('components._btn_back')
                        @include('components._btn_submit_form',['id'=>'checkUser'])
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

<script>
  var cur = [];
  $(document).ready(function(){
    $.each($("input[name='users[]']:checked"), function(){
        cur.push($(this).val());
    });
  });

  $("#checkUser").click(async function(event){
    var new_cur = [];
    $.each($("input[name='users[]']:checked"), function(){
        new_cur.push($(this).val());
    });
    event.preventDefault();
    event.stopPropagation();
    if(cur.toString() === new_cur.toString()){
        var title = "{{ ucfirst(__('users_roles.message_not_change.title')) }}"
        var message = "{{ ucfirst(__('users_roles.message_not_change.message')) }}"
        noitMessage(title,'error',message);
        return  false;
    }else{
        var title = "{{ ucfirst(__('users_roles.message_confirm_change.title')) }}"
        var message = "{{ ucfirst(__('users_roles.message_confirm_change.message')) }}"
        var con = await confirmMessage(title,message,'question');
        if(con){
            $('#form').submit();
            return;   
        }
    }
    return await false;
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
 * File Create : 2020-09-22 16:55:35 *
 */
-->