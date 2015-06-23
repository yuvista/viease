<?php

namespace App\Http\Requests\FollowReply;

use App\Http\Requests\Request;
use App\Models\FollowReply;

/**
 * FollowReply UpdateRequest.
 */
class CreateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['account_id' => 'required'];
    }
}
