<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Server;

//测试

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
    public function server(Request $request)
    {
        $account = account()->getAccountByTag($request->t);

        if (!$account) {
            return;
        }

        return $this->server->make($account);
    }
}
