<!DOCTYPE html>
<html>
    <head>
        <title>{!! ucfirst(__('mail.tokenExpired.title')) !!}</title>
    </head>
    <body>
        <div class="container">
            <div class="content" style="margin: 0 auto; padding: 24px 24px 1px; max-width: 970px;">
                <div class="title" style="text-align: center!important;">
                    <p style="margin-bottom: 10px;">
                    {!! ucfirst(__('mail.tokenExpired.body_title',['store'=>$Store, 'day'=> $Day])) !!}
                    </p>
                </div>
                <br><br><br>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.tokenExpired.store_type')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;{{$Platform}}</div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.tokenExpired.store_name')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;{{$Store}}</div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.tokenExpired.expired_date')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;{{$Date}}</div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 200px;">{!! ucfirst(__('mail.tokenExpired.url')) !!}</div>
                    <div style="float:left; width: 400px;">:&nbsp;&nbsp;&nbsp;<a href="{{$Link}}">{{$Link}}</div>
                </div>
              
  
                <p style="text-indent: 100px; line-height: 150%; margin-bottom: 30px;"></p>

            </div>
        </div>
    </body>
</html>
