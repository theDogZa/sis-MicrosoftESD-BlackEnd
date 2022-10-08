@if($isActive==1)
    <span class="badge badge-success">{{ ucfirst(__('core.active_true')) }}</span>
@else
    <span class="badge badge-danger">{{ ucfirst(__('core.active_false')) }}</span>
@endif