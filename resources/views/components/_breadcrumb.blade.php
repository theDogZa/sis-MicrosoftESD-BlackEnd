@php

    $prefix = '';
    $controller ='';
    $action='';
    $formAction = "";
    if(Route::getCurrentRoute()->getAction()['prefix'] != '/')
    {
        $prefix = Route::getCurrentRoute()->getAction()['prefix'];
        $prefix = str_replace("/","",$prefix);

    }
    if(Route::currentRouteName()){
        list($controller, $action) = explode('.', Route::currentRouteName());
    }

    if(@$isSearch != true){ 
        $isSearch = false;    
    }else{
        $formAction = route(Route::currentRouteName());
        $viewAdv = '_'.$controller.'._advanced_search';
    }
    
@endphp
<nav class="breadcrumb push bg-white pr-0">
    <div class="row w-100 m-0">
        <div class="col-7 pt-2">
            <a class="breadcrumb-item" href="{{$prefix}}/dashboard">{{ ucfirst(__('core.breadcrumd_home')) }} </a>
            @if( __($controller.'.controllername') != "")
            <a class="breadcrumb-item " href="{{$prefix}}/{{$controller}}">  {{ (__($controller.'.controllername')) }} </a>
            @endif
            @if(@$name)
            <a class="breadcrumb-item active" href="{{$prefix}}/{{$controller}}"> {{ $name }}</a>
            @else 
            <a class="breadcrumb-item active" href="{{$prefix}}/{{$controller}}"> {{ (__($controller.'.'.$action)) }}</a>
            @endif
        </div>
        <div class="col-5 pr-2 float-right">
        @if(@$isSearch == true)
        <form class="push mb-0" id="form-easy-search" action="{{$formAction}}" method="get">
            <div class="row">
                <div class="col pr-0 m-0">
                    <div class="input-group input-group" id="block-input">
                        <input type="text" class="form-control" name="search" placeholder="Search .." value="{{ @$search->search }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary btn-easy-search">
                                <i class="{{config('theme.icon.search')}}"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-auto pl-0 m-0" style="z-index: 102">
                    @if(View::exists($viewAdv))
                    @include('components.button._search',['class'=>'btn-adv-search'])
                    @endif
                </div>
            </div>
        </form>
        @endif
        </div>
    </div>
</nav>
