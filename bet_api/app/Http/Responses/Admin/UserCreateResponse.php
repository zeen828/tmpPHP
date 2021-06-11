<?php

namespace App\Http\Responses\Admin;

use Illuminate\Routing\ResponseFactory;
use App\Libraries\Instances\System\InterfaceScope;
use TokenAuth;

/**
 * Class UserCreateResponse.
 *
 * @package App\Http\Responses\Admin
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
            case 'admin.user.index':
                $data['data'] = collect($data['data'])->map(function ($info) {
                    /* Replace account */
                    if (isset($info['account'])) {
                        $info['account'] = str_pad(substr($info['account'], 0, 4), 8, '*');
                    }
                    return collect($info)->forget([
                        'id',
                        'authority',
                        'password',
                    ])->all();
                })->all();
                break;
            case 'admin.user.read':
                /* Replace account */
                if (isset($data['account'])) {
                    $data['account'] = str_pad(substr($data['account'], 0, 4), 8, '*');
                }
                /* Replace authority for ban number */
                if (isset($data['authority']) && ($client = TokenAuth::getClient())) {
                    $data['authority'] = array_values(array_intersect(array_keys(InterfaceScope::allowedByban($client->ban)), $data['authority']));
                }
                $data = collect($data)->forget([
                    'id',
                    'password',
                ])->all();
                break;
        }
    }
}
