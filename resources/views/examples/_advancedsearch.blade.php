<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -33px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="fa fa-search-plus"></i> {{ ucfirst(__('examples.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="parent_id">{{ucfirst(__('examples.parent_id.label'))}}</label>
                                                <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">{{(__('stores.placeholder_store_type'))}}</option>
                        </select>
                                                                                                                                                                                                                                            </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="users_id">{{ucfirst(__('examples.users_id.label'))}}</label>
                                                <select class="form-control" id="users_id" name="users_id">
                            <option value="">{{(__('stores.placeholder_store_type'))}}</option>
                        </select>
                                                                                                                                                                                                                                            </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="title">{{ucfirst(__('examples.title.label'))}}</label>
                                                                        <input type="text" class="form-control" id="title" name="title" value="{{@$search->title}}">
                                                                                                                                                                                                                    </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="body">{{ucfirst(__('examples.body.label'))}}</label>
                                                                                                <input type="text" class="form-control" id="body" name="body" value="{{@$search->body}}">
                                                                                                                                                                                            </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="amount">{{ucfirst(__('examples.amount.label'))}}</label>
                                                                                                                                                                                                                                                                    </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="date">{{ucfirst(__('examples.date.label'))}}</label>
                                                                                                                                                                        <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control" id="date_start" name="date_start" value="{{@$search->date_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control" id="date_end" name="date_end" value="{{@$search->date_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                                                                                                                    </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="time">{{ucfirst(__('examples.time.label'))}}</label>
                                                                                                                                                                                                <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control" id="time_start" name="time_start" value="{{@$search->time_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control" id="time_end" name="time_end" value="{{@$search->time_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                                                                                            </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="datetime">{{ucfirst(__('examples.datetime.label'))}}</label>
                                                                                                                                                <div class="input-daterange input-group js-datepicker-enabled" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control" id="datetime_start" name="datetime_start" value="{{@$search->datetime_start}}" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text font-w600">to</span>
                            </div>
                            <input type="text" class="form-control" id="datetime_end" name="datetime_end" value="{{@$search->datetime_end}}" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                                                                                                                                            </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="status">{{ucfirst(__('examples.status.label'))}}</label>
                                                                                                                                                                                                                        <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all" value="" name="status" {!! ( @$search->status                                != 'Y' && @$search->status!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('core.form_active_all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="status" {!! ( @$search->status=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('core.form_active_true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="0" name="status" {!! ( @$search->status=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('core.form_active_false'))}}
                            </label>
                        </div>
                                                                    </div>
                                        <div class="form-group {{config('theme.layout.search')}}">
                        <label for="active">{{ucfirst(__('examples.active.label'))}}</label>
                                                                                                                                                                                                                                                <div>
                            <label class="css-control css-control-lg css-control-primary css-radio">
                                <input type="radio" class="css-control-input chk_radio_all" id="chk_radio_all" value="" name="active" {!! ( @$search->active                                != 'Y' && @$search->active!='N' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('core.form_active_all'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-success css-radio">
                                <input type="radio" class="css-control-input" value="1" name="active" {!! ( @$search->active=='1' ? 'checked' : '') !!}>
                                <span class="css-control-indicator"></span> {{ucfirst(__('core.form_active_true'))}}
                            </label>
                            <label class="css-control css-control-lg css-control-danger  css-radio">
                                <input type="radio" class="css-control-input" value="0" name="active" {!! ( @$search->active=='0' ? 'checked' : '') !!} >
                                <span class="css-control-indicator"></span> {{ucfirst(__('core.form_active_false'))}}
                            </label>
                        </div>
                                            </div>
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