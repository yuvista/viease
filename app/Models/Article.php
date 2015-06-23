<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    const MULTI_YES = 1;

    const MULTI_NO = 0;

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
        'digest',
        'author',
        'content',
        'show_cover',
        'thumb_media_id',
        'content_url',
        'source_url',
                          ];

    /**
     * 用于表单验证时的字段名称提示.
     *
     * @var array
     */
    public static $aliases = [
        'name' => '公众号名称',
        'original_id' => '原始ID',
                             ];
}
