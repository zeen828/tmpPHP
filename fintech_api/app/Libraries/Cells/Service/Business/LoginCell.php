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
 * Final Class LoginCell.
 *
 * @package App\Libraries\Cells\Service\Business
 */
final class LoginCell extends CellBase
{

    /**
     * Get the validation rules that apply to the arguments input.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'inviter' => 'object_verifier:'. Member::class,
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
            $inviter = $this->getInput('inviter'); // object | null

            $user = $this->getInput('user'); // object

            $type = $this->getInput('type');

            if (! Janitor::isAllowed(Janitor::getGuestClass($type), 'business')) {
                throw new ServiceExceptionCode(ServiceExceptionCode::UNAVAILABLE_SERVICE);
            }
            $janitorData = Janitor::getGuestData($type);
            $inviteable = (isset($janitorData['available_invite']) ? $janitorData['available_invite'] : false);
            if (! $inviteable && isset($inviter)) {
                throw new ServiceExceptionCode(ServiceExceptionCode::UNAVAILABLE_INVITE);
            }
            if ($inviteable) {
                if (isset($inviter) && (TokenAuth::model() === get_class($inviter) || ! TokenAuth::getAuthGuard($inviter))) {
                    throw new ServiceExceptionCode(ServiceExceptionCode::INVITER_TYPE_NOT_SUPPORT);
                }
                if (isset($inviter) && ! ($inviterId = $inviter->getJWTIdentifier())) {
                    throw new ServiceExceptionCode(ServiceExceptionCode::INVALID_INVITER);
                }
            }
            if (TokenAuth::model() === get_class($user) || ! TokenAuth::getAuthGuard($user)) {
                throw new ServiceExceptionCode(ServiceExceptionCode::USER_TYPE_NOT_SUPPORT);
            }
            if (! $id = $user->getJWTIdentifier()) {
                throw new ServiceExceptionCode(ServiceExceptionCode::INVALID_USER);
            }
            if ($inviteable && isset($inviter) && $inviterId === $id) {
                throw new ServiceExceptionCode(ServiceExceptionCode::NON_PERMITTED_INVITER_OBJECT);
            }
            /* Save auth unique code */
            if (isset($janitorData['login_url']) && ($code = StorageSignature::build([
                'mark' => 'Business',
                'type' => 'login', 
                'business' => $type, 
                'inviter_model' => ($inviteable && is_object($inviter) ? get_class($inviter) : ''), 
                'inviter_id' => ($inviteable && is_object($inviter) ? $inviterId : ''),
                'model' => get_class($user), 
                'id' => $id
            ], $user->getUTSTTL()))) {
                /* Return authorization signature link */
                $source = [
                    'link' => Str::replaceLast('{code}', $code, $janitorData['login_url']),
                    'expires_in' => $user->getUTSTTL() * 60
                ];
                /* Return success message */
                return $this->success($source);
            }
            throw new ServiceExceptionCode(ServiceExceptionCode::AUTH_LINK_CREATE_FAIL);
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