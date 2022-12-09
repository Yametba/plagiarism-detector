@extends('layouts.admin')
@section('content')

<div class="card">
    <h3 style="margin-left:25px; margin-bottom: 10px; margin-top:10px">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
            <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
            <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
        </svg>
        Espace de travail de <span>{{ $workspace->owner->name }}</span>
    </h3>
</div>

<div class="card">
    <div class="row" style="margin-left: 15px!important;margin-right: 15px!important;margin-top: 15px!important;">
        Dossiers
    </div>
    <div class="row" id="workspace_folders" style="margin-left: 15px!important;margin-right: 15px!important;margin-top: 15px!important;">
        @includeIf('admin.workspaces.relationships.workspaceFolders', ['folders' => $workspace->workspaceFolders])
    </div>
</div>


{{--
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
--}}
@endsection