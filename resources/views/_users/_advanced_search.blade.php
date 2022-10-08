<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('users.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['username']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="username">{{ucfirst(__('users.username.label'))}}</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{@$search->username}}">
                    </div>
                    @endif
                    @if($arrShowField['first_name']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="first_name">{{ucfirst(__('users.first_name.label'))}}</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{@$search->first_name}}">
                    </div>
                    @endif
                    @if($arrShowField['last_name']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="last_name">{{ucfirst(__('users.last_name.label'))}}</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{@$search->last_name}}">
                    </div>
                    @endif
                    @if($arrShowField['email']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="email">{{ucfirst(__('users.email.label'))}}</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{@$search->email}}">
                    </div>
                    @endif
                    @if($arrShowField['email_verified_at']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="email_verified_at">{{ucfirst(__('users.email_verified_at.label'))}}</label>
                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input" id="email_verified_at_start" name="email_verified_at_start" value="{{@$search->email_verified_at_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input" id="email_verified_at_end" name="email_verified_at_end" value="{{@$search->email_verified_at_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>    
                    </div>
                    @endif
                    @if($arrShowField['password']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="password">{{ucfirst(__('users.password.label'))}}</label>
                        <input type="text" class="form-control" id="password" name="password" value="{{@$search->password}}">
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="active">{{ucfirst(__('users.active.label'))}}</label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all_active" value="" name="active" {!! ( @$search->active != 'Y' && @$search->active!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.active.text_radio.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$search->active=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$search->active=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.active.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['activated']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="activated">{{ucfirst(__('users.activated.label'))}}</label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all_activated" value="" name="activated" {!! ( @$search->activated                                != 'Y' && @$search->activated!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.activated.text_radio.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="activated" {!! ( @$search->activated=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.activated.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="0" name="activated" {!! ( @$search->activated=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.activated.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['user_right']==true)
                    <div class="{{config('theme.layout.form')}}">
                        <label for="user_right">{{ucfirst(__('users.user_right.label'))}}
                            <span class="text-danger">*</span>
                            @if(__('users.user_right.popover.title') != "")
                            @include('components._popover_info', ['title' => ucfirst(__('users.user_right.popover.title')) ,'content'=> ucfirst(__('users.user_right.popover.content'))])
                            @endif
                        </label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all_user_right" value="" name="user_right" {!! ( @$search->user_right                                != 'Y' && @$search->activated!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="user_right" {!! ( @$search->user_right=='1' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.1'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-info  css-radio">
                                <input type="radio" class="css-control-input" value="5" name="user_right" {!! ( @$search->user_right=='5' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.5'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="9" name="user_right" {!! ( @$search->user_right=='9' ? 'checked' : '' ) !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('users.user_right.text_right.9'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['remember_token']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="remember_token">{{ucfirst(__('users.remember_token.label'))}}</label>
                        <input type="text" class="form-control" id="remember_token" name="remember_token" value="{{@$search->remember_token}}">
                    </div>
                    @endif
                    @if($arrShowField['last_login']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="last_login">{{ucfirst(__('users.last_login.label'))}}</label>
                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input" id="last_login_start" name="last_login_start" value="{{@$search->last_login_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input" id="last_login_end" name="last_login_end" value="{{@$search->last_login_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
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