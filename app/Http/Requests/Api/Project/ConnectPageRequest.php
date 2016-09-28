<?php

namespace App\Http\Requests\Api\Project;

use App\Http\Requests\Request;
use Gate;

class ConnectPageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('view', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page.name' => 'required|max:255',
            'page.id' => 'required|max:255|unique:projects,page_id',
            'page.access_token' => 'required|max:255',
        ];
    }
}
