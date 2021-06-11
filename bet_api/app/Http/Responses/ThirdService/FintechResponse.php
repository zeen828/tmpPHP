<?php

namespace App\Http\Responses\ThirdService;

use Illuminate\Routing\ResponseFactory;

/**
 * Class FintechResponse.
 *
 * @package App\Http\Responses\ThirdService
 */
class FintechResponse extends ResponseFactory
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
