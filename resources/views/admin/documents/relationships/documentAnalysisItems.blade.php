@can('analysis_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.analysis-items.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.analysisItem.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.analysisItem.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-documentAnalysisItems">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.analysisItem.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.analysisItem.fields.analysis_results') }}
                        </th>
                        <th>
                            {{ trans('cruds.analysisItem.fields.last_analysis_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.analysisItem.fields.comments') }}
                        </th>
                        <th>
                            {{ trans('cruds.analysisItem.fields.submitter_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.analysisItem.fields.folder') }}
                        </th>
                        <th>
                            {{ trans('cruds.analysisItem.fields.document') }}
                        </th>
                        <th>
                            {{ trans('cruds.analysisItem.fields.submitter_fullname') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($analysisItems as $key => $analysisItem)
                        <tr data-entry-id="{{ $analysisItem->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $analysisItem->id ?? '' }}
                            </td>
                            <td>
                                {{ $analysisItem->analysis_results ?? '' }}
                            </td>
                            <td>
                                {{ $analysisItem->last_analysis_date ?? '' }}
                            </td>
                            <td>
                                {{ $analysisItem->comments ?? '' }}
                            </td>
                            <td>
                                {{ $analysisItem->submitter_email ?? '' }}
                            </td>
                            <td>
                                {{ $analysisItem->folder->name ?? '' }}
                            </td>
                            <td>
                                {{ $analysisItem->document->title ?? '' }}
                            </td>
                            <td>
                                {{ $analysisItem->submitter_fullname ?? '' }}
                            </td>
                            <td>
                                @can('analysis_item_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.analysis-items.show', $analysisItem->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('analysis_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.analysis-items.edit', $analysisItem->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('analysis_item_delete')
                                    <form action="{{ route('admin.analysis-items.destroy', $analysisItem->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('analysis_item_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.analysis-items.massDestroy') }}",
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
  let table = $('.datatable-documentAnalysisItems:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection