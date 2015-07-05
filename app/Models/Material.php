<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;
    /**
     * 单图文类型.
     */
    const IS_SIMPLE = 1;

    /**
     * 多图文类型.
     */
    const IS_MULTI = 2;

    /**
     * 远程素材类型.
     */
    const IS_REMOTE = 1;

    /**
     * 非远程素材.
     */
    const IS_NOT_REMOTE = 2;

    /**
     * 创建来自自己.
     */
    const CREATED_FROM_SELF = 1;

    /**
     * 创建来自微信
     */
    const CREATED_FROM_WECHAT = 2;

    /**
     * 字段白名单.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'original_id',
        'type',
        'parent_id',
        'title',
        'description',
        'author',
        'content',
        'show_cover_pic',
        'cover_url',
        'created_from',
        'content_url',
        'source_url',
                            ];

    /**
     * 用于表单验证时的字段名称提示.
     *
     * @var array
     */
    public static $aliases = [
        'account_id' => '所属公众号',
        'type' => '类型',
        'url' => '素材地址',
        'app_id' => '应用ID',
        'title' => '视频标题',
        'digest' => '视频描述',
                             ];
}
