<?php

namespace App\Http\Responses\Member;

use Illuminate\Routing\ResponseFactory;

/**
 * Class AuthCreateResponse.
 *
 * @package App\Http\Responses\Member
 */
class AuthCreateResponse extends ResponseFactory
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
            case 'member.auth.read':
                if (isset($data['setting'])) {
                    unset($data['setting']['pin']);
                }
                $data = collect($data)->forget([
                    'id',
                    'account',
                    'password',
                    'status'
                ])->all();
                break;
        }
    }
}
