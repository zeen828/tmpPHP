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
            /* Admin */
            /* data list */
            case 'member.admin.setting.user.list':
                // 不顯示的欄位
                $data['data'] = collect($data['data'])->map(function ($info) {
                    return collect($info)->forget([
                        'id',
                    ])->all();
                })->all();
                break;
            default:
                break;
        }
    }
}
