
@if($data->lastPage()>1)
<hr>
<nav aria-label="Page navigation row">
    <div class="row">
        <div class="col-4">
            <p>
                {!! __('pagination.pageof', ['currentPage' => $data->currentPage(),'lastPage' => $data->lastPage()]) !!} , 
                {!! __('pagination.showrecord', ['count' => $data->count(),'total' => $data->total()]) !!}
            </p>
        </div>
        <div class="col-8">
            <div class="pull-right">
                <ul class="pagination pagination-lg">
                    @php
                    $showItemPage = config('theme.paginator.number_limit_page');
                    if($showItemPage % 2 == 0){ 
                        $showItemPage -= 1;
                    }
                    $centerItemPage = ceil($showItemPage/2);

                    if($data->currentPage()<=$centerItemPage){
                        $sPage = 1;
                    }else{
                        $sPage = $data->currentPage()-($centerItemPage-1);
                    }

                    $MaxPage = $sPage+($showItemPage-1);

                    if($MaxPage >  $data->lastPage()){
                        $MaxPage = $data->lastPage();
                    }

                    $isQuery = "";
                    $QueryString = "";
                    $exQuery = [];

                    //---get para
                    if(Request::getQueryString()){

                        if(strpos(Request::getQueryString(), 'page=') !== false){

                    
                        
                        foreach (Request::query() as $key => $value) {
                            if($key !='page'){
                            
                                    if($value != "") {
                                        
                                        if($QueryString != ""){
                                            $QueryString = $QueryString."&";
                                        }     
                                        $QueryString = $QueryString.$key."=".$value; 
                                    }
                                }
                            }
                        }else{
                            $QueryString = Request::getQueryString();
                        }

                        if($QueryString){
                            $isQuery = '&'.$QueryString;
                        }
                    }
                    @endphp

                    <!-- goto first page -->
                    @if($data->currentPage() > 1) 
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->url(1).$isQuery}}" aria-label="firts">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-double-left"></i>
                            </span>
                            <span class="sr-only">First</span>
                        </a>
                    </li>
                    @endif

                    <!-- goto Previous page -->
                    @if(1 != $data->currentPage() )
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->url($data->currentPage()-1).$isQuery}}" tabindex="-1" aria-label="Previous">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    @endif

                    @for ($i = $sPage; $i <= $MaxPage; $i++)
                    <li class="page-item {{($i == $data->currentPage()) ?'active':'' }} ">
                        <a class="page-link" href="{{ $data->url($i).$isQuery}}">{{$i}}</a>
                    </li>
                    @endfor

                    <!-- goto Next page -->
                    @if($data->lastPage() != $data->currentPage() )
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->url($data->currentPage()+1).$isQuery}}" aria-label="Next">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                    @endif

                    <!-- goto Last page -->
                    @if($data->currentPage() != $data->lastPage()) 
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->url($data->lastPage()).$isQuery}}" aria-label="Next">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="sr-only">Last</span>
                            </span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
@endif