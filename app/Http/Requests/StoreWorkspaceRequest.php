<?php

namespace App\Http\Requests;

use App\Models\Workspace;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWorkspaceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('workspace_create');
    }

    public function rules()
    {
        return [
            'owner_id' => [
                'required',
                'integer',
            ],
            'workspace_name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
