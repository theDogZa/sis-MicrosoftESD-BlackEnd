<label class="css-control css-control-lg css-control-danger css-radio @if(isset($class)){{$class}}@endif">
    <input type="radio" class="css-control-input"
        value="@if(isset($value)){{$value}}"@endif
        name="@if(isset($name)){{$name}}"@endif
        @if(isset($checked)) checked @endif
    >
    <span class="css-control-indicator"></span> 
    {{ucfirst(__('core.form_active_false'))}}
    @if(isset($text)){{$text}} @endif
</label>
