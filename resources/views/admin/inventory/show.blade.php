
@extends('layouts.admin')
  @section('content')
    <div class="card">
        <div class="card-header">
              Inventory  Detail
        </div>

        <div class="card-body">
            <div class="form-group">
               <div class="row">
                <div class="col">
                 <b> <label  for="user_id">Inventory Name</label></b>
                 <p>{{  $inventory->inventoryName ?? '' }}</p>
                 </div>
               <div class="col">
                <b> <label  for="user_id">Inventory Units</label></b>
                <p> {{ $inventory->inventoryUnit ?? '' }}</p>
                </div>
                <div class="col">
                  <b> <label  for="user_id">Remaining Quantity</label></b>
                  <p> {{ $inventory->remainingItem ?? '' }}</p>
                </div>

  
          </div>
            <a class="btn btn-primary" href="{{ route('inventory-list') }}">
              <button type="submit" class="btn btn-primary">Back</button>
            </a>
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