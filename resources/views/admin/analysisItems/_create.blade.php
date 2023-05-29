<div>
    <form method="POST" action="{{ route("admin.store-new-analysis-item") }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="folder_id" value="{{$folder->id}}">

        <div class="row">
            <div class="col-6">
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
            </div>
    
            <div class="col-6">
                
                {{--<label for="">Fichier(s) d'analyse</label>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="original_file" name="original_file">
                        <label class="custom-file-label" for="original_file">Choisir le fichier à analyser</label>
                    </div>
                </div>--}}
                <div class="form-group">
                    <label for="original_file">Fichier à analyser</label>
                    <div class="needsclick dropzone {{ $errors->has('original_file') ? 'is-invalid' : '' }}" id="original_file-dropzone">
                    </div>
                    @if($errors->has('original_file'))
                        <div class="invalid-feedback">
                            {{ $errors->first('original_file') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.document.fields.file_helper') }}</span>
                </div>
                <div class="form-group">
                    <h6>Comparer le document avec:</h6>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="comparison_options" id="comparison_options_1" value="WITH_ALL">
                        <label class="form-check-label" for="inlineRadio1">Tous les documents de la base de données</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="comparison_options" id="comparison_options_2" value="WITH_SINGLE">
                        <label class="form-check-label" for="inlineRadio2">Avec un seul document</label>
                    </div>
                </div>
                {{--<div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="rewritten_file" name="rewritten_file">
                        <label class="custom-file-label" for="rewritten_file">Choisir le fichier de comparaison</label>
                    </div>
                </div>--}}

                <div class="form-group">
                    <label for="rewritten_file">Fichier de comparaison</label>
                    <div class="needsclick dropzone {{ $errors->has('rewritten_file') ? 'is-invalid' : '' }}" id="rewritten_file-dropzone">
                    </div>
                    @if($errors->has('rewritten_file'))
                        <div class="invalid-feedback">
                            {{ $errors->first('rewritten_file') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.document.fields.file_helper') }}</span>
                </div>
                {{--<div class="form-group">
                    <label for="file">{{ trans('cruds.document.fields.file') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                    </div>
                    @if($errors->has('file'))
                        <div class="invalid-feedback">
                            {{ $errors->first('file') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.document.fields.file_helper') }}</span>
                </div>--}}
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-danger" type="submit">
                Enregistrer et lancer l'annalyse
            </button>
        </div>
    </form>
</div>

