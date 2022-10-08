<!--
    color
        btn-primary, btn-outline-primary, btn-alt-primary : color blue   ***** change color on chang theme
        btn-secondary, btn-outline-secondary, btn-alt-secondary : color gray
        btn-success, btn-outline-success, btn-alt-success : color green
        btn-info, btn-outline-info, btn-alt-info : color light blue
        btn-warning, btn-outline-warning, btn-alt-warning : color orange
        btn-danger, btn-outline-danger, btn-alt-danger : color red
    size
        btn-sm
        btn
        btn-lg
        btn-hero btn-sm
        btn-hero
        btn-hero btn-lg
-->

<button type="button" 
class="btn btn-sm  btn-del js-tooltip-enabled
 @if(isset($class)){{$class}}@endif 
 @if(@$item->isUse) btn-alt-secondary @else btn-danger @endif" 
data-toggle="tooltip" 
title="Delete" 
data-original-title="Delete"
@if(isset($id))
    id="{{ $id }}" 
@endif
@if(isset($oncilck))
    onclick="{{$oncilck}}"
@endif

@if(@$item->isUse) 
    disabled
@else 
    data-id-del={{$item->id}}
@endif

>
<i class="fa fa-times"></i>
</button>

