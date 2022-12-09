@extends('layouts.admin')
@section('content')

<div class="card">
    <h3 style="margin-left:25px; margin-bottom: 10px; margin-top:10px"> 
        <i class="fa-fw fas fa-folder"></i> 
        Dossier: {{$folder->name}} 
    </h3>
</div>

<div class="card">
    <div class="row" id="workspace_folders" style="margin-left: 15px!important;margin-right: 15px!important;margin-top: 15px!important;">
        @includeIf('admin.folders.relationships.folderAnalysisItems', ['analysisItems' => $folder->folderAnalysisItems])
    </div>
</div>

@endsection