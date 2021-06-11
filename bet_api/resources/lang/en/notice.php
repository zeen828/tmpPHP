<?php

return [

     /*
     |--------------------------------------------------------------------------
     | Notify Content
     |--------------------------------------------------------------------------
     |
     | Set the notify content relative name list.
     |
     | Example :
     | 'content' => [
     |    Tag name => [
     |        Content type description => Display content
     |    ],
     |    // Other tag
     | ]
     */

    'content' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Notify Subject
    |--------------------------------------------------------------------------
    |
    | Set the subject code relative name list.
    |
    | Example :
    | 'subject' => [
    |   Subject code => Subject name
    | ]
    */

    'subject' => [
        'Transaction Notice' => 'Transaction Notice',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notify Type
    |--------------------------------------------------------------------------
    |
    | Set the type code relative name list.
    |
    | Example :
    | 'type' => [
    |   Type code => Type name
    | ]
    */

    'type' => [
        'none' => 'Notice',
        'bulletin' => 'System Notice',
        'trade' => 'Transaction Notice',
    ],
];