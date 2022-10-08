<div class="overlay"></div>
<div class="col position-relative" style="z-index: 101">
    <div class="position-absolute block block-rounded block-search mr-2" id="block-search" style="display: none; margin-top: -67px !important;">
        <form action="{{url()->current()}}" method="get" class="form-search" enctype="application/x-www-form-urlencoded">
            <div class="block-header {{config('theme.layout.main_block_search_header')}}">
                <h3 class="block-title">
                    <i class="{{config('theme.icon.advanced_search')}}"></i> {{ ucfirst(__('configs.head_title.search')) }}
                </h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <div class="row">
                    @if($arrShowField['code']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="code">{{ucfirst(__('configs.code.label'))}}</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{@$search->code}}">
                    </div>
                    @endif
                    {{-- @if($arrShowField['type']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="type">{{ucfirst(__('configs.type.label'))}}</label>
                        <input type="text" class="form-control" id="type" name="type" value="{{@$search->type}}">
                    </div>
                    @endif --}}
                    @if($arrShowField['name']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="name">{{ucfirst(__('configs.name.label'))}}</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{@$search->name}}">
                    </div>
                    @endif
                    @if($arrShowField['des']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="des">{{ucfirst(__('configs.des.label'))}}</label>
                        <input type="text" class="form-control" id="des" name="des" value="{{@$search->des}}">
                    </div>
                    @endif
                    @if($arrShowField['val']==true)
                    <div class="form-group {{config('theme.layout.search')}}">
                        <label for="val">{{ucfirst(__('configs.val.label'))}}</label>
                        <input type="text" class="form-control" id="val" name="val" value="{{@$search->val}}">
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