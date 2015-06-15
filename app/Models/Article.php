<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * 字段白名单
     *
     * @var array
     */
    protected $fillable = [
        'original_id',

    ];

    /**
     * 用于表单验证时的字段名称提示
     *
     * @var array
     */
    public static $aliases = [
        'name'           => '公众号名称',
        'original_id'    => '原始ID',
    ];
}


