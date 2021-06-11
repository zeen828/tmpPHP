<?php

namespace App\Libraries\Cells\Service\Business;

use App\Libraries\Abstracts\Base\Cell as CellBase;
use App\Exceptions\Business\ServiceExceptionCode;
use App\Libraries\Instances\Router\Janitor;
use App\Entities\Member\Auth as Member;
use TokenAuth;
use Str;
use StorageSignature;

/**
 * Final Class InviteCell.
 *
 * @package App\Libraries\Cells\Service\Business
 */
final class InviteCell extends CellBase
{

    /**
     * Get the validation rules that apply to the arguments input.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'user' => 'required|object_verifier:'. Member::class,
            'type' => 'required',
            // Custom validation rules
        ];
    }

    /**
     * Execute the cell handle.
     *
     * @return array
     * @throws \Exception
     */
    protected function handle(): array
    {
        // You can use getInput function to get the value returned by validation rules
        // $this->getInput( Rules name )
        
        try {
            $user = $this->getInput('user');

            $type = $this->getInput('type');

            if (! Janitor::isAllowed(Janitor::getGuestClass($type), 'business')) {
                throw new ServiceExceptionCode(ServiceExceptionCode::UNAVAILABLE_SERVICE);
            }
            $janitorData = Janitor::getGuestData($type);
            $inviteable = (isset($janitorData['available_invite']) ? $janitorData['available_invite'] : false);
            if (! $inviteable) {
                throw new ServiceExceptionCode(ServiceExceptionCode::UNAVAILABLE_INVITE);
            }
            if (TokenAuth::model() === get_class($user) || ! TokenAuth::getAuthGuard($user)) {
                throw new ServiceExceptionCode(ServiceExceptionCode::USER_TYPE_NOT_SUPPORT);
            }
            /* Save auth unique code */
            if (isset($janitorData['invite_url'], $janitorData['invite_ttl']) && ($id = $user->getJWTIdentifier()) && ($code = StorageSignature::build([
                'mark' => 'Business',
                'type' => 'invite',
                'business' => $type,
                'model' => get_class($user),
                'id' => $id
            ], $janitorData['invite_ttl']))) {
                /* Return authorization signature link */
                $source = [
                    'link' => Str::replaceLast('{code}', $code, $janitorData['invite_url']),
                    'expires_in' => $janitorData['invite_ttl'] * 60
                ];
                /* Return success message */
                return $this->success($source);
            }
            throw new ServiceExceptionCode(ServiceExceptionCode::INVITE_LINK_CREATE_FAIL);
        } catch (\Throwable $e) {
            /* Return failure message */
            // return $this->failure([
            //     'message' => $e->getMessage()
            // ]);
            /* Throw error */
            throw $e;
        }
    }
}