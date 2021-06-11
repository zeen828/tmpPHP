<?php

namespace App\Http\Responses\Admin;

use Illuminate\Routing\ResponseFactory;
use App\Libraries\Instances\System\InterfaceScope;
use TokenAuth;

/**
 * Class AuthCreateResponse.
 *
 * @package App\Http\Responses\Admin
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
            case 'admin.auth.read':
                /* Replace authority for ban number */
                if (isset($data['authority']) && ($client = TokenAuth::getClient())) {
                    $data['authority'] = array_values(array_intersect(array_keys(InterfaceScope::allowedByban($client->ban)), $data['authority']));
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
