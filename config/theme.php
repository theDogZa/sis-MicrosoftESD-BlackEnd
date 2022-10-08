<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */



    /*
    |--------------------------------------------------------------------------
    | Theme layout
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */
    'paginator' => [
        'paginate' => 15, //---Record per page
        'number_limit_page' => 5, //--- num 
    ],

    'layout' => [
        'form' => 'col-6 mb-3',
        'view' => 'col-6 mb-3',
        'main_block' => 'block-themed block-rounded ', //--- block-themed, block-rounded, block-bordered 
        'main_block_header' => 'block-header-default', //--- block-header-default ,bg-xxx
        'table_list_item' => 'table-striped', //---  table-hover, table-vcenter, table-striped, table-bordered, table-bordered ,table-sm
        'table_list_item_head' => 'thead-light', //--- thead-light, thead-dark , bg-xxx

        'search' => 'col-4',
        'main_block_search_header' => ' bg-info-light block-header-rtl', //--- block-header-default ,bg-xxx
    ],
    'icon' => [
        'app' => '',
        'item_list' => 'fa fa-list-alt',
        'item_form' => 'fa fa-pencil-square',
        'item_view' => 'fa fa-info-circle',
        'item_order' => 'fa fa-shopping-cart',
        'item_inventory' => 'fa fa-archive',
        'item_transactions' => 'fa fa-list-ol',
        'item_articles' => 'fa fa-briefcase',
        'item_online' => 'fa  fa-mixcloud',
        'menu_stores' => 'fa fa-industry',
        'menu_articles' => 'fa fa-briefcase',
        'menu_orders' => 'fa fa-shopping-cart',
        'menu_inventory' => 'fa fa-archive',
        'get_orders' => 'si si-cloud-download',
        'get_order' => 'fa fa-cloud-download',
        'advanced_search' => 'fa fa-search-plus',
        'search' => 'fa fa-search',
        'menu_report' => 'fa fa-line-chart',
        'get_orders' => 'si si-cloud-download',
        'get_order' => 'fa fa-cloud-download',
        'btn' => [
            'get_order' => 'fa fa-cloud-download',
            'get_orders' => 'si si-cloud-download',
        ]
    ],
    'textarea' => [
        'limit' => 30,
        'end_str' => '...'
    ],
    'format' => [
        'date' => 'd-m-Y',
        'time' => 'H:i',
        'datetime' => 'd-m-Y H:i',
        'js_date' => '"DD-MM-YYYY',
        'js_time' => 'HH:MM',
        'js_datetime' => '"DD-MM-YYYY HH:MM'
    ]

];
