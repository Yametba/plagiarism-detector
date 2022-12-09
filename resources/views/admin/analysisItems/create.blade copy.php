@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.analysisItem.title_singular') }}
        Dans {{$folder->name}}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.analysis-items.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="analysis_results">{{ trans('cruds.analysisItem.fields.analysis_results') }}</label>
                <textarea class="form-control {{ $errors->has('analysis_results') ? 'is-invalid' : '' }}" name="analysis_results" id="analysis_results">{{ old('analysis_results') }}</textarea>
                @if($errors->has('analysis_results'))
                    <div class="invalid-feedback">
                        {{ $errors->first('analysis_results') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.analysisItem.fields.analysis_results_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_analysis_date">{{ trans('cruds.analysisItem.fields.last_analysis_date') }}</label>
                <input class="form-control datetime {{ $errors->has('last_analysis_date') ? 'is-invalid' : '' }}" type="text" name="last_analysis_date" id="last_analysis_date" value="{{ old('last_analysis_date') }}">
                @if($errors->has('last_analysis_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('last_analysis_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.analysisItem.fields.last_analysis_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.analysisItem.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments') }}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.analysisItem.fields.comments_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitter_email">{{ trans('cruds.analysisItem.fields.submitter_email') }}</label>
                <input class="form-control {{ $errors->has('submitter_email') ? 'is-invalid' : '' }}" type="email" name="submitter_email" id="submitter_email" value="{{ old('submitter_email') }}">
                @if($errors->has('submitter_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('submitter_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.analysisItem.fields.submitter_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="folder_id">{{ trans('cruds.analysisItem.fields.folder') }}</label>
                <select class="form-control select2 {{ $errors->has('folder') ? 'is-invalid' : '' }}" name="folder_id" id="folder_id" required>
                    @foreach($folders as $id => $entry)
                        <option value="{{ $id }}" {{ old('folder_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('folder'))
                    <div class="invalid-feedback">
                        {{ $errors->first('folder') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.analysisItem.fields.folder_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="document_id">{{ trans('cruds.analysisItem.fields.document') }}</label>
                <select class="form-control select2 {{ $errors->has('document') ? 'is-invalid' : '' }}" name="document_id" id="document_id">
                    @foreach($documents as $id => $entry)
                        <option value="{{ $id }}" {{ old('document_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('document'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.analysisItem.fields.document_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitter_fullname">{{ trans('cruds.analysisItem.fields.submitter_fullname') }}</label>
                <input class="form-control {{ $errors->has('submitter_fullname') ? 'is-invalid' : '' }}" type="text" name="submitter_fullname" id="submitter_fullname" value="{{ old('submitter_fullname', '') }}">
                @if($errors->has('submitter_fullname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('submitter_fullname') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.analysisItem.fields.submitter_fullname_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection