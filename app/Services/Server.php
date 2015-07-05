<?php

namespace App\Services;

use Overtrue\Wechat\Server as WechatServer;
use Overtrue\Wechat\Message;
use Cache;

/**
 * 回复服务.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Server
{
    /**
     * 返回服务器.
     *
     * @param App\Models\Account $account account
     *
     * @return Response
     */
    public function build($account)
    {
        $appId = $account->app_id;

        $token = $account->token;

        $encodingAESKey = $account->aes_key;

        $server = new WechatServer(['app_id' => $appId, 'token' => $token, 'encoding_key' => $encodingAESKey]);

        $server->on('message', function ($message) use ($server, $account) {
            return $this->resolveMessage($account, $message, $server);
        });

        //普通事件
        $server->on('event', function ($event) use ($server, $account) {
            return $this->resolveEvent($account, $event, $server);
        });

        return $server->serve();
    }

    /**
     * 处理事件.
     *
     * @param int                    $account 公众号
     * @param array                  $event   事件
     * @param Overtrue\Wechat\Server $server  server
     *
     * @return Response
     */
    private function resolveEvent($account, $event, $server)
    {
        //$eventId = $
    }

    /**
     * 处理消息.
     *
     * @param int                    $account 公众号
     * @param array                  $message 消息
     * @param Overtrue\Wechat\Server $server  server
     *
     * @return Response
     */
    private function resolveMessage($account, $message, $server)
    {
        $replies = Cache::get('replies_'.$account->id);

        foreach ($replies as $keyword) {
            if ($keyword == $message) {
                if ($keyword['type' == 'equal']) {
                    return $this->eventsToMessage($keyword['content'], $server);
                }
            } else {
                if ($keyword['type'] == 'contain') {
                    return $this->eventsToMessage($keyword['content'], $server);
                }
            }
        }
    }

    /**
     * 事件解析为消息.
     *
     * @param string $eventId 事件Id
     *
     * @return Response
     */
    public function eventToMessage($eventId)
    {
    }

    /**
     * 多个事件解析为消息.
     *
     * @param array $eventIds 事件Ids
     *
     * @return Response
     */
    public function eventsToMessage($eventIds)
    {
        foreach ($eventIds as $eventId) {
        }
    }
}
