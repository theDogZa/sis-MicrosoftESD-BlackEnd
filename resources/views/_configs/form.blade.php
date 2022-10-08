@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_configs')}} mr-2"></i>{{ ucfirst(__('configs.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                @if(!isset($config))
                {{ ucfirst(__('configs.head_title.add')) }}
                @else
                {{ ucfirst(__('configs.head_title.edit')) }}
                @endif
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ url('/configs'.( isset($config) ? '/' . $config->id : '')) }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                @if(isset($config))
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="row form-group">
                    @if($arrShowField['code']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="code">{{ucfirst(__('configs.code.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('configs.code.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('configs.code.popover.title')) ,'content'=> ucfirst(__('configs.code.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="code" name="code" required  value="{{ @$code }}" placeholde="{{__('configs.code.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('configs.code.label')) ])
                    </div>
                    @endif
                    {{-- @if($arrShowField['type']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="type">{{ucfirst(__('configs.type.label'))}}
                            @if(__('configs.type.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('configs.type.popover.title')) ,'content'=> ucfirst(__('configs.type.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="type" name="type"   value="{{ @$type }}" placeholde="{{__('configs.type.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('configs.type.label')) ])
                    </div>
                    @endif --}}
                    
                    @if($arrShowField['name']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="name">{{ucfirst(__('configs.name.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('configs.name.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('configs.name.popover.title')) ,'content'=> ucfirst(__('configs.name.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="name" name="name" required  value="{{ @$name }}" placeholde="{{__('configs.name.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('configs.name.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['des']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="des">{{ucfirst(__('configs.des.label'))}}
                            @if(__('configs.des.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('configs.des.popover.title')) ,'content'=> ucfirst(__('configs.des.popover.content'))])
                            @endif
                        </label>
                        <textarea class="form-control" id="des" name="des" rows="3"   placeholde="{{__('configs.des.placeholder')}}">{{@$des}}</textarea>
                        @include('components._invalid_feedback',['required'=>'','message'=>ucfirst(__('configs.des.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['val']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="val">{{ucfirst(__('configs.val.label'))}}
                            @if(@$is_request) <span class="text-danger">*</span> @endif
                            @if(__('configs.val.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('configs.val.popover.title')) ,'content'=> ucfirst(__('configs.val.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="val" name="val" @if(@$is_request) required @endif value="{{ @$val }}" placeholde="{{__('configs.val.placeholder')}}">
                        @php if(@$is_request) $required = 'required';  @endphp
                        @include('components._invalid_feedback',['required'=>$required ,'message'=>ucfirst(__('configs.val.label')) ])
                    </div>
                    @endif
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col">
                        @include('components._btn_back')
                        @include('components._btn_submit_form')
                        @include('components._btn_reset_form')
                    </div>
                </div>
            </form>
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

<script>

    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();

    $(function($) {

        $('.input-clear').click(function() {
            $(this).closest('.input-group').find('input').val("");     
        });
        $('.input-toggle').click(function() {
            var idInput = '#'+$(this).closest('.input-group').find('input').attr('id');    
            const calendar = document.querySelector(idInput)._flatpickr;
            calendar.toggle();
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
 * File Create : 2022-01-19 19:14:35 *
 */
-->