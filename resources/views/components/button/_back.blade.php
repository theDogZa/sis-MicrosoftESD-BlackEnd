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
<a 
    @if(isset($url))
        href="{{$url}}"
    @endif
    @if(isset($id))
        id="{{ $id }}" 
    @endif
    @if(isset($oncilck))
        onclick="{{$oncilck}}"
    @endif
    @if(isset($style))
        style=" {{$style}} " 
    @endif
    class="btn btn-secondary min-width-125 bg-dark text-white @if(isset($class)){{$class}}@endif" 
    role="button">
    <i class="si si-action-undo"></i> {{ $text }}
</a>