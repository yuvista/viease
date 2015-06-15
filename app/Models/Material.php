<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    /**
     * 字段白名单
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'type',
        'url',
        'title',
        'digest'
    ];

    /**
     * 用于表单验证时的字段名称提示
     *
     * @var array
     */
    public static $aliases = [
        'account_id'     => '所属公众号',
        'type'           => '类型',
        'url'            => '素材地址',
        'app_id'         => '应用ID',
        'title'          => '视频标题',
        'digest'         => '视频描述',
    ];
}


