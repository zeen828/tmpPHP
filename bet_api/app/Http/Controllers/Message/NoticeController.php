<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Message\NoticeCreateRequest;
use App\Http\Requests\Message\NoticeUpdateRequest;
use App\Http\Responses\Message\NoticeCreateResponse;
use App\Http\Responses\Message\NoticeUpdateResponse;
use App\Exceptions\Message\NoticeExceptionCode as ExceptionCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Jwt\AuthExceptionCode;
use App\Transformers\Message\NoticeTransformer;
use App\Libraries\Instances\Notice\Bulletin;
use TokenAuth;

/**
 * @group
 *
 * User Notify
 *
 * @package namespace App\Http\Controllers\Message;
 */
class NoticeController extends Controller
{
    /**
     * NoticeController constructor.
     *
     */
    public function __construct()
    {
        //
    }

    /**
    * My Notify Messages
    *
    * Get the messages of the user notification.
    *
    * ### Response Body
    *
    * success : true
    *
    * data :
    *
    * Parameter | Type | Description
    * --------- | ------- | ------- | -----------
    * id | STR | Notice serial id
    * notice.subject | OBJ | Notice message subject
    * notice.content | OBJ | Notice message content object
    * notice.type | STR | Notice message type code
    * notice.type_name | STR | Notice message type name
    * read_at | STR | Datetime when the notice was read
    * created_at | STR | Datetime when the notice was created
    *
    * @response
    * {
    *    "success": true,
    *    "data": [
    *        {
    *            "id": "ddc09c60-8385-4e64-8516-6ba3f6fd6a64",
    *            "notice": {
    *                  "subject": "Test",
    *                  "content": {
    *                        "message": "Test message"
    *                  },
    *                  "type": "none",
    *                  "type_name": "Notice"
    *            },
    *            "read_at": "2020-04-16 11:04:19",
    *            "created_at": "2020-04-15 14:02:47"
    *        }
    *    ]
    * }
    *
    * @param NoticeCreateRequest $request
    * @param NoticeCreateResponse $response
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function messages(NoticeCreateRequest $request, NoticeCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            $source = [];
            if (in_array('Illuminate\Notifications\Notifiable', class_uses($user))) {
                Bulletin::capture($user);
                /* Self notifications */
                $all = $user->notifications;
                /* Only unread set read_at */
                $all->markAsRead();
                /* Get Source */
                $transformer = app(NoticeTransformer::class);
                $source = collect($all)->map(function ($notification) use ($user, $transformer) {
                    return $transformer->transform($notification);
                })->all();
            }
            /* Return notification messages */
            return $response->success([
                'data' => $source
            ]);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
    * My Unread Notify Messages
    *
    * Get the messages of the user unread notification.
    *
    * ### Response Body
    *
    * success : true
    *
    * data :
    *
    * Parameter | Type | Description
    * --------- | ------- | ------- | -----------
    * id | STR | Notice serial id
    * notice.subject | OBJ | Notice message subject
    * notice.content | OBJ | Notice message content object
    * notice.type | STR | Notice message type code
    * notice.type_name | STR | Notice message type name
    * read_at | STR | Datetime when the notice was read
    * created_at | STR | Datetime when the notice was created
    *
    * @response
    * {
    *    "success": true,
    *    "data": [
    *        {
    *            "id": "ddc09c60-8385-4e64-8516-6ba3f6fd6a64",
    *            "notice": {
    *                  "subject": "Test",
    *                  "content": {
    *                        "message": "Test message"
    *                  },
    *                  "type": "none",
    *                  "type_name": "Notice"
    *            },
    *            "read_at": "2020-04-16 11:04:19",
    *            "created_at": "2020-04-15 14:02:47"
    *        }
    *    ]
    * }
    *
    * @param NoticeCreateRequest $request
    * @param NoticeCreateResponse $response
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function unreadMessages(NoticeCreateRequest $request, NoticeCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            $source = [];
            if (in_array('Illuminate\Notifications\Notifiable', class_uses($user))) {
                Bulletin::capture($user);
                $unread = $user->unreadNotifications;
                /* Only unread set read_at */
                $unread->markAsRead();
                /* Get Source */
                $transformer = app(NoticeTransformer::class);
                $source = collect($unread)->map(function ($notification) use ($user, $transformer) {
                    return $transformer->transform($notification);
                })->all();
            }
            /* Return notification messages */
            return $response->success([
                'data' => $source
            ]);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * My Unread Notify Counts
     *
     * Get the counts of the user unread notification.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * count | INT | Unread count
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "count": 1
     *    }
     * }
     *
     * @param NoticeCreateRequest $request
     * @param NoticeCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unreadCounts(NoticeCreateRequest $request, NoticeCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            $count = 0;
            if (in_array('Illuminate\Notifications\Notifiable', class_uses($user))) {
                Bulletin::capture($user);
                /* Count unread */
                $count = count($user->unreadNotifications);
            }
            /* Return notification unread count */
            return $response->success([
                'count' => $count
            ]);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Remove My Read
     *
     * Remove read notification messages of the user.
     *
     * ### Response Body
     *
     * success : true
     *
     * @urlParam id required Notice serial id Example: ddc09c60-8385-4e64-8516-6ba3f6fd6a84
     *
     * @response
     * {
     *    "success": true
     * }
     *
     * @param string $id
     * @param NoticeUpdateRequest $request
     * @param NoticeUpdateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeRead($id, NoticeUpdateRequest $request, NoticeUpdateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            if (in_array('Illuminate\Notifications\Notifiable', class_uses($user))) {
                /* Delete read notifications */
                if ($user->notifications()->whereNotNull('read_at')->where('id', $id)->delete() === 0) {
                    throw new ModelNotFoundException('No query results for notifications : ' . $id);
                }
            }
            return $response->success();
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Remove All My Read
     *
     * Remove all read notification messages of the user.
     *
     * ### Response Body
     *
     * success : true
     *
     * @response
     * {
     *    "success": true
     * }
     *
     * @param NoticeUpdateRequest $request
     * @param NoticeUpdateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAllRead(NoticeUpdateRequest $request, NoticeUpdateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            if (in_array('Illuminate\Notifications\Notifiable', class_uses($user))) {
                /* Delete read notifications */
                if ($user->notifications()->whereNotNull('read_at')->delete() === 0) {
                    throw new ExceptionCode(ExceptionCode::NO_READ_NOTIFICATIONS);
                }
            }
            return $response->success();
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}
