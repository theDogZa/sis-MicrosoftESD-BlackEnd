<button type="submit" class="btn btn-primary min-width-125 js-click-ripple-enabled" data-toggle="click-ripple" 
style="overflow: hidden; position: relative; z-index: 1;"
 @if(isset($id)) id="{{ $id }}" @endif
 >
    @if(isset($icon))<i class="{{$icon}} mr-2"></i>@else<i class="fa fa-save mr-2"></i>@endif
     @if(@$text){{$text}} @else {{ ucfirst(__('core.button_save')) }} @endif
</button>

