<?php
return [

    /*
     * |--------------------------------------------------------------------------
     * | System Parameter Description
     * |--------------------------------------------------------------------------
     * |
     * | Set the system parameter name description.
     */

    'description' => 'Trade service start at UTC time.',

    /*
     * |--------------------------------------------------------------------------
     * | Parameter Value Description
     * |--------------------------------------------------------------------------
     * |
     * | Set the parameter value description.
     * |
     * | Example :
     * | 'value' => [
     * |	'description' => (string) description,
     * |	'type' => (string) type description,
     * | ]
     */

    'value' => [
        'description' => 'UTC time format Y-m-d H:i:s',
        'type' => 'string'
    ]
];
