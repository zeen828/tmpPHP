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
                /* Replace authority for ban number */
                if (isset($data['authority']) && ($client = TokenAuth::getClient())) {
                    $data['authority'] = array_values(array_intersect(array_keys(InterfaceScope::allowedByban($client->ban)), $data['authority']));
                }
                $data = collect($data)->forget([
                    'id',
                    'source',
                    'parent_id',
                    'parent_level',
                    'oauth_token',
                    'password_extract',
                    'rebate',
                    'remark',
                    'delay',
                    'freeze',
                    'status',
                ])->all();
                break;
        }

    }
}
