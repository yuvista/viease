<?php

namespace app\Services;

use App\Repositories\AccountRepository;
use Session;

/**
 * 公众号服务提供类.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Account
{
    /**
     * repository.
     *
     * @var App\Repositories\AccountRepository
     */
    private $repository;

    /**
     * construct.
     *
     * @param App\Repositories\AccountRepository $repository repository
     */
    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 当前是否有选择公众号.
     *
     * @return bool
     */
    public function isChosed()
    {
        return Session::has('account_id');
    }

    /**
     * 切换公众号.
     *
     * @param int $accountId 公众号的Id
     */
    public function chose($accountId)
    {
        return Session::put('account_id', $accountId);
    }

    /**
     * 取得当前使用中的公众号.
     *
     * @return App\Models\Account|null
     */
    public function getCurrent()
    {
        return $this->isChosed() ? $this->repository->getById($this->isChosed()) : null;
    }

    /**
     * 取得已有公众号列表.
     *
     * @return mixed
     */
    public function getLists()
    {
        return $this->repository->lists(99);
    }
}
