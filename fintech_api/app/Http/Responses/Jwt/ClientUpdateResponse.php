<?php

namespace App\Http\Responses\Jwt;

use Illuminate\Routing\ResponseFactory;

/**
 * Class ClientUpdateResponse.
 *
 * @package App\Http\Responses\Jwt
 */
class ClientUpdateResponse extends ResponseFactory
{

    /**
     * Transform the data response.
     *
     * @param array &$data
     *
     * @return void
     */
    public function transform(array &$data)
    {
        // Adjust the response format data label
    }
}
