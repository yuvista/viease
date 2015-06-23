<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowReply extends Model
{
    use SoftDeletes;

    /**
     * 字段白名单
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'follow',
        'default',
                          ];

    /**
     * 用于表单验证时的字段名称提示
     *
     * @var array
     */
    public static $aliases = [
        'account_id'     => '所属公众号',
        'follow'         => '关注回复',
        'default'        => '默认回复',
                             ];
}
