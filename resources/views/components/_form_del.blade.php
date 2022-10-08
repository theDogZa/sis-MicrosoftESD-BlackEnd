<form action="{{url(request()->route()->getPrefix().$action)}}" method="post" id="form_del" enctype="application/x-www-form-urlencoded"
data-confirm-title = "{{ucfirst(__('core.del_confirm_title'))}}" 
data-confirm-type = "{{__('core.del_confirm_type')}}"
data-confirm-message = "{{ucfirst(__('core.del_confirm_message'))}}" 
data-confirm-btn = "{{__('core.del_confirm_btn')}}"
>
    <input type="hidden" name="_method"  value="DELETE" >
    {{ csrf_field() }}
</form>

