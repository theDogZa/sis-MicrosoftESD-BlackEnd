<?php

return [

    /*
    |--------------------------------------------------------------------------
    | users Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the users library to build
    | the simple users links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

/* breadcrumd */
    'controllername' => 'Users ',
    'index' => ' Lists ',
    'create' => ' Add ',
    'edit' => ' Edit ',
    'show' => ' View ',
    'list_permissions' => 'Permissions',

    'heading' => 'Users',
    'head_title' => [
        'list' => 'List Users',
        'add' => 'Add User',
        'edit' => 'Edit User',
        'view' => 'view User',
        'search' => 'search',
    ],

    'username' => [
        'th' => 'Username',
        'label' => 'Username',
        'placeholder' => 'Username',
        'popover' => [
            'title' => 'set Username',
            'content' => 'Use 4 or more characters'
        ],
    ],
    'first_name' => [
        'th' => 'Firstname',
        'label' => 'Firstname',
        'placeholder' => 'Firstname',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'last_name' => [
        'th' => 'Lastname',
        'label' => 'Lastname',
        'placeholder' => 'Lastname',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'email' => [
        'th' => 'Email',
        'label' => 'Email',
        'placeholder' => 'Email',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'email_verified_at' => [
        'th' => 'Email_verifiedat',
        'label' => 'Email_verifiedat',
        'placeholder' => 'Email_verifiedat',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'password' => [
        'th' => 'Password',
        'label' => 'Password',
        'placeholder' => 'Password',
        'popover' => [
            'title' => 'set strong password',
            'content' => 'Use 8 or more characters that contain both lowercase letters. uppercase letters, numbers and combinations of symbols'
        ],
    ],
    'password_confirmation' => [
        'th' => 'Confirmation password',
        'label' => 'Confirmation password',
        'placeholder' => 'Confirmation password',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'user_right' => [
        'th' => 'user right',
        'label' => 'user right',
        'placeholder' => 'user right',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
        'text_right' => [
            'all' => 'All',
            '0' => '-',
            '1' => 'Front End',
            '5' => 'Back End',
            '9' => 'Front & Back'
        ],
    ],
    'is_chang_password' => [
        'th' => 'Change Password',
        'label' => 'Change Password',
        'placeholder' => 'Change Password',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
        'text_checkbox' => [
            'check' => 'Force User Change Password ?',
        ]
    ],
    'active' => [
        'th' => 'Active',
        'label' => 'Active',
        'placeholder' => 'Active',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
        'text_radio' => [
            'all' => 'All',
            'true' => 'Active',
            'false' => 'Disabled'
        ],
    ],
    'activated' => [
        'th' => 'Activated',
        'label' => 'Activated',
        'placeholder' => 'Activated',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
        'text_radio' => [
            'all' => 'All',
            'true' => 'Yes',
            'false' => 'No',
        ],
    ],
    'remember_token' => [
        'th' => 'Remembertoken',
        'label' => 'Remembertoken',
        'placeholder' => 'Remembertoken',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'last_login' => [
        'th' => 'Last login',
        'label' => 'Last login',
        'placeholder' => 'Last login',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'created_at' => [
        'th' => 'Created at',
        'label' => 'Created at',
        'placeholder' => 'Created at',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'updated_at' => [
        'th' => 'Updated at',
        'label' => 'Updated at',
        'placeholder' => 'Updated at',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],
    'created_uid' => [
        'th' => 'Created By',
        'label' => 'Created By',
        'placeholder' => 'Created By',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
        'by_register' => 'register'
    ],
    'updated_uid' => [
        'th' => 'Updated By',
        'label' => 'Updated By',
        'placeholder' => 'Updated By',
        'popover' => [
            'title' => '',
            'content' => ''
        ],
    ],

    //----login & register
    'register' => [
        'heading' => 'Create New Account',
        'heading_sub' => '',
        'title' => 'Please add your details',
        'button' => 'Create Account',
        'link' => 'Create Account',
    ],
    'login' => [
        'heading' => '',
        'heading_sub' => '',
        'title' => 'Login',
        'button' => 'Login',
        'link' => 'Login',
    ],

    'message_password_not_match_confirmation' => 'The password confirmation does not match. !',
    'message_password_min_characters' => 'The password must be at least 8 characters. !',

    'message_confirm_register' => [
        'title' =>  'register user. ',
        'message' =>  'Please confirm register user. !',
    ],

    'message_confirm_create' => [
        'title' =>  'create user. ',
        'message' =>  'Please confirm create user. !',
    ],
    'message_confirm_update' => [
        'title' =>  'edit user. ',
        'message' =>  'Please confirm edit user. !',
    ],

    'message_username_inuse' => ' has already been taken. !',
    'message_email_inuse' => ' has already been taken. !',
    'message_username_inuse' => ' has already been taken. !',
    'message_username_min_characters' => 'The username must be at least 4 characters. !',
    'message_email_valid' => ' The email must be a valid email address. !',

];



/** 
 * CRUD Laravel
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 06/04/2018 13:51
 * Version : v.10000
 *
 * File Create : 2020-09-18 17:11:34 *
 */