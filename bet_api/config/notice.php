<?php
return [

    /*
     |--------------------------------------------------------------------------
     | Bulletin Notifiable Entities Model
     |--------------------------------------------------------------------------
     |
     | Set up a list of notifiable guard model for bulletin.
     |
     | Example :
     | 'bulletin_notifiables' => [
     |    Unique guard model class,
     | ]
     */

    'bulletin_notifiables' => [
        App\Entities\Member\Auth::class,
    ],
];
