@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.folder.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.folders.update", [$folder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.folder.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $folder->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.folder.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $folder->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cover">{{ trans('cruds.folder.fields.cover') }}</label>
                <div class="needsclick dropzone {{ $errors->has('cover') ? 'is-invalid' : '' }}" id="cover-dropzone">
                </div>
                @if($errors->has('cover'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cover') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.cover_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="workspace_id">{{ trans('cruds.folder.fields.workspace') }}</label>
                <select class="form-control select2 {{ $errors->has('workspace') ? 'is-invalid' : '' }}" name="workspace_id" id="workspace_id" required>
                    @foreach($workspaces as $id => $entry)
                        <option value="{{ $id }}" {{ (old('workspace_id') ? old('workspace_id') : $folder->workspace->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('workspace'))
                    <div class="invalid-feedback">
                        {{ $errors->first('workspace') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.workspace_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="plagiarism_threshold_allowed">{{ trans('cruds.folder.fields.plagiarism_threshold_allowed') }}</label>
                <input class="form-control {{ $errors->has('plagiarism_threshold_allowed') ? 'is-invalid' : '' }}" type="number" name="plagiarism_threshold_allowed" id="plagiarism_threshold_allowed" value="{{ old('plagiarism_threshold_allowed', $folder->plagiarism_threshold_allowed) }}" step="1">
                @if($errors->has('plagiarism_threshold_allowed'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plagiarism_threshold_allowed') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.plagiarism_threshold_allowed_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('automatic_analysis') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="automatic_analysis" value="0">
                    <input class="form-check-input" type="checkbox" name="automatic_analysis" id="automatic_analysis" value="1" {{ $folder->automatic_analysis || old('automatic_analysis', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="automatic_analysis">{{ trans('cruds.folder.fields.automatic_analysis') }}</label>
                </div>
                @if($errors->has('automatic_analysis'))
                    <div class="invalid-feedback">
                        {{ $errors->first('automatic_analysis') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.automatic_analysis_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('allowed_public_access') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="allowed_public_access" value="0">
                    <input class="form-check-input" type="checkbox" name="allowed_public_access" id="allowed_public_access" value="1" {{ $folder->allowed_public_access || old('allowed_public_access', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="allowed_public_access">{{ trans('cruds.folder.fields.allowed_public_access') }}</label>
                </div>
                @if($errors->has('allowed_public_access'))
                    <div class="invalid-feedback">
                        {{ $errors->first('allowed_public_access') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.allowed_public_access_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="allowed_users">{{ trans('cruds.folder.fields.allowed_users') }}</label>
                <textarea class="form-control {{ $errors->has('allowed_users') ? 'is-invalid' : '' }}" name="allowed_users" id="allowed_users">{{ old('allowed_users', $folder->allowed_users) }}</textarea>
                @if($errors->has('allowed_users'))
                    <div class="invalid-feedback">
                        {{ $errors->first('allowed_users') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.allowed_users_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.folder.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments', $folder->comments) }}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.comments_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="submitter_email">{{ trans('cruds.folder.fields.submitter_email') }}</label>
                <input class="form-control {{ $errors->has('submitter_email') ? 'is-invalid' : '' }}" type="email" name="submitter_email" id="submitter_email" value="{{ old('submitter_email', $folder->submitter_email) }}" required>
                @if($errors->has('submitter_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('submitter_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.submitter_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitter_fullname">{{ trans('cruds.folder.fields.submitter_fullname') }}</label>
                <input class="form-control {{ $errors->has('submitter_fullname') ? 'is-invalid' : '' }}" type="text" name="submitter_fullname" id="submitter_fullname" value="{{ old('submitter_fullname', $folder->submitter_fullname) }}">
                @if($errors->has('submitter_fullname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('submitter_fullname') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.folder.fields.submitter_fullname_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.coverDropzone = {
    url: '{{ route('admin.folders.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="cover"]').remove()
      $('form').append('<input type="hidden" name="cover" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="cover"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($folder) && $folder->cover)
      var file = {!! json_encode($folder->cover) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="cover" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection