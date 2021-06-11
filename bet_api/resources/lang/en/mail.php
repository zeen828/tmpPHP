<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Subject
    |--------------------------------------------------------------------------
    |
    | Set the subject code relative name list.
    |
    | Example :
    | 'subject' => [
    |   Letter subject code => Letter subject name
    | ]
    */

    'subject' => [
        'AUTH_LOGIN_LETTER' => 'Authorization Login Letter',
    ],

    /*
    |--------------------------------------------------------------------------
    | Blade Template
    |--------------------------------------------------------------------------
    |
    | Set the relative replacement list of the blade template content.
    |
    | Example :
    | 'blade' => [
    |   Letter subject code => [ 
    |     Replacement object code => Replace content,
    |    ],
    | ]
    */

    'blade' => [
        'AUTH_LOGIN_LETTER' => [
            'TITLE' => 'Notification',
            'BUTTON_NAME' => 'Login Service',
            'TOP_CONTENT' => 'This is an authorized login service letter!',
            'BOTTOM_CONTENT' => 'Thanks,<br>Please click the login button to enter the service within :ttl minutes.',
        ],
    ],
];