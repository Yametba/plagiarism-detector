@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.analysisItem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.analysis-items.show', $analysisItem->id) }}">
                    {{ trans('Retour') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.analysisItem.fields.id') }}
                        </th>
                        <td>
                            {{ $analysisItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analysisItem.fields.analysis_results') }}
                        </th>
                        <td>
                            {{-- $analysisItem->analysis_results --}}
                            @include('admin.analysisItems._analisis_results_with_details', [
                                'analysisItem' => $analysisItem
                            ])
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analysisItem.fields.last_analysis_date') }}
                        </th>
                        <td>
                            {{ $analysisItem->last_analysis_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analysisItem.fields.comments') }}
                        </th>
                        <td>
                            {{ $analysisItem->comments }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analysisItem.fields.submitter_email') }}
                        </th>
                        <td>
                            {{ $analysisItem->submitter_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analysisItem.fields.folder') }}
                        </th>
                        <td>
                            @if($analysisItem->document->file)
                                <a href="{{ $analysisItem->document->getFilePath() }}" target="_blank">
                                    {{ $analysisItem->folder->name ?? '' }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analysisItem.fields.document') }}
                        </th>
                        <td>
                            {{ $analysisItem->document->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analysisItem.fields.submitter_fullname') }}
                        </th>
                        <td>
                            {{ $analysisItem->submitter_fullname }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.analysis-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection