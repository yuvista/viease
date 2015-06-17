<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Models\Account as AccountModel;
use Session;

/**
 * 公众号服务提供类
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Account {

    /**
     * repository
     *
     * @var App\Repositories\AccountRepository
     */
    private $repository;

    /**
     * construct
     *
     * @param App\Repositories\AccountRepository $repository repository
     */
    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 当前是否有选择公众号
     *
     * @return boolean
     */
    public function chosed()
    {
        return Session::get('account_id');
    }

    /**
     * 切换公众号
     *
     * @param  integer $accountId 公众号的Id
     *
     * @return void
     */
    public function chose($accountId)
    {
        return Session::put('account_id',$accountId);
    }

    /**
     * 取得当前使用中的公众号
     *
     * @return void
     */
    public function getCurrent()
    {
        return $this->chosed() ? $this->repository->getById($this->chosed()) : NULL;
    }
}