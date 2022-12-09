<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAnalysisItemRequest;
use App\Http\Requests\StoreAnalysisItemRequest;
use App\Http\Requests\UpdateAnalysisItemRequest;
use App\Models\AnalysisItem;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnalysisItemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('analysis_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analysisItems = AnalysisItem::with(['document', 'folder', 'team'])->get();

        return view('admin.analysisItems.index', compact('analysisItems'));
    }

    public function create()
    {
        abort_if(Gate::denies('analysis_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documents = Document::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $folders = Folder::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.analysisItems.create', compact('documents', 'folders'));
    }

    public function store(StoreAnalysisItemRequest $request)
    {
        $analysisItem = AnalysisItem::create($request->all());

        return redirect()->route('admin.analysis-items.index');
    }

    public function edit(AnalysisItem $analysisItem)
    {
        abort_if(Gate::denies('analysis_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documents = Document::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $folders = Folder::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $analysisItem->load('document', 'folder', 'team');

        return view('admin.analysisItems.edit', compact('analysisItem', 'documents', 'folders'));
    }

    public function update(UpdateAnalysisItemRequest $request, AnalysisItem $analysisItem)
    {
        $analysisItem->update($request->all());

        return redirect()->route('admin.analysis-items.index');
    }

    public function show(AnalysisItem $analysisItem)
    {
        abort_if(Gate::denies('analysis_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analysisItem->load('document', 'folder', 'team');

        return view('admin.analysisItems.show', compact('analysisItem'));
    }

    public function destroy(AnalysisItem $analysisItem)
    {
        abort_if(Gate::denies('analysis_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analysisItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyAnalysisItemRequest $request)
    {
        AnalysisItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
