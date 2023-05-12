@if (empty($analysisItem->getAnalysisResultsSimilarSentencesArray()))
    {{$analysisItem->analysis_results}}
    @if(empty($analysisItem->analysis_results))
      En Cours de traitement
    @endif
@else

  <h3>
    Score de plagiat total : {{$analysisItem->getPlagiarismScore()}}
  </h3>

  <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nouveau Document</th>
          <th scope="col">Document Plagié</th>
          <th scope="col">Score de plagiat</th>
          <th scope="col">Détails</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($analysisItem->getAnalysisResultsGroupedByDoc() as $index => $item)
          <tr>
            <th scope="row">{{$index}}</th>
            <td><a href="{{ get_file_path_from_database($item[1])}}" target="_blank">{{basename($item[0])}}</a></td>
            <td><a href="{{ get_file_path_from_database($item[1])}}" target="_blank">{{basename($item[1])}}</a></td>
            <td>{{$item[2]}}</td>
            <td>
              <a class="btn btn-xs btn-primary" href="{{ route('admin.analysis-items.show-with-details', $analysisItem->id) }}">
                {{ trans('global.view') }}
              </a>
            </td>
          </tr>
          @endforeach
      </tbody>
    </table>
  @endif