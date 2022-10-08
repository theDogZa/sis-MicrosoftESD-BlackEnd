<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('users_permissions.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['user_id']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="user_id">{{ucfirst(__('users_permissions.user_id.label'))}}</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">{{(__('stores.placeholder_store_type'))}}</option>
                            @include('components._option_select',['data'=>$arrUser,'selected' => @$search->user_id])
                        </select>
                    </div>
                    @endif
                    @if($arrShowField['permission_id']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="permission_id">{{ucfirst(__('users_permissions.permission_id.label'))}}</label>
                        <select class="form-control" id="permission_id" name="permission_id">
                            <option value="">{{(__('stores.placeholder_store_type'))}}</option>
                            @include('components._option_select',['data'=>$arrPermission,'selected' => @$search->permission_id])
                        </select>
                    </div>
                    @endif
                    @if($arrShowField['role_id']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="role_id">{{ucfirst(__('users_permissions.role_id.label'))}}</label>
                        <div class="input-daterange input-group">
                            <input type="number" class="form-control" id="role_id_start" name="role_id_start" value="{{@$search->role_id_start}}" placeholder="From">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="number" class="form-control" id="role_id_end" name="role_id_end" value="{{@$search->role_id_end}}" placeholder="To">
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="active">{{ucfirst(__('users_permissions.active.label'))}}</label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all" value="" name="active" {!! ( @$search->active != 'Y' && @$search->active!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('users_permissions.active.text_radio.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$search->active=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users_permissions.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$search->active=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('users_permissions.active.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            @include('components.button._submin_search')
                            @include('components.button._reset',['class'=>'btn-sm btn-reset-search'])
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>