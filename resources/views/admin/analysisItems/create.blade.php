@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Ajout de document dans {{$folder->name}}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.analysis-items.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="folder_id" value="{{$folder->id}}">

            <div class="form-group">
                <label for="title">{{ trans('cruds.document.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.document.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitter_email">{{ trans('cruds.analysisItem.fields.submitter_email') }}</label>
                <input class="form-control {{ $errors->has('submitter_email') ? 'is-invalid' : '' }}" type="email" name="submitter_email" id="submitter_email" value="{{ old('submitter_email') ?? $authUser->email }}" required>
                @if($errors->has('submitter_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('submitter_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.analysisItem.fields.submitter_email_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="submitter_fullname">{{ trans('cruds.analysisItem.fields.submitter_fullname') }}</label>
                <input class="form-control {{ $errors->has('submitter_fullname') ? 'is-invalid' : '' }}" type="text" name="submitter_fullname" id="submitter_fullname" value="{{ old('submitter_fullname', '') ?? $authUser->name }}" required>
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

@section('scripts')
<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('admin.documents.storeMedia') }}',
    maxFilesize: 10, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').find('input[name="file"]').remove()
      $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($document) && $document->file)
      var file = {!! json_encode($document->file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
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