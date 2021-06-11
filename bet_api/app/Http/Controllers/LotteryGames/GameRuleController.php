<?php

namespace App\Http\Controllers\LotteryGames;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LotteryGames\GameRuleCreateRequest;
use App\Http\Requests\LotteryGames\GameRuleUpdateRequest;
use App\Http\Responses\LotteryGames\GameRuleCreateResponse;
use App\Http\Responses\LotteryGames\GameRuleUpdateResponse;
use App\Exceptions\LotteryGames\GameRuleExceptionCode as ExceptionCode;
use App\Repositories\LotteryGames\GameRuleRepository;
use App\Validators\LotteryGames\GameRuleValidator;

/**
 * @group
 *
 * Game Lottery / Rule
 *
 * @package namespace App\Http\Controllers\LotteryGames;
 */
class GameRuleController extends Controller
{
    /**
     * @var GameRuleRepository
     */
    protected $repository;

    /**
     * @var GameRuleValidator
     */
    protected $validator;

    /**
     * GameRuleController constructor.
     *
     * @param GameRuleRepository $repository
     * @param GameRuleValidator $validator
     */
    public function __construct(GameRuleRepository $repository, GameRuleValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Admin list
     * 
     * Administrator query list.
     * 
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * game | STR | Lottery game name
     * type_id | STR | Id
     * name | STR | Name
     * description | STR | Description
     * odds | STR | Odds
     * sort | INT | Sort
     * status | STR | Status
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
     * @queryParam search search keywork. Example: 名次猜車號
     * @queryParam orderBy Sort order field. Example: id,status
     * @queryParam sortedBy Sort order. Example: asc,desc
     * @queryParam page required Page number. Example: 1
     * @queryParam rows Per page rows defaults to 15. Example: 15
     *
     * @response
     * {
     *     "success": true,
     *     "data": [
     *         {
     *             "game": "北京賽車TEST",
     *             "type_id": 1,
     *             "name": "冠軍車號",
     *             "description": "",
     *             "odds": "9.700",
     *             "sort": 1,
     *             "status": true
     *         }
     *     ],
     *     "meta": {
     *         "pagination": {
     *             "total": 6,
     *             "count": 1,
     *             "per_page": 1,
     *             "current_page": 1,
     *             "total_pages": 6
     *         }
     *     }
     * }
     * 
     * @param int $gameId
     * @param GameRuleCreateRequest $request
     * @param GameRuleCreateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminList($gameId, GameRuleCreateRequest $request, GameRuleCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameRule\AdminCriteria'));

        $gameRules = $this->repository->paginate($perPage);

        return $response->success($gameRules);
    }

    /**
     * Admin create
     * 
     * Administrator created item.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * game | STR | Lottery game name
     * type_id | STR | Id
     * name | STR | Name
     * description | STR | Description
     * odds | STR | Odds
     * sort | INT | Sort
     * status | STR | Status
     *
     * @bodyParam name STR required Item name Example: {name}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "game": "北京賽車TEST",
     *        "type_id": 1,
     *        "name": "冠軍車號",
     *        "description": "",
     *        "odds": "9.700",
     *        "sort": 1,
     *        "status": true
     *    }
     * }
     * 
     * @param int $gameId
     * @param GameRuleCreateRequest $request
     * @param GameRuleCreateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminCreate($gameId, GameRuleCreateRequest $request, GameRuleCreateResponse $response)
    {
        try {

            // Add data for routing variable combination
            $input = $request->all();
            $input['game_id'] = $gameId;

            $this->validator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $gameRule = $this->repository->create($input);

            return $response->success($gameRule);
          
        } catch (ValidatorException $e) {
            throw new ExceptionCode(ExceptionCode::NORMAL);
        }
    }

    /**
     * Admin show
     * 
     * Administrator query item.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * game | STR | Lottery game name
     * type_id | STR | Id
     * name | STR | Name
     * description | STR | Description
     * odds | STR | Odds
     * sort | INT | Sort
     * status | STR | Status
     *
     * @urlParam id required Serial id Example: 1
     *
     * @response
     * {
     *     "success": true,
     *     "data": {
     *        "game": "北京賽車TEST",
     *        "type_id": 1,
     *        "name": "冠軍車號",
     *        "description": "",
     *        "odds": "9.700",
     *        "sort": 1,
     *        "status": true
     *     }
     * }
     * 
     * @param int $gameId
     * @param int $id
     * @param GameRuleCreateRequest $request
     * @param GameRuleCreateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminShow($gameId, $id, GameRuleCreateRequest $request, GameRuleCreateResponse $response)
    {
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameRule\AdminCriteria'));

        $gameSetting = $this->repository->find($id);

        return $response->success($gameSetting);
    }

    /**
     * Admin update
     * 
     * Administrator update item.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * game | STR | Lottery game name
     * type_id | STR | Id
     * name | STR | Name
     * description | STR | Description
     * odds | STR | Odds
     * sort | INT | Sort
     * status | STR | Status
     *
     * @urlParam id required Serial id Example: 1
     *
     * @response
     * {
     *     "success": true,
     *     "data": {
     *        "game": "北京賽車TEST",
     *        "type_id": 1,
     *        "name": "冠軍車號",
     *        "description": "",
     *        "odds": "9.700",
     *        "sort": 1,
     *        "status": true
     *     }
     * }
     * 
     * @param int $gameId
     * @param int $id
     * @param GameRuleUpdateRequest $request
     * @param GameRuleUpdateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminUpdate($gameId, $id, GameRuleUpdateRequest $request, GameRuleUpdateResponse $response)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $gameRule = $this->repository->update($request->all(), $id);

            return $response->success($gameRule);

        } catch (ValidatorException $e) {
            throw new ExceptionCode(ExceptionCode::NORMAL);
        }
    }

    /**
     * User query bet rule list
     *
     * @param [type] $gameId
     * @param GameRuleCreateRequest $request
     * @param GameRuleCreateResponse $response
     * @return void
     */
    public function betRuleList($gameId, GameRuleCreateRequest $request, GameRuleCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameRule\UserCriteria'));

        $gameRule = $this->repository->paginate($perPage);

        return $response->success($gameRule);
    }
}