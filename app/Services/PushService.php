<?php

namespace App\Services;

use App\Models\System\Role;
use App\Models\System\User;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use Log;
use Pusher\PushNotifications\PushNotifications;
use LaravelFCM\Facades\FCM;

class PushService
{

    public function __construct()
    {
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function pusher($params)
    {
        if (isset($params['title']) && isset($params['message'])) {
            Log::info('Invalid params for pushser push notification');
            return;
        }
        $push = new PushNotifications([
            "instanceId" => env('PUSHER_INSTANCE_ID'),
            "secretKey" => env('PUSHER_SECRET_KEY')
        ]);
        if (isset($push) && !!$push) {
            $publishResponse = $push->publish(["donuts"], [
                "fcm" => [
                    "notification" => $params
                ]
            ]);
        }
    }

    /**
     * @param $title
     * @param $message
     * @param $data
     * @param string|User|Role $target
     */
    public function fcm($title = 'Platform', $message = '', $data = [], $target = null)
    {
        if (!env("FCM_SERVER_KEY") || !env("FCM_SENDER_ID") || !env("FCM_PROTOCOL"))
            return;
        $tokens = [];
        if (!!$target) {
            if ($target instanceof Role) $tokens = $target->users()->pluck('fcm_token')->toArray();
            else if ($target instanceof User) $tokens[] = $target->fcm_token;
            else if (is_string($target)) {
                $topic = new Topics();
                $topic->topic($target);
            }
        }

        $_option = (new OptionsBuilder())->setTimeToLive(60 * 20)->build();
        $_notification = (new PayloadNotificationBuilder($title))->setBody($message ?: '')->setSound('default')->build();
        $_data = (new PayloadDataBuilder())->addData(is_array($data) ? $data : [])->build();

        $downstreamResponse = null;
        if (count($tokens) > 0)
            $response = FCM::sendTo($tokens, $_option, $_notification, $_data);
        elseif (isset($topic)) {
            $response = FCM::sendToTopic($topic, null, $_notification, null);
        } else {
            $response = FCM::sendTo(null, $_option, $_notification, $_data);
        }
        return $response;
    }
}
