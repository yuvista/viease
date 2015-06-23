<?php

namespace App\Http\Requests\Article;

use App\Http\Requests\Request;
use App\Models\Article;

/**
 * Article CreateRequest
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
