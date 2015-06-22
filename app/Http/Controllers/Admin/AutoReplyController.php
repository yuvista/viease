<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\AutoReply\CreateRequest;
use App\Http\Requests\AutoReply\UpdateRequest;
use App\Services\Account as AccountService;
use App\Repositories\AutoReplyRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 自动回复管理
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AutoReplyController extends Controller
{
    /**
     * account 服务
     *
     * @var App\Services\Account
     */
    private $service;

    /**
     * AutoReplyRepository
     *
     * @var App\Repositories\AutoReplyRepository
     */
    private $autoReply;

    /**
     * construct
     *
     * @param AccountService      $service
     * @param AutoReplyRepository $autoReply
     */
    public function __construct(AccountService $service,AutoReplyRepository $autoReply)
    {
        $this->service = $service;

        $this->autoReply = $autoReply;
    }

    /**
     * 获取自动回复
     *
     * @return void
     */
    public function getIndex()
    {
        $list = $this->autoReply->getIndex($this->service->getCurrent());

        //view
        return admin_view('auto-reply.index');
    }
}