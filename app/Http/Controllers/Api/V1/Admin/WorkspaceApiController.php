<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWorkspaceRequest;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Http\Resources\Admin\WorkspaceResource;
use App\Models\Workspace;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkspaceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('workspace_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WorkspaceResource(Workspace::with(['owner', 'team'])->get());
    }

    public function store(StoreWorkspaceRequest $request)
    {
        $workspace = Workspace::create($request->all());

        if ($request->input('cover', false)) {
            $workspace->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
        }

        return (new WorkspaceResource($workspace))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Workspace $workspace)
    {
        abort_if(Gate::denies('workspace_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WorkspaceResource($workspace->load(['owner', 'team']));
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

        return (new WorkspaceResource($workspace))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Workspace $workspace)
    {
        abort_if(Gate::denies('workspace_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $workspace->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
