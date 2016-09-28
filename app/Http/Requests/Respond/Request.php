<?php

namespace App\Http\Requests\Respond;

use App\Http\Requests;
use Gate;

abstract class Request extends Requests\Request
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
        ];
    }
}
