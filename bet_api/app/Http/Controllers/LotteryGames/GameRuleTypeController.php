<?php

namespace App\Http\Controllers\LotteryGames;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LotteryGames\GameRuleTypeCreateRequest;
use App\Http\Requests\LotteryGames\GameRuleTypeUpdateRequest;
use App\Http\Responses\LotteryGames\GameRuleTypeCreateResponse;
use App\Http\Responses\LotteryGames\GameRuleTypeUpdateResponse;
use App\Exceptions\LotteryGames\GameRuleTypeExceptionCode as ExceptionCode;
use App\Repositories\LotteryGames\GameRuleTypeRepository;
use App\Validators\LotteryGames\GameRuleTypeValidator;

/**
 * @group
 *
 * Game Lottery / Rule Type
 *
 * @package namespace App\Http\Controllers\LotteryGames;
 */
class GameRuleTypeController extends Controller
{
    /**
     * @var GameRuleTypeRepository
     */
    protected $repository;

    /**
     * @var GameRuleTypeValidator
     */
    protected $validator;

    /**
     * GameRuleTypeController constructor.
     *
     * @param GameRuleTypeRepository $repository
     * @param GameRuleTypeValidator $validator
     */
    public function __construct(GameRuleTypeRepository $repository, GameRuleTypeValidator $validator)
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
     * id | STR | Id
     * game | STR | Lottery game name
     * name | STR | Name
     * description | STR | Description
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
     *             "id": 1,
     *             "game": "北京賽車",
     *             "name": "名次猜車號",
     *             "description": "擇一個名次(冠、亞、季軍…第十名)後，...",
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
     * @param GameRuleTypeCreateRequest $request
     * @param GameRuleTypeCreateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminList($gameId, GameRuleTypeCreateRequest $request, GameRuleTypeCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameRuleType\AdminCriteria'));

        $gameRuleTypes = $this->repository->paginate($perPage);

        return $response->success($gameRuleTypes);
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
     * id | STR | Id
     * game | STR | Lottery game name
     * name | STR | Name
     * description | STR | Description
     * sort | INT | Sort
     * status | STR | Status
     *
     * @bodyParam name STR required Item name Example: {name}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "id": 10,
     *        "game": "北京賽車",
     *        "name": "測試",
     *        "description": "測試",
     *        "sort": "99",
     *        "status": true
     *    }
     * }
     * 
     * @param int $gameId
     * @param GameRuleTypeCreateRequest $request
     * @param GameRuleTypeCreateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminCreate($gameId, GameRuleTypeCreateRequest $request, GameRuleTypeCreateResponse $response)
    {
        try {

            // Add data for routing variable combination
            $input = $request->all();
            $input['game_id'] = $gameId;

            $this->validator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $gameRuleType = $this->repository->create($input);

            return $response->success($gameRuleType);
          
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
     * id | STR | Id
     * game | STR | Lottery game name
     * name | STR | Name
     * description | STR | Description
     * sort | INT | Sort
     * status | STR | Status
     *
     * @urlParam id required Serial id Example: 1
     *
     * @response
     * {
     *     "success": true,
     *     "data": {
     *         "id": 1,
     *         "game": "北京賽車",
     *         "name": "名次猜車號",
     *         "description": "擇一個名次(冠、亞、季軍…第十名)後，...",
     *         "sort": 1,
     *         "status": true
     *     }
     * }
     * 
     * @param int $gameId
     * @param int $id
     * @param GameRuleTypeCreateRequest $request
     * @param GameRuleTypeCreateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminShow($gameId, $id, GameRuleTypeCreateRequest $request, GameRuleTypeCreateResponse $response)
    {
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameRuleType\AdminCriteria'));

        $gameRuleType = $this->repository->find($id);

        return $response->success($gameRuleType);
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
     * id | STR | Id
     * game | STR | Lottery game name
     * name | STR | Name
     * description | STR | Description
     * sort | INT | Sort
     * status | STR | Status
     *
     * @urlParam id required Serial id Example: 1
     *
     * @response
     * {
     *     "success": true,
     *     "data": {
     *         "id": 1,
     *         "game": "北京賽車TEST",
     *         "name": "測試A",
     *         "description": "測試A",
     *         "sort": "1",
     *         "status": true
     *     }
     * }
     * 
     * @param int $gameId
     * @param int $id
     * @param GameRuleTypeUpdateRequest $request
     * @param GameRuleTypeUpdateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminUpdate($gameId, $id, GameRuleTypeUpdateRequest $request, GameRuleTypeUpdateResponse $response)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $gameRuleType = $this->repository->update($request->all(), $id);

            return $response->success($gameRuleType);

        } catch (ValidatorException $e) {
            throw new ExceptionCode(ExceptionCode::NORMAL);
        }
    }

    /**
     * User query list
     * 
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * id | STR | Id
     * game | STR | Lottery game name
     * name | STR | Name
     * description | STR | Description
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
     *             "id": 1,
     *             "game": "北京賽車",
     *             "name": "名次猜車號",
     *             "description": "擇一個名次(冠、亞、季軍…第十名)後，...",
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
     * @param GameRuleTypeCreateRequest $request
     * @param GameRuleTypeCreateResponse $response
     * @return void
     */
    public function queryIntroduction($gameId, GameRuleTypeCreateRequest $request, GameRuleTypeCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameRuleType\UserCriteria'));

        $gameRuleType = $this->repository->paginate($perPage);

        return $response->success($gameRuleType);
    }
}