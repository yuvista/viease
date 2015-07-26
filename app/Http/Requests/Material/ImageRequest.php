<?php

namespace App\Http\Requests\Material;

use App\Http\Requests\Request;

/**
 * ImageRequest.
 */
class ImageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'url' => 'required',
        ];
    }
}
