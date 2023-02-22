<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnalysisItemRequest;
use App\Http\Requests\UpdateAnalysisItemRequest;
use App\Http\Resources\Admin\AnalysisItemResource;
use App\Models\AnalysisItem;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Response;

class AnalysisItemApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('analysis_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnalysisItemResource(AnalysisItem::with(['folder', 'document', 'team'])->get());
    }

    public function store(StoreAnalysisItemRequest $request)
    {
        $analysisItem = AnalysisItem::create($request->all());

        return (new AnalysisItemResource($analysisItem))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AnalysisItem $analysisItem)
    {
        abort_if(Gate::denies('analysis_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnalysisItemResource($analysisItem->load(['folder', 'document', 'team']));
    }

    public function update(UpdateAnalysisItemRequest $request, AnalysisItem $analysisItem)
    {
        $analysisItem->update($request->all());

        return (new AnalysisItemResource($analysisItem))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function updateAnalysisResult(Request $request)
    {
        try {
            $analysisItem = AnalysisItem::find($request->analysis_item_id);

            $analysisItem->analysis_results = $request->analysis_results;
            $analysisItem->last_analysis_date = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));

            $analysisItem->save();

            return (new AnalysisItemResource($analysisItem))
                ->response()
                ->setStatusCode(Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(AnalysisItem $analysisItem)
    {
        abort_if(Gate::denies('analysis_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analysisItem->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}