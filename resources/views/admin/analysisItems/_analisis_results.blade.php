@if (empty($analysisItem->getAnalysisResultsSimilarSentencesArray()))
    {{$analysisItem->analysis_results}}
    @if(empty($analysisItem->analysis_results))
      En Cours de traitement
    @endif
@else

  <div class="row">
    <div class="col-8">
      <h3>
        Score de plagiat total : {{$analysisItem->getPlagiarismScore()}} 
      </h3>
    </div>
    <div class="col-4">
      <a class="btn btn-xs btn-success" href="{{ route('admin.analysis-items.show-with-details', $analysisItem->id) }}">
        Voir les détails
      </a>
    </div>
  </div>
  <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          {{--<th scope="col">Document d'analyse</th>--}}
          <th scope="col">Document(s) de correspondance trouvé(s):</th>
          <th scope="col">Score de plagiat</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($analysisItem->getAnalysisResultsGroupedByDoc() as $index => $item)
          <tr>
            <th scope="row">{{$index}}</th>
            {{--<td><a href="{{ get_file_path_from_database($item[1])}}" target="_blank">{{basename($item[0])}}</a></td>--}}
            <td><a href="{{ get_file_path_from_database($item[1])}}" target="_blank">{{basename($item[1])}}</a></td>
            <td>{{$item[2]}}</td>
          </tr>
          @endforeach
      </tbody>
    </table>
  @endif