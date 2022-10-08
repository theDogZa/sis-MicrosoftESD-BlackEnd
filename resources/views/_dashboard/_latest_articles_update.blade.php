<div class="block block-rounded block-bordered">
    <div class="block-header block-header-default border-b bg-primary-light">
        <h3 class="block-title">Latest Articles Update <small> (10 Record)</small> </h3>
        <div class="block-options"></div>
    </div>
    <div class="block-content">
        <table class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th>Articles</th>
                    <th class="text-right">STOCK</th>
                    <th class="text-center">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                <tr>
                    <td>
                        <a class="font-w600" href="{{route('articles.show',$article->id)}}">{{$article->article_no}}</a>
                    </td>
                    <td class="text-right">
                        <span class="text-black"> {{ number_format($article->stock) }} </span>
                    </td>
                    <td class="text-center">
                        {!! date("d-m-Y H:i:s",strtotime($article->updated_at)) !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>