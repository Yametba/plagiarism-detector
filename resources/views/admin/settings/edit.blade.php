@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.setting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settings.update", [$setting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="default_plagiarism_threshold_allowed">{{ trans('cruds.setting.fields.default_plagiarism_threshold_allowed') }}</label>
                <input class="form-control {{ $errors->has('default_plagiarism_threshold_allowed') ? 'is-invalid' : '' }}" type="number" name="default_plagiarism_threshold_allowed" id="default_plagiarism_threshold_allowed" value="{{ old('default_plagiarism_threshold_allowed', $setting->default_plagiarism_threshold_allowed) }}" step="1" required>
                @if($errors->has('default_plagiarism_threshold_allowed'))
                    <div class="invalid-feedback">
                        {{ $errors->first('default_plagiarism_threshold_allowed') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.default_plagiarism_threshold_allowed_helper') }}</span>
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