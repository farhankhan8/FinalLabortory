@extends('layouts.admin')
  @section('content')
    <div class="card">
      <div class="card-header">
      Patients Category Detail
      </div>
      <div class="card-body">
        <div class="form-group">
         <div class="row">
            <div class="col">
            <b> <label  for="user_id">Patient Category</label></b>
            <p>{{  $patientCategory->Pcategory ?? '' }}</p>
            </div>
            <div class="col">
              <b> <label  for="user_id">Discount</label></b>
              <p> {{ $patientCategory->discount ?? '' }}</p>
            </div>
             
          </div>     
        </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
            Patients In<p>{{  $patientCategory->Pcategory ?? '' }}</p>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                        Patient Name
                        </th>
                        <th>
                        Phone
                        </th>
                        <th>
                        Email
                        </th>
                        <th>
                        Birthday
                        </th>
                        <th>
                          Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($getAllPatientsInCategorys as $key => $testPerformed)
                        <tr>
                            <td>

                            </td>
                            <td>
                            {{ $testPerformed->Pname ?? '' }}
                            </td>
                            <td>
                            {{ $testPerformed->phone ?? '' }}
                            </td>
                            <td>
                            {{ $testPerformed->email ?? '' }}
                            </td>
                            <td>
                            {{ $testPerformed->dob ?? '' }}
                            </td>
                         
                            <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('patient-show', $testPerformed->id) }}">
                                        {{ trans('global.view') }}
                                    </a>

                                    <a class="btn btn-xs btn-info" href="{{ route('patient-edit', $testPerformed->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form  method="POST" action="{{ route("patient-delete", [$testPerformed->id]) }}" onsubmit="return confirm('{{ trans('Are You Sure to Deleted  ?') }}');"  style="display: inline-block;">
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

