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

{{-- <button type="button" 
class="btn btn-sm btn-info js-tooltip-enabled @if(isset($class)){{$class}}@endif" 
data-toggle="tooltip" 
title="View" 
data-original-title="View" 
@if(isset($id))
    id="{{ $id }}" 
@endif
@if(isset($oncilck))
    onclick="{{$oncilck}}"
@else 
    onclick="document.location = '{{url()->current()}}/{{$item->id}}'
@endif
">
<i class="fa fa-search-plus"></i>
</button> --}}

<a 
    @if(isset($url))
        href="{{$url}}"
    @else
        href= "{{url()->current()}}/{{$item->id}}"
    @endif
    @if(isset($id))
        id="{{ $id }}"
    @endif
    @if(isset($oncilck))
        onclick="{{$oncilck}}"
    @endif
    class="btn btn-sm btn-info js-tooltip-enabled @if(isset($class)){{$class}}@endif"
    role="button">
    <i class="fa fa-search-plus"></i> @if(isset($text)){{$text}} @endif
</a>