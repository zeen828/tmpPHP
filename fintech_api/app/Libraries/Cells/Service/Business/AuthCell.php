<?php

namespace App\Libraries\Cells\Service\Business;

use App\Libraries\Abstracts\Base\Cell as CellBase;
use App\Exceptions\Business\ServiceExceptionCode;
use App\Exceptions\Jwt\AuthExceptionCode;
use App\Libraries\Instances\Router\Janitor;
use App\Entities\Member\Auth as Member;
use TokenAuth;
use StorageSignature;

/**
 * Final Class AuthCell.
 *
 * @package App\Libraries\Cells\Service\Business
 */
final class AuthCell extends CellBase
{
    /**
     * Get the validation rules that apply to the arguments input.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'type' => 'required',
            'signature' => 'required|size:72',
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

            $type = $this->getInput('type');

            if (! Janitor::isAllowed(Janitor::getGuestClass($type), 'business')) {
                throw new ServiceExceptionCode(ServiceExceptionCode::UNAVAILABLE_SERVICE);
            }
            
            $signature = $this->getInput('signature');

            if (($data = StorageSignature::get($signature)) && isset($data['mark'], $data['type'], $data['business'], $data['inviter_model'], $data['inviter_id'], $data['model'], $data['id']) && $data['mark'] === 'Business' && $data['type'] === 'login' && $data['business'] === $type) {
                StorageSignature::forget($signature);
                $janitorData = Janitor::getGuestData($type);
                $inviteable = (isset($janitorData['available_invite']) ? $janitorData['available_invite'] : false);
                if ($inviteable) {
                    if (isset($data['inviter_model'][0]) && (! TokenAuth::getAuthGuard($data['inviter_model']) || $data['inviter_model'] !== Member::class)) {
                        throw new ServiceExceptionCode(ServiceExceptionCode::INVITER_TYPE_NOT_SUPPORT);
                    }
                    if (isset($data['inviter_model'][0]) && !($inviter = app($data['inviter_model'])->find($data['inviter_id']))) {
                        throw new ServiceExceptionCode(ServiceExceptionCode::INVALID_INVITER);
                    }
                }
                if (! TokenAuth::getAuthGuard($data['model']) || $data['model'] !== Member::class) {
                    throw new ServiceExceptionCode(ServiceExceptionCode::USER_TYPE_NOT_SUPPORT);
                }
                if (! $user = app($data['model'])->find($data['id'])) {
                    throw new ServiceExceptionCode(ServiceExceptionCode::INVALID_USER);
                }
                /* Check auth user status */
                $user->verifyHoldStatusOnFail();
                /* User auth info */
                $source = [
                    'uid' => $user->uid,
                    'nickname' => (isset($user->nickname) ? $user->nickname : '')
                ];
                /* Inviter uid */
                if ($inviteable) {
                    $source['inviter_uid'] = (isset($inviter->uid) ? $inviter->uid : '');
                }
                /* Return success message */
                return $this->success($source);
            }
            throw new ServiceExceptionCode(ServiceExceptionCode::INVALID_SIGNATURE);
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