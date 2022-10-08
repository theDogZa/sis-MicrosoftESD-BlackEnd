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


<button type="submit" class="btn btn-sm btn-alt-primary @if(isset($class)){{$class}}@endif"

>
    <i class="fa fa-check"></i> @if(isset($text)){{$text}} @else {{ ucfirst(__('core.button_submit_search')) }} @endif
</button>