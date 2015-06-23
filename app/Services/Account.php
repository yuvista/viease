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
    public function chosed()
    {
        return Session::get('account_id');
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
     */
    public function getCurrent()
    {
        return $this->chosed() ? $this->repository->getById($this->chosed()) : null;
    }

    /**
     * 取得当前操作id.
     *
     * @return integet|null id
     */
    public function getId()
    {
        return $this->getCurrent() ? $this->getCurrent()->id : null;
    }
}
