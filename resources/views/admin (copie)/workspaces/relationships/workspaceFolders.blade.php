@can('folder_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.folders.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.folder.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.folder.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-workspaceFolders">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.cover') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.workspace') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.plagiarism_threshold_allowed') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.automatic_analysis') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.allowed_public_access') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.allowed_users') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.comments') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.submitter_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.submitter_fullname') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($folders as $key => $folder)
                        <tr data-entry-id="{{ $folder->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $folder->id ?? '' }}
                            </td>
                            <td>
                                {{ $folder->name ?? '' }}
                            </td>
                            <td>
                                {{ $folder->description ?? '' }}
                            </td>
                            <td>
                                @if($folder->cover)
                                    <a href="{{ $folder->cover->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $folder->cover->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $folder->workspace->workspace_name ?? '' }}
                            </td>
                            <td>
                                {{ $folder->plagiarism_threshold_allowed ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $folder->automatic_analysis ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $folder->automatic_analysis ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $folder->allowed_public_access ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $folder->allowed_public_access ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $folder->allowed_users ?? '' }}
                            </td>
                            <td>
                                {{ $folder->comments ?? '' }}
                            </td>
                            <td>
                                {{ $folder->submitter_email ?? '' }}
                            </td>
                            <td>
                                {{ $folder->submitter_fullname ?? '' }}
                            </td>
                            <td>
                                @can('folder_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.folders.show', $folder->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('folder_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.folders.edit', $folder->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('folder_delete')
                                    <form action="{{ route('admin.folders.destroy', $folder->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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