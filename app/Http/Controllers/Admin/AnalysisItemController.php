<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAnalysisItemRequest;
use App\Http\Requests\StoreAnalysisItemRequest;
use App\Http\Requests\UpdateAnalysisItemRequest;
use App\Jobs\ProcessPlagiarismDetection;
use App\Models\AnalysisItem;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AnalysisItemController extends Controller
{
    use MediaUploadingTrait;

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


    public function addNew($folderId)
    {
        $folder = Folder::find($folderId);
        abort_if(Gate::denies('analysis_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $authUser = authUser();
        return view('admin.analysisItems.create', compact('folder', 'authUser'));
    }

    public function runPlagiarismCheckerScript($analysisItemId){
        $analysisItem = AnalysisItem::find($analysisItemId);
        
        $script = 'python core/plagiarism_checker.py --original_text="I stand here today humbled by the task before us, grateful for the trust you have bestowed, mindful of the sacrifices borne by our ancestors. I thank President Bush for his service to our nation, as well as the generosity and cooperation he has shown throughout this transition. The new movie is awesome. The cat plays in the garden. The new movie is so great." --rewritten_text="I am humbled by the task at hand, appreciative of the trust you have placed in me, and conscious of the suffering endured by our forefathers as I stand here today. I am grateful to President Bush for his service to our country, as well as for his kindness and cooperation during this transition. The new movie is so great."';

        $python_path = '/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/venv/bin/python';
        $cmd_path = '/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/core/plagiarism_checker.py';
        
        $arg1 = '--original_text="I stand here today humbled by the task before us, grateful for the trust you have bestowed, mindful of the sacrifices borne by our ancestors. I thank President Bush for his service to our nation, as well as the generosity and cooperation he has shown throughout this transition. The new movie is awesome. The cat plays in the garden. The new movie is so great."';
        $arg2 = '--rewritten_text="I am humbled by the task at hand, appreciative of the trust you have placed in me, and conscious of the suffering endured by our forefathers as I stand here today. I am grateful to President Bush for his service to our country, as well as for his kindness and cooperation during this transition. The new movie is so great."';

        $process = new Process([$python_path, $cmd_path, $arg1, $arg2]);
        $process->run();
        
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $data = $process->getOutput();

        #return $data;

        return back()->with('success', 'Opération de d\'analyse lancée.');
        //dd($analysisItem->file);
    }

    public function analyseItem($analysisItemId){
        $analysisItem = AnalysisItem::find($analysisItemId);
        
        #$this->runPlagiarismCheckerScript($analysisItem);

        try {
            ProcessPlagiarismDetection::dispatch($analysisItem);
        } catch (\Throwable $th) {
            throw $th;
        }

        return back()->with('success', 'Opération de d\'analyse lancée.');
    }   

    public function store(StoreAnalysisItemRequest $request)
    {
        
        //dd($request->all());

        $folder = Folder::find($request->folder_id);

        $document = Document::create([
            'title'                 => $request->submitter_email,
            'from_workspace_id'     => $folder->workspace->id,
        ]);

        $analysisItem = AnalysisItem::create([
            'document_id'           => $document->id,
            'submitter_email'       => $request->submitter_email,
            'folder_id'             => $folder->id,
            'submitter_fullname'    => $request->submitter_fullname,
        ]);

        if ($request->input('file', false)) {
            $document->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $document->id]);
        }

        return redirect()->route('admin.folders.show', $folder);
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
