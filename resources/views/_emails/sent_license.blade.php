<!DOCTYPE html>
<html>
    <head>
        <title>{!! ucfirst(__('mail.sentLicense.subject')) !!} {{$nameItem}}</title>
    </head>
    <body>
        <div class="container">
            <div class="content" style="margin: 0 auto; padding: 24px 24px 1px; max-width: 970px;">
                <div class="title" style="text-align: center!important;">

            </div>

                <div style="height:45px ;width: 100%;">
                    <div style="float:left; width: 700px;">
                        {!! ucfirst(__('mail.sentLicense.customer_name')) !!} {{$customerName}}
                    </div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 700px;">
                        {!! ucfirst(__('mail.sentLicense.subject')) !!}
                    </div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 700px;">
                        {!! ucfirst(__('mail.sentLicense.title')) !!}  {{@$receiptNo}}
                    </div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 700px;">
                        {!! ucfirst(__('mail.sentLicense.part_no')) !!}  {{@$partNo}}
                    </div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 700px;">
                        {!! ucfirst(__('mail.sentLicense.serial')) !!}  {{@$serial}}
                    </div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 700px;">
                        {!! ucfirst(__('mail.sentLicense.description')) !!} {{@$nameItem}}
                    </div>
                </div>
                <div style="height:45px ;width: 100%;">
                    <div style="float:left; width: 700px;">
                        {!! ucfirst(__('mail.sentLicense.quantity')) !!}  {{@$quantity}}
                    </div>
                </div>
                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 600px;">{!! ucfirst(__('mail.sentLicense.title_product_key')) !!}</div>
                </div>

                <div style="height:35px ;width: 100%;">
                    <div style="float:left; width: 700px;">
                        {!! ucfirst(__('mail.sentLicense.product_key')) !!} {{$license}}
                    </div>
                </div>
                <p style="text-indent: 100px; line-height: 150%; margin-bottom: 30px;"></p>

            </div>
        </div>
    </body>
</html>
