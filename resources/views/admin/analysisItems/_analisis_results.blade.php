<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nouveau Document</th>
        <th scope="col">Document Plagié</th>
        <th scope="col">Score de plagiat</th>
        <th scope="col">Source Plagiat</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($analysisItem->getAnalysisResultsSimilarSentencesArray() as $index => $item)
        <tr>
            <th scope="row">{{$index}}</th>
            <td>{{$item[0]}}</td>
            <td>{{$item[1]}}</td>
            <td>{{$item[2]}}</td>
            <td>
                <a href="{{ get_file_path_from_database($item[4])}}" target="_blank">{{basename($item[4])}}</a>
            </td>
          </tr>
        @endforeach
    </tbody>
  </table>