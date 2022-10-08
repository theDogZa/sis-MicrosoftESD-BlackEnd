<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('examples.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['parent_id']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="parent_id">{{ucfirst(__('examples.parent_id.label'))}}</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">{{(__('stores.placeholder_store_type'))}}</option>
                            @include('components._option_select',['data'=>$arrParent,'selected' => @$search->parent_id])
                        </select>
                    </div>
                    @endif
                    @if($arrShowField['users_id']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="users_id">{{ucfirst(__('examples.users_id.label'))}}</label>
                        <select class="form-control" id="users_id" name="users_id">
                            <option value="">{{(__('stores.placeholder_store_type'))}}</option>
                            @include('components._option_select',['data'=>$arrUsers,'selected' => @$search->users_id])
                        </select>
                    </div>
                    @endif
                    @if($arrShowField['title']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="title">{{ucfirst(__('examples.title.label'))}}</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{@$search->title}}">
                    </div>
                    @endif
                    @if($arrShowField['body']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="body">{{ucfirst(__('examples.body.label'))}}</label>
                        <input type="text" class="form-control" id="body" name="body" value="{{@$search->body}}">
                    </div>
                    @endif
                    @if($arrShowField['amount']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="amount">{{ucfirst(__('examples.amount.label'))}}</label>
                        <div class="input-daterange input-group">
                            <input type="number" class="form-control" id="amount_start" name="amount_start" value="{{@$search->amount_start}}" placeholder="From">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="number" class="form-control" id="amount_end" name="amount_end" value="{{@$search->amount_end}}" placeholder="To">
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['date']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="date">{{ucfirst(__('examples.date.label'))}}</label>
                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-date bg-white js-flatpickr-enabled flatpickr-input" id="date_start" name="date_start" value="{{@$search->date_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control input-date bg-white js-flatpickr-enabled flatpickr-input" id="date_end" name="date_end" value="{{@$search->date_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['time']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="time">{{ucfirst(__('examples.time.label'))}}</label>
                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input" id="time_start" name="time_start" value="{{@$search->time_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control input-time bg-white js-flatpickr-enabled flatpickr-input" id="time_end" name="time_end" value="{{@$search->time_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>    
                    </div>
                    @endif
                    @if($arrShowField['datetime']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="datetime">{{ucfirst(__('examples.datetime.label'))}}</label>
                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control input-datetime bg-white js-flatpickr-enabled flatpickr-input" id="datetime_start" name="datetime_start" value="{{@$search->datetime_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control input-datetime bg-white js-flatpickr-enabled flatpickr-input" id="datetime_end" name="datetime_end" value="{{@$search->datetime_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['status']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="status">{{ucfirst(__('examples.status.label'))}}</label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all" value="" name="status" {!! ( @$search->status                                != 'Y' && @$search->status!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.status.text_radio.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="status" {!! ( @$search->status=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.status.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="0" name="status" {!! ( @$search->status=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.status.text_radio.false'))}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($arrShowField['active']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="active">{{ucfirst(__('examples.active.label'))}}</label>
                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all" value="" name="active" {!! ( @$search->active != 'Y' && @$search->active!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.active.text_radio.all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$search->active=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.active.text_radio.true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$search->active=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('examples.active.text_radio.false'))}}
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