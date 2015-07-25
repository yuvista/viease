<?php

namespace App\Http\Controllers;

use App\Services\Server;
use Input;
//测试
use Log;
use Queue;
use App\Jobs\SyncNewsMaterial;

/**
 * 微信服务通讯.
 */
class ServerController extends Controller
{
    /**
     * Server.
     *
     * @var App\Services\Server
     */
    private $server;

    /**
     * construct.
     *
     * @param Server $server server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * 返回服务端.
     *
     * @return Response
     */
    public function server()
    {
        $tag = Input::get('t');

        $account = account()->getAccountByTag($tag);

        if (!$account) {
            return;
        }

        return $this->server->build($account);
    }
}
