<?php

namespace App\Http\Requests;

use App\Models\AnalysisItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAnalysisItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('analysis_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:analysis_items,id',
        ];
    }
}
