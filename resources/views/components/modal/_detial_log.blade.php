
<a href="#" class="btn btn-sm btn-info js-tooltip-enabled " role="button" data-toggle="modal" data-target="#log_{{$id}}">
    <i class="fa fa-search-plus"></i>
</a>
<div class="modal fade" id="log_{{$id}}" tabindex="-1" aria-labelledby="{{$id}}" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideleft" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">{{$action}}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                    @if(!empty(@$request))
                    <h4>Request</h4>
                    <table class="table table-striped">
                        <thead class="">
                            <tr>
                                <th>#</th> 
                                <th>data</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(is_array($request) || is_object($request))
                            @foreach ($request as $k => $v)
                            <tr>
                                @if(@$k != '_token' && @$k !='_method' && @$k !='slug' && @$k !='license' && @$k !='password' && @$k != 'password_confirmation')
                                <td>{!! ucfirst($k) !!}</td>
                                @if(is_array($v) || is_object($v))
                                <td>{!! @implode(", ",$v) !!}</td>
                                @else
                                <td>{!! $v !!}</td>
                                @endif
                                @endif
                            </tr>
                            @endforeach
                        @else
                        <td>{!! $request !!}</td>
                        @endif
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button> 
            </div>
        </div>
    </div>
</div>