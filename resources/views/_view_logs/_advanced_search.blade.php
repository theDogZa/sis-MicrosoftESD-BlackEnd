<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('roles.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['app']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="app">{{ucfirst(__('view_logs.syslogs.app.label'))}}</label>
                        <select class="form-control" id="app" name="app">
                            <option value="">All</option>
                            @include('components._option_select',['data'=>$arrApp,'selected' => @$search->app])
                        </select>
                    </div>
                    @endif

                    @if($arrShowField['date']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="date">{{ucfirst(__('view_logs.syslogs.date.label'))}}</label>
                        <div class="input-date input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-datetime bg-white js-flatpickr-enabled flatpickr-input" id="date" name="date" value="{{@$sDate}}" placeholder="" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                    </div>
                    @endif

                    @if($arrShowField['ip']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="ip">{{ucfirst(__('view_logs.syslogs.ip.label'))}}</label>
                        <input type="text" class="form-control" id="ip" name="ip" value="{{@$search->ip}}">
                    </div>
                    @endif

                    @if($arrShowField['username']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="username">{{ucfirst(__('view_logs.syslogs.username.label'))}}</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{@$search->username}}">
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