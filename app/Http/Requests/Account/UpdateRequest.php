<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;
use App\Models\Account;

/**
 * Account UpdateRequest
 */
class UpdateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required',
            'original_id'    => 'required',
            'wechat_account' => 'required',
        ];
    }

    /**
     * 验证不通过时返回的错误消息里的字段别名
     *
     * @return array
     */
    public function attributes()
    {
        return Account::$attributes;
    }
}
