<?php

namespace App\Http\Requests\Material;

use App\Http\Requests\Request;
use App\Models\Material;

/**
 * Material UpdateRequest
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
            'account_id' => 'required',
            'url'        => 'required',
            'type'       => 'required|in:1,2,3',
            'title'      => 'required_if:type,3',
            'digest'     => 'required_if:type,3'
               ];
    }
}
