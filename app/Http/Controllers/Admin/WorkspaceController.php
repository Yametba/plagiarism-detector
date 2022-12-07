<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWorkspaceRequest;
use App\Http\Requests\StoreWorkspaceRequest;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Models\Team;
use App\Models\User;
use App\Models\Workspace;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class WorkspaceController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('workspace_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workspaces = Workspace::with(['owner', 'team', 'media'])->get();

        $users = User::get();

        $teams = Team::get();

        return view('admin.workspaces.index', compact('teams', 'users', 'workspaces'));
    }

    public function create()
    {
        abort_if(Gate::denies('workspace_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.workspaces.create', compact('owners'));
    }

    public function store(StoreWorkspaceRequest $request)
    {
        $workspace = Workspace::create($request->all());

        if ($request->input('cover', false)) {
            $workspace->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $workspace->id]);
        }

        return redirect()->route('admin.workspaces.index');
    }

    public function edit(Workspace $workspace)
    {
        abort_if(Gate::denies('workspace_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workspace->load('owner', 'team');

        return view('admin.workspaces.edit', compact('owners', 'workspace'));
    }

    public function update(UpdateWorkspaceRequest $request, Workspace $workspace)
    {
        $workspace->update($request->all());

        if ($request->input('cover', false)) {
            if (!$workspace->cover || $request->input('cover') !== $workspace->cover->file_name) {
                if ($workspace->cover) {
                    $workspace->cover->delete();
                }
                $workspace->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
            }
        } elseif ($workspace->cover) {
            $workspace->cover->delete();
        }

        return redirect()->route('admin.workspaces.index');
    }

    public function show(Workspace $workspace)
    {
        abort_if(Gate::denies('workspace_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workspace->load('owner', 'team', 'workspaceFolders', 'fromWorkspaceDocuments');

        return view('admin.workspaces.show', compact('workspace'));
    }

    public function destroy(Workspace $workspace)
    {
        abort_if(Gate::denies('workspace_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workspace->delete();

        return back();
    }

    public function massDestroy(MassDestroyWorkspaceRequest $request)
    {
        Workspace::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('workspace_create') && Gate::denies('workspace_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Workspace();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
