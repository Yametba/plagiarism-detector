@can('folder_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.folders.create') }}">
                Nouveau
            </a>
        </div>
    </div>
@endcan

<div class="col-12">
    <div class="row">
        @foreach($folders as $key => $folder)
                {{--<div class="col-3 workspace-folder" style="margin: 5px; background-color:rgb(207, 207, 207); height:50px">
                    {{$folder->name}}
                </div>--}}
                <div class="col-4">
                <a href="{{route('admin.folders.show', $folder)}}">

                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-2" style="margin-left: 5px">
                            @if($folder->cover)
                                <a href="{{ $folder->cover->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $folder->cover->getUrl('thumb') }}" width="60">
                                </a>
                            @else
                                <img src="{{asset('img/folder1.png')}}" alt="..." width="60">
                            @endif
                            </div>
                            <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title text-truncate font-weight-bold" style="font-size: 12px">{{$folder->name}}</h5>
                                {{--<p class="card-text">{{$folder->description}}</p>--}}
                                {{--<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>--}}
                            </div>
                            </div>
                        </div>
                        </div>
                </a>
                </div>

        @endforeach
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('folder_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.folders.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-workspaceFolders:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection