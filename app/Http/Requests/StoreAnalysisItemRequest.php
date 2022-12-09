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
            'last_analysis_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'folder_id' => [
                'required',
                'integer',
            ],
            'submitter_fullname' => [
                'string',
                'nullable',
            ],
        ];
    }
}
