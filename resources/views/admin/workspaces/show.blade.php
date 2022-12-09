@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.workspace.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.workspaces.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.workspace.fields.id') }}
                        </th>
                        <td>
                            {{ $workspace->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.workspace.fields.owner') }}
                        </th>
                        <td>
                            {{ $workspace->owner->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.workspace.fields.workspace_name') }}
                        </th>
                        <td>
                            {{ $workspace->workspace_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.workspace.fields.description') }}
                        </th>
                        <td>
                            {{ $workspace->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.workspace.fields.cover') }}
                        </th>
                        <td>
                            @if($workspace->cover)
                                <a href="{{ $workspace->cover->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $workspace->cover->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.workspaces.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Dossiers
    </div>
    <div class="tab-pane" role="tabpanel" id="workspace_folders">
        @includeIf('admin.workspaces.relationships.workspaceFolders', ['folders' => $workspace->workspaceFolders])
    </div>
</div>

@endsection