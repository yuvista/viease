<?php

namespace App\Services;

use Overtrue\Wechat\Server as WechatServer;
use Overtrue\Wechat\Message;

/**
 * 回复服务.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Server
{
    /**
     * 返回服务器
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

        $server->on('message', function($message){

        });

        // 监听关注事件
        $server->on('event', 'subscribe', function($event) {

        });

        //普通事件
        $server->on('event', function($event) {

        });

        return $server->serve();
    }


}