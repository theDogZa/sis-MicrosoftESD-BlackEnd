@extends('layouts.backend')
@section('content')
    <!-- Page Content -->
    <div class="content">
        @include('components._breadcrumb')
        <!-- Content Heading -->
        <h2 class="content-heading pt-2">
            <i class="{{config('theme.icon.menu_users')}} mr-2"></i>{{ ucfirst(__('users.heading')) }} 
        </h2>
        <!-- END Content Heading -->

        <!-- Content Main -->
        <div class="block {{config('theme.layout.main_block')}}">
            <div class="block-header {{config('theme.layout.main_block_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.item_add')}} mr-2"></i>
                    {{ ucfirst(__('users.head_title.view')) }} 
                </h3>
            </div>
            <div class="block-content">
                <!-- ** Content Data ** -->

                <!-- END Content Data -->  
            </div>
        </div>
        <!-- END Content Main -->   
    </div>
    <!-- END Page Content -->
@endsection