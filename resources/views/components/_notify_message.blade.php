@section('js_after_noit')
@if(Session::has('noit_message'))
<script>

  var title = "{{ ucfirst(Session::get('noit_status')) }}";
  var type = "{{ Session::get('noit_status') }}";
  var message = "{{ ucfirst(Session::get('noit_message'))}}";

  noitMessage(title,type,message);
  
</script>
@php
Session::forget('noit_message');
Session::forget('noit_status');
@endphp
@endif
@endsection

