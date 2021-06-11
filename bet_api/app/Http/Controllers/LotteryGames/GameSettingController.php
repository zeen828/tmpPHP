<?php

namespace App\Http\Controllers\LotteryGames;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LotteryGames\GameSettingCreateRequest;
use App\Http\Requests\LotteryGames\GameSettingUpdateRequest;
use App\Http\Responses\LotteryGames\GameSettingCreateResponse;
use App\Http\Responses\LotteryGames\GameSettingUpdateResponse;
use App\Exceptions\LotteryGames\GameSettingExceptionCode as ExceptionCode;
use App\Repositories\LotteryGames\GameSettingRepository;
use App\Validators\LotteryGames\GameSettingValidator;

/**
 * @group
 *
 * Game Lottery / Setting
 *
 * @package namespace App\Http\Controllers\LotteryGames;
 */
class GameSettingController extends Controller
{
    /**
     * @var GameSettingRepository
     */
    protected $repository;

    /**
     * @var GameSettingValidator
     */
    protected $validator;

    /**
     * GameSettingController constructor.
     *
     * @param GameSettingRepository $repository
     * @param GameSettingValidator $validator
     */
    public function __construct(GameSettingRepository $repository, GameSettingValidator $validator)
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
     * id | STR | Lottery game setting id
     * name | STR | Lottery game setting name
     * description | STR | Lottery game setting description
     * week | STR | Lottery cycle.
     * start_t | STR | Draw start time. (H:i:s)
     * end_t | STR | Draw end time. (H:i:s)
     * stop_enter | STR | Stop betting time. (seconds)
     * repeat | STR | Each draw interval. (seconds)
     * win_rate | STR | Win rate.
     * status | STR | Lottery game draw status (true:success,false:failure)
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
     *             "id": 1,
     *             "name": "北京賽車",
     *             "description": "是中國北京省自立的國家福利彩票遊戲，.....",
     *             "week": "[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]",
     *             "start_t": "07:00:00",
     *             "end_t": "22:30:00",
     *             "stop_enter": 300,
     *             "repeat": 60,
     *             "win_rate": "0.400",
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
     * @param  GameSettingCreateRequest $request
     * @param  GameSettingCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function adminList(GameSettingCreateRequest $request, GameSettingCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameSetting\AdminCriteria'));

        $gameSettings = $this->repository->paginate($perPage);

        return $response->success($gameSettings);
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
     * id | STR | Serial id
     * name | STR | Item name
     *
     * @bodyParam name STR required Item name Example: {name}
     *
     * @response
     * {
     *    "success": true,
     *    "message": "GameSetting created.",
     *    "data": {
     *        "id": 1,
     *        "name": "Develop"
     *    }
     * }
     * 
     * @param  GameSettingCreateRequest $request
	 * @param  GameSettingCreateResponse $response
	 *
     * @return \Illuminate\Http\Response
     */
    public function adminCreate(GameSettingCreateRequest $request, GameSettingCreateResponse $response)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $gameSetting = $this->repository->create($request->all());

            return $response->success($gameSetting);
          
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
     * id | STR | Lottery game setting id
     * name | STR | Lottery game setting name
     * description | STR | Lottery game setting description
     * week | STR | Lottery cycle.
     * start_t | STR | Draw start time. (H:i:s)
     * end_t | STR | Draw end time. (H:i:s)
     * stop_enter | STR | Stop betting time. (seconds)
     * repeat | STR | Each draw interval. (seconds)
     * win_rate | STR | Win rate.
     * status | STR | Lottery game draw status (true:success,false:failure)
     *
     * @urlParam id required Serial id Example: 1
     *
     * @response
     * {
     *     "success": true,
     *     "data": {
     *         "id": 1,
     *         "name": "北京賽車",
     *         "description": "是中國北京省自立的國家福利彩票遊戲，.....",
     *         "week": "[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]",
     *         "start_t": "07:00:00",
     *         "end_t": "22:30:00",
     *         "stop_enter": 300,
     *         "repeat": 60,
     *         "win_rate": "0.400",
     *         "status": true
     *     }
     * }
     * 
     * @param  int $id
     * @param  GameSettingCreateRequest $request
     * @param  GameSettingCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function adminShow($id, GameSettingCreateRequest $request, GameSettingCreateResponse $response)
    {
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameSetting\AdminCriteria'));

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
     * id | STR | Lottery game setting id
     * name | STR | Lottery game setting name
     * description | STR | Lottery game setting description
     * week | STR | Lottery cycle.
     * start_t | STR | Draw start time. (H:i:s)
     * end_t | STR | Draw end time. (H:i:s)
     * stop_enter | STR | Stop betting time. (seconds)
     * repeat | STR | Each draw interval. (seconds)
     * win_rate | STR | Win rate.
     * status | STR | Lottery game draw status (true:success,false:failure)
     *
     * @urlParam id required Serial id Example: 1
     *
     * @response
     * {
     *     "success": true,
     *     "data": {
     *         "id": 1,
     *         "name": "北京賽車",
     *         "description": "是中國北京省自立的國家福利彩票遊戲，.....",
     *         "week": "[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]",
     *         "start_t": "07:00:00",
     *         "end_t": "22:30:00",
     *         "stop_enter": 300,
     *         "repeat": 60,
     *         "win_rate": "0.400",
     *         "status": true
     *     }
     * }
     * 
     * @param  int $id
     * @param  GameSettingUpdateRequest $request
     * @param  GameSettingUpdateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function adminUpdate($id, GameSettingUpdateRequest $request, GameSettingUpdateResponse $response)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $gameSetting = $this->repository->update($request->all(), $id);
            
            return $response->success($gameSetting);

        } catch (ValidatorException $e) {
            throw new ExceptionCode(ExceptionCode::NORMAL);
        }
    }

    /**
     * User quert list
     * 
     * User query list.
     * 
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * id | STR | Lottery game setting id
     * name | STR | Lottery game setting name
     * description | STR | Lottery game setting description
     * week | STR | Lottery cycle.
     * start_t | STR | Draw start time. (H:i:s)
     * end_t | STR | Draw end time. (H:i:s)
     * stop_enter | STR | Stop betting time. (seconds)
     * repeat | STR | Each draw interval. (seconds)
     * status | STR | Lottery game draw status (true:success,false:failure)
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
     *             "id": 1,
     *             "name": "北京賽車",
     *             "description": "是中國北京省自立的國家福利彩票遊戲，...",
     *             "week": "[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]",
     *             "start_t": "06:30:00",
     *             "end_t": "22:30:00",
     *             "stop_enter": 60,
     *             "repeat": 300,
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
     * @param GameSettingCreateRequest $request
     * @param GameSettingCreateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function queryGameList(GameSettingCreateRequest $request, GameSettingCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameSetting\UserCriteria'));

        $gameSetting = $this->repository->paginate($perPage);

        return $response->success($gameSetting);
    }
}