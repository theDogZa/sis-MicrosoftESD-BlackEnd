<!DOCTYPE html>
<html>
    <head>
        <title>{!! ucfirst(__('mail.NotFoundInv.title')) !!}</title>
    </head>
    <body>
        <div class="container">
            <div class="content" style="margin: 0 auto; padding: 24px 24px 1px; max-width: 970px;">
                <div class="title" style="text-align: center!important;">
                    <p style="margin-bottom: 10px;">
                    {!! ucfirst(__('mail.NotFoundInv.body_title',['articleNo'=>$article_no, 'storeName'=> $Store['store_name']])) !!}
                    </p>
                </div>
                <br><br><br>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.NotFoundInv.store_type')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;{{$Platform}}</div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.NotFoundInv.store_name')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;{{$Store['store_name']}}</div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.NotFoundInv.order_no')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;{{$Order['order_no']}}</div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.NotFoundInv.order_date')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;{{$Order['order_date']}}</div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.NotFoundInv.article_no')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;{{$article_no}}</div>
                </div>
  
                <p style="text-indent: 100px; line-height: 150%; margin-bottom: 30px;"></p>

            </div>
        </div>
    </body>
</html>
