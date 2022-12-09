<?php

namespace App\Http\Requests;

use App\Models\AnalysisItem;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAnalysisItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('analysis_item_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'submitter_email' => [
                'email',
                'required',
            ],
            'submitter_fullname' => [
                'string',
                'required',
            ],
        ];
    }
}
