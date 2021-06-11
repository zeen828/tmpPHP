<?php

namespace App\Http\Responses\System;

use Illuminate\Routing\ResponseFactory;

/**
 * Class ParameterCreateResponse.
 *
 * @package App\Http\Responses\System
 */
class ParameterCreateResponse extends ResponseFactory
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

        $named = request()->route()->getName();
        switch ($named) {
            case 'system.parameter.index':
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'id'
                    ])->all();
                })->all();
                break;
            case 'system.parameter.read':
                $data = collect($data)->forget([
                    'id'
                ])->all();
                break;
        }
    }
}
