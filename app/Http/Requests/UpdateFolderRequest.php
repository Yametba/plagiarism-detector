<?php

namespace App\Http\Requests;

use App\Models\Folder;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFolderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('folder_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'workspace_id' => [
                'required',
                'integer',
            ],
            'plagiarism_threshold_allowed' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'submitter_email' => [
                'required',
            ],
            'submitter_fullname' => [
                'string',
                'nullable',
            ],
        ];
    }
}
