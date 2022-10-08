<table class="table table-striped">
    <thead class="">
      <tr>
        @foreach ($collection->thead as $item)
            <th>{{$item}}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
            <td>{{$item->}}</td>
        @endforeach
    </tbody>
</table>