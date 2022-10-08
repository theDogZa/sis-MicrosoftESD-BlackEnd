@extends('layouts.backend')
@section('content')
    <!-- Page Content -->
    <div class="content">
        @include('components._breadcrumb')
        <!-- Content Heading -->
        <h2 class="content-heading pt-2">
            <i class="{{config('theme.icon.menu_users')}} mr-2"></i>{{ ucfirst(__('users.heading')) }} 
            <div class="bock-sub-menu">
                @permissions('create.users')
                    @include('components.button._add')
                @endpermissions
                @if(View::exists('_users._search'))
                @include('components.button._search')
                @endif
            </div>
            @if(View::exists('_users._search'))
                @include('_users._search')
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
                            <th>@sortablelink('username',ucfirst(__('users.username.th')))</th>
                            <th width="10px;" class="text-center">{{ucfirst(__('core.th_actions'))}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($collection->total())
                        <tr id="row_{{$item->id}}">
                            <td>{!! $loop->iteration+(($collection->currentPage()-1)*$collection->perPage()) !!}</td>
                            <td>{{$item->username}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    @permissions('read.users')
                                    @include('components.button._view')
                                    @endpermissions
                                    @permissions('update.users')
                                    @include('components.button._edit')
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
@endsection