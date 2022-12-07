@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.folder.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.folders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.id') }}
                        </th>
                        <td>
                            {{ $folder->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.name') }}
                        </th>
                        <td>
                            {{ $folder->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.description') }}
                        </th>
                        <td>
                            {{ $folder->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.cover') }}
                        </th>
                        <td>
                            @if($folder->cover)
                                <a href="{{ $folder->cover->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $folder->cover->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.workspace') }}
                        </th>
                        <td>
                            {{ $folder->workspace->workspace_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.plagiarism_threshold_allowed') }}
                        </th>
                        <td>
                            {{ $folder->plagiarism_threshold_allowed }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.automatic_analysis') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $folder->automatic_analysis ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.allowed_public_access') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $folder->allowed_public_access ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.allowed_users') }}
                        </th>
                        <td>
                            {{ $folder->allowed_users }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.comments') }}
                        </th>
                        <td>
                            {{ $folder->comments }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.submitter_email') }}
                        </th>
                        <td>
                            {{ $folder->submitter_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.folder.fields.submitter_fullname') }}
                        </th>
                        <td>
                            {{ $folder->submitter_fullname }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.folders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#folder_analysis_items" role="tab" data-toggle="tab">
                {{ trans('cruds.analysisItem.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="folder_analysis_items">
            @includeIf('admin.folders.relationships.folderAnalysisItems', ['analysisItems' => $folder->folderAnalysisItems])
        </div>
    </div>
</div>

@endsection