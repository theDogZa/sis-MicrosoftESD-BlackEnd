@extends('layouts.backend')
@section('content')
<!-- Page Content -->
<div class="container-fluid">
    @include('components._breadcrumb',['isSearch'=> false])
    <!-- Content Heading -->
    <h2 class="content-heading pt-2">
        <i class="{{config('theme.icon.menu_orders')}} mr-2"></i>{{ ucfirst(__('orders.heading')) }}
        <div class="bock-sub-menu"></div>
    </h2>
    <!-- END Content Heading -->

    <!-- Content Main -->
    <div class="block {{config('theme.layout.main_block')}}">
        <div class="block-header {{config('theme.layout.main_block_header')}}">
            <h3 class="block-title">
                <i class="{{config('theme.icon.item_form')}} mr-2"></i>
                @if(!isset($order))
                {{ ucfirst(__('orders.head_title.add')) }}
                @else
                {{ ucfirst(__('orders.head_title.edit')) }}
                @endif
                <small> </small>
            </h3>
        </div>

        <div class="block-content">
            <!-- ** Content Data ** -->
            <form action="{{ url('/orders'.( isset($order) ? '/' . $order->id : '')) }}" method="POST" class="needs-validation" enctype="application/x-www-form-urlencoded" id="form" novalidate>
                {{ csrf_field() }}
                @if(isset($order))
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="orderId" value="{{@$order->id}}">
                @endif
                <div class="row form-group">
                    @if($arrShowField['customer_name']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="customer_name">{{ucfirst(__('orders.customer_name.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('orders.customer_name.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('orders.customer_name.popover.title')) ,'content'=> ucfirst(__('orders.customer_name.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required  value="{{ @$customer_name }}" placeholde="{{__('orders.customer_name.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('orders.customer_name.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['email']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="email">{{ucfirst(__('orders.email.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('orders.email.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('orders.email.popover.title')) ,'content'=> ucfirst(__('orders.email.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="email" name="email" required  value="{{ @$email }}" placeholde="{{__('orders.email.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('orders.email.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['tel']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="tel">{{ucfirst(__('orders.tel.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('orders.tel.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('orders.tel.popover.title')) ,'content'=> ucfirst(__('orders.tel.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="tel" name="tel" required  value="{{ @$tel }}" placeholde="{{__('orders.tel.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('orders.tel.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['path_no']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="path_no">{{ucfirst(__('orders.path_no.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('orders.path_no.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('orders.path_no.popover.title')) ,'content'=> ucfirst(__('orders.path_no.popover.content'))])
                            @endif
                        </label>
                        <input type="text" readonly class="form-control" id="path_no" name="path_no" required  value="{{ @$path_no }}" placeholde="{{__('orders.path_no.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('orders.path_no.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['receipt_no']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="receipt_no">{{ucfirst(__('orders.receipt_no.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('orders.receipt_no.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('orders.receipt_no.popover.title')) ,'content'=> ucfirst(__('orders.receipt_no.popover.content'))])
                            @endif
                        </label>
                        <input type="text" class="form-control" id="receipt_no" name="receipt_no" required  value="{{ @$receipt_no }}" placeholde="{{__('orders.receipt_no.placeholder')}}">
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('orders.receipt_no.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['sale_uid']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="sale_uid">{{ucfirst(__('orders.sale_uid.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('orders.sale_uid.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('orders.sale_uid.popover.title')) ,'content'=> ucfirst(__('orders.sale_uid.popover.content'))])
                            @endif
                        </label>
                        <select class="form-control" id="sale_uid" name="sale_uid" required >
                            <option value="">select</option>
                            @include('components._option_select',['data'=>$arrSaleu,'selected' => @$sale_uid])
                        </select>
                        @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('orders.sale_uid.label')) ])
                    </div>
                    @endif
                    @if($arrShowField['sale_at']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="sale_at">{{ucfirst(__('orders.sale_at.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('orders.sale_at.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('orders.sale_at.popover.title')) ,'content'=> ucfirst(__('orders.sale_at.popover.content'))])
                            @endif
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control input-datetime bg-white js-flatpickr-enabled flatpickr-input" required  id="sale_at" name="sale_at" value="{{@$sale_at}}" data-default-date="{{@$sale_at}}">
                            <div class="input-group-append">
                                <span class="input-group-text input-toggle" title="toggle">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <span class="input-group-text input-clear" title="clear">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>
                            @include('components._invalid_feedback',['required'=>'required','message'=>ucfirst(__('orders.sale_at.label')) ])
                        </div>
                    </div>
                    @endif
                </div>
                <hr>
                <div class="row mb-3">
                    @permissions('resend.license')
                    <div class="col-12">
                        <button type="button" id="btn-re-sent-license" class="btn btn-success min-width-125 js-click-ripple-enabled float-right mr-2" data-toggle="click-ripple" style="overflow: hidden; position: relative; z-index: 1;">
                        <i class="fa fa-paper-plane mr-2"></i>Re Send License </button>
                    </div>
                    @endpermissions
                <div class="col-12 block-content">               
                    <table class="table {{config('theme.layout.table_list_item')}}">
                        <thead class="{{config('theme.layout.table_list_item_head')}}">
                            <tr>
                                <th>{{ucfirst(__('core.th_iteration_number'))}}</th>
                                <th>{{ucfirst(__('billings.sold_to.th'))}}</th>
                                <th>
                                    {{ucfirst(__('inventory.serial.th'))}}
                                </th>
                                <th>
                                    {{ucfirst(__('order_items.license_key.th'))}}
                                </th>
                                <th class="text-center">
                                    {{ucfirst(__('order_items.license_at.th'))}}
                                </th>
                                <th class="text-center">
                                    {{ucfirst(__('order_items.count_resend.th'))}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($orderItems))
                        @foreach ($orderItems as $item)
                        <tr id="row_{{$item->id}}">
                            <td></td>
                            <td>
                                {!! @$item->Inventory->Billing->sold_to !!}
                            </td>
                            <td>
                                {!! @$item->Inventory->serial !!}
                            </td>
                            <td>
                                {!! @$item->license_key !!}
                            </td>
                            <td class="text-center">
                                {!! date_format(date_create(@$item->license_at),config('theme.format.datetime')) !!}
                            </td> 
                            <td class="text-center">
                                {!! @$item->count_resend !!}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center">{{ ucfirst(__('core.no_records')) }}</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
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
<link rel="stylesheet" id="css-flatpickr" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection
@section('js_after')
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
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
        $(".input-datetime").flatpickr({
            allowInput: true,
            enableTime: true,
            time_24hr: true
            // minTime: "16:00",
            // maxTime: "22:30",
        });
        $('.input-datetime').keypress(function() {
            return false;
        });
        $(".input-date").flatpickr({
            allowInput: true,
            // altFormat: "F j, Y",
            // dateFormat: "Y-m-d",
            // minDate: "today",
            //maxDate: new Date().fp_incr(14) // 14 days from now
        });
        $('.input-date').keypress(function() {
            return false;
        });
        $(".input-time").flatpickr({
            allowInput: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
            // minTime: "16:00",
            // maxTime: "22:30",
        });
        $('.input-time').keypress(function() {
            return false;
        });

        $('.input-clear').click(function() {
            $(this).closest('.input-group').find('input').val("");     
        });
        $('.input-toggle').click(function() {
            var idInput = '#'+$(this).closest('.input-group').find('input').attr('id');    
            const calendar = document.querySelector(idInput)._flatpickr;
            calendar.toggle();
        });

        $('#btn-re-sent-license').click(async function() {
            var tel = $('#tel').val();
            var email = $('#email').val();

            var title = "{{ucfirst(__('orders.message_confirm_re_send.title'))}}"
            var message1 = "{{ucfirst(__('orders.message_confirm_re_send.message_1'))}}"
            var message2 = "{{ucfirst(__('orders.message_confirm_re_send.message_2'))}}"

            var message = message1+" <b>"+email+"</b><br> "+message2+" <b>"+tel+"</b>"

            var confirm = await confirmMessage(title,message,'question');
                if(confirm == true){
                    alertLoading();
                    var chk = await sendEmailSMS();
                    return;
                            
                }   
        });  
    });

    async function sendEmailSMS() {

        var token = $("input[name=_token]").val();
        var orderId = $('#orderId').val();
        var email = $('#email').val();
        var tel = $('#tel').val();

        var url = "{{ route('orders.resend') }}";
        res = $.post(url, { 
                '_token': token,
                'orderId': orderId,
                'email': email,
                'tel': tel
            })
            .then(function (response) {

                var obj = response

                if (obj.status.code !== 200) {
                    
                    var title = "error";
                    var type = "error";
                    var message = "{{ucfirst(__('orders.message_re_send_error'))}}"+obj.status.message;
                    noitMessage(title,type,message);
                    
                    return obj.status.message;

                } else {

                    var title = "success";
                    var type = "success";
                    var message = "{{ucfirst(__('orders.message_re_send_success'))}}";
                    noitMessage(title,type,message);

                    return obj;
                }
            })
            .catch(function (err) {
                return false;
            });
        return await res;

    }
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
 * File Create : 2022-01-05 11:35:12 *
 */
-->