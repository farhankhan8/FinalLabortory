@extends('layouts.admin')
    @section('content')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("catagory-create") }}">
                Add New Category
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Catagory
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                        <thead>
                            <tr>
                                <th width="10">
                                </th>
                                <th>
                                Id
                                </th>
                                <th>
                                Category 
                                </th>
                                <th>
                                Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categoryes as $key => $category)
                                <tr data-entry-id="{{ $category->id }}">
                                    <td>
                                    </td>
                                    <td>
                                    {{ $category->id ?? '' }}
                                    </td>
                                    <td>
                                    {{ $category->Cname ?? '' }}
                                    </td>  
                                    <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('catagory-show', $category->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                    <a class="btn btn-xs btn-info" href="{{ route('catagory-edit', $category->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                            

                                    <form  method="POST" action="{{ route("catagory-delete", [$category->id]) }}" onsubmit="return confirm('{{ trans('Are You Sure to Deleted  ?') }}');"  style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('event_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.events.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Event:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection