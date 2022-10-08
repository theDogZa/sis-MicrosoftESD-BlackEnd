@if (isset($data))
    @foreach ($data as $k => $v)
        <option value="{{$k}}" @if($selected == $k) selected @endif>{{$v}}</option>
    @endforeach
@endif