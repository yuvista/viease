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
    private $accountRepository;

    /**
     * construct.
     *
     * @param App\Repositories\AccountRepository $repository repository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * 当前是否有选择公众号.
     *
     * @return bool
     */
    public function isChosed()
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
     *
     * @return App\Models\Account|null
     */
    public function getCurrent()
    {
        return $this->isChosed() ? $this->accountRepository->getById($this->isChosed()) : null;
    }

    /**
     * 根据tag 获取公众后.
     *
     * @param string $tag tag
     *
     * @return App\Models\Account|null
     */
    public function getAccountByTag($tag)
    {
        return $this->accountRepository->getByTag($tag);
    }

    /**
     * id获取公众号.
     *
     * @param int $accountId 公众号id
     *
     * @return App\Models\Account|null
     */
    public function getAccountById($accountId)
    {
        return $this->accountRepository->getById($accountId);
    }

    /**
     * 取得已有公众号列表.
     *
     * @return mixed
     */
    public function getLists()
    {
        return $this->accountRepository->lists(99);
    }

    /**
     * 创建识别tag.
     *
     * @return string tag
     */
    public function buildTag()
    {
        return str_random(15);
    }

    /**
     * 创建token.
     *
     * @return string token
     */
    public function buildToken()
    {
        return str_random(10);
    }

    /**
     * 创建aesKey.
     *
     * @return string aesKey
     */
    public function buildAesKey()
    {
        return str_random(43);
    }
}
