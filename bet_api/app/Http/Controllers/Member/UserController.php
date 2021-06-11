<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Member\UserCreateRequest;
use App\Http\Requests\Member\UserUpdateRequest;
use App\Http\Responses\Member\UserCreateResponse;
use App\Http\Responses\Member\UserUpdateResponse;
use App\Exceptions\Member\UserExceptionCode as ExceptionCode;
use App\Exceptions\Member\AuthExceptionCode;
use App\Repositories\Member\UserRepository;
use App\Validators\Member\UserValidator;
use App\Exceptions\Jwt\AuthExceptionCode as JwtAuthExceptionCode;
use TokenAuth;
// use StorageSignature;

/**
 * @group
 *
 * Manage Member
 *
 * @package namespace App\Http\Controllers\Member;
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * UserController constructor.
     *
     * @param UserRepository $repository
     * @param UserValidator $validator
     */
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Admin list
     * 
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * uid | STR | User serial id
     * source | INT | User source(Client id)
     * parent_id | STR | User parent user id
     * account | STR | User account(Client id + _ + User Uid)
     * delay | STR | User bet delay second
     * status | STR | User status
     * created_at | STR | Datetime when the user was created
     * updated_at | STR | User last updated datetime
     * 
     * meta.pagination :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * total | INT | Total number of data
     * count | INT | Number of data displayed
     * per_page | INT | Number of displayed data per page
     * current_page | INT | Current page number
     * total_pages | INT | Total pages
     *
     * @queryParam search search keywork. Example: 北京賽車
     * @queryParam orderBy Sort order field. Example: id,win_rate,status
     * @queryParam sortedBy Sort order. Example: asc,desc
     * @queryParam page required Page number. Example: 1
     * @queryParam rows Per page rows defaults to 15. Example: 15
     * 
     * @response
     * {
     *     "success": true,
     *     "data": [
     *         {
     *             "uid": "6281294583",
     *             "source": 1,
     *             "parent_id": 0,
     *             "account": "1_422652884",
     *             "delay": 0,
     *             "status": true,
     *             "created_at": "2021-01-04 17:07:00",
     *             "updated_at": "2021-01-04 17:07:06"
     *         }
     *     ],
     *     "meta": {
     *         "pagination": {
     *             "total": 1,
     *             "count": 1,
     *             "per_page": 15,
     *             "current_page": 1,
     *             "total_pages": 1
     *         }
     *     }
     * }
     *
     * @param UserCreateRequest $request
     * @param UserCreateResponse $response
     * @return void
     */
    public function adminList(UserCreateRequest $request, UserCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\Member\User\AdminCriteria'));

        $gameRuleTypes = $this->repository->paginate($perPage);

        if (isset($gameRuleTypes['meta']['pagination']['links'])) {
            unset($gameRuleTypes['meta']['pagination']['links']);
        }

        return $response->success($gameRuleTypes);
    }

    /**
     * Logon Or Register A Member User
     *
     * Login or register a member user account
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * signature | STR | Member user signature key
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "signature": "49fe4ee46b6e4801822606fbb3d9d3178a9d7c5e215f43c6e2de726fdfc466dd30aee1db"
     *    }
     * }
     *
     * @param UserCreateRequest $request
     * @param UserCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserCreateRequest $request, UserCreateResponse $response)
    {
        /* Register */
        $credentials = $request->only([
            // 'source',
            'account',
            'oauth_token',
            'uid',
        ]);

        /* source */
        $client = TokenAuth::getClient();
        $sourceType = get_class($client);
        $sourceId = $client->id;

        /* User parent register or query */
        $parent_id = 0;
        if (!empty($credentials['uid'])) {
            // $father_user = $this->repository->loginRegister($credentials['source'], $credentials['uid'], '', '0');
            $father_user = $this->repository->loginRegister($sourceType, $sourceId, $credentials['uid'], '', '0');
            $parent_id = $father_user->id;
        }

        /* login member user or register new member user */
        // $user = $this->repository->loginRegister($credentials['source'], $credentials['account'], $credentials['oauth_token'], $parent_id);
        $user = $this->repository->loginRegister($sourceType, $sourceId, $credentials['account'], $credentials['oauth_token'], $parent_id);
        
        // /* create signature key */
        // $data = [
        //     'model' => get_class($user),
        //     'id' => $user->getJWTIdentifier()
        // ];
        // /* Save auth unique code */
        // if (!$code = StorageSignature::build($data, config('auth.muts_ttl', 60))) {
        //     throw new JwtAuthExceptionCode(JwtAuthExceptionCode::SIGNATURE_CREATE_FAIL);
        // }
        $code = TokenAuth::injectUserSignature($user);

        return $response->success([
            'signature' => $code
        ]);
    }
}