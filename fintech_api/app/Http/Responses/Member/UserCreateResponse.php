<?php

namespace App\Http\Responses\Member;

use Illuminate\Routing\ResponseFactory;

/**
 * Class UserCreateResponse.
 *
 * @package App\Http\Responses\Member
 */
class UserCreateResponse extends ResponseFactory
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
            case 'member.user.index':
                $data['data'] = collect($data['data'])->map(function ($info) {
                        /* Replace account */
                        if (isset($info['account'])) {
                            $info['account'] = str_pad(substr($info['account'], 0, 4), 8, '*');
                        }
                        if (isset($info['setting'])) {
                            unset($info['setting']['pin']);
                        }
                        return collect($info)->forget([
                            'id',
                            'password',
                        ])->all();
                })->all();
                break;
            case 'member.user.read':
                /* Replace account */
                if (isset($data['account'])) {
                    $data['account'] = str_pad(substr($data['account'], 0, 4), 8, '*');
                }
                if (isset($data['setting'])) {
                    unset($data['setting']['pin']);
                }
                $data = collect($data)->forget([
                    'id',
                    'password',
                ])->all();
                break;
        }
    }
}
