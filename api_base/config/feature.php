<?php
return [

    /*
     |--------------------------------------------------------------------------
     | Feature Provider Class
     |--------------------------------------------------------------------------
     |
     | Set the list of feature classes available to the provider.
     |
     | Example :
     | 'providers' => [
     |    Feature definition code => Functional object class,
     | ]
     */

    'providers' => [
        // 'feature_code' => App\Libraries\Features\Test\CallFeature::class,
        //:end-generating:
    ],

    /*
     |--------------------------------------------------------------------------
     | Model Definition Class
     |--------------------------------------------------------------------------
     |
     | Set the list of model with feature trait.
     | With App\Libraries\Traits\Entity\Column\Feature
     |
     | Example :
     | 'models' => [
     |    Model definition name => Model with feature trait,
     | ]
     */

    'models' => [
        // 'client' => App\Entities\Jwt\Client::class
    ],

    /*
     |--------------------------------------------------------------------------
     | Release Model Feature
     |--------------------------------------------------------------------------
     |
     | Set the list of publishing features for the model.
     | With App\Libraries\Traits\Entity\Column\Feature
     |
     | Example :
     | 'release' => [
     |    Model definition name => [
     |       Features code,
     |    ],
     | ]
     */

     'release' => [
        // 'client' => [
        //     'feature_code',
        // ],
    ]
];