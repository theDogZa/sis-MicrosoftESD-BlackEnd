@if($val==1)
    <span class="badge badge-success">@if($tTrue) {!!$tTrue!!}  @else {{ ucfirst(__('core.active_true')) }} @endif</span>
@else
    <span class="badge badge-danger">@if($tFalse) {!!$tFalse!!}  @else {{ ucfirst(__('core.active_false')) }} @endif</span>
@endif