@extends('layouts.admin1')
  @section('content')
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              Dashboard
            </div>
            <div class="container-fluid">
              <div class="row mt-2 widgets">
                <div class="col-xl-3 col-sm-6 py-2">
                  <div class="card card-1 text-white h-100">
                    <div style="background-color:rgb(0,200,255);" class="card-body card-1">
                      <div class="rotate">
                        <i class="fa fa-hospital-o" style="font-size:36px;"></i>
                      </div>
                      <h5 class="mb-5">Today Sales</h5>
                      <h3 class="amount-position">Rs{{ $todaySales }}</h3>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 py-2">
                  <div class="card card-1 text-white h-100">
                    <div style="background-color:rgb(50,150,255);" class="card-body card-1">
                      <div class="rotate">
                        <i class="fa fa-user-md" style="font-size:36px;"></i>
                      </div>
                      <h5 class="mb-5">Weekly  Sales</h5>
                      <h3 class="amount-position">Rs{{ $thisWeekSeles }}</h3>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 py-2">
                  <div class="card card-1 text-white h-100">
                    <div  style="background-color:rgb(200,150,255);" class="card-body card-1">
                      <div class="rotate">
                        <i class="fa fa-stethoscope" style="font-size:36px;"></i>
                      </div>
                      <h5 class="mb-5">Monthly Sales</h5>
                      <h3 class="amount-position">Rs{{ $thisMongthSales }}</h3>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 py-2">
                  <div class="card card-1 text-white h-100">
                    <div  style="background-color:rgb(200,50,90);;" class="card-body card-1">    
                      <div class="rotate">
                        <i class="fa fa-wheelchair" style="font-size:48px;color:red"></i>
                      </div>
                      <h5 class="mb-5">Yearly Sales</h5>
                      <h3>Rs{{ $thisYearSales }}</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <style>
              * {
                  box-sizing: border-box;
                }

              .row {
                      margin-left:-5px;
                      margin-right:-5px;
                    }
  
              .column {
                        float: left;
                        width: 50%;
                        padding: 5px;
                        }
                        .colum {
                        float: left;
                        width: 100%;
                        padding: 50px;
                        }

                        /* Clearfix (clear floats) */
              .row::after {
                        content: "";
                        clear: both;
                        display: table;
                      }

                table {
                        border-collapse: collapse;
                        border-spacing: 0;
                        width: 100%;
                        border: 1px solid #ddd;
                      }

                th, td {
                        text-align: left;
                        padding: 16px;
                      }

                tr:nth-child(even) {
                        background-color: #f2f2f2;
                      }
            </style>
            <div class="card-body">
              <div class="table-responsive">
                <div class="row">
                  <div class="column">
                  <span style="text-align: left;"><h2>Sales Per Day</h2></span>  
                    <table class="table table-bordered table-striped table-hover datatable datatable-Event">
                      <thead>
                      <tr>
                      <th>Date</th>
                      <th>Sales</th>
                    </tr>
                      </thead>
                      <tbody>
                    <tr>
                      <td>{{ date('d-m-Y', strtotime($beforeTwoDaySales ?? '')) }}</td>
                      <td>{{ $previousTwoDaySales ?? '' }}</td>
                    </tr>
                    <tr>
                      <td>{{ date('d-m-Y', strtotime($todayDate ?? '')) }}</td>
                      <td>{{ $todaySalesForTable ?? '' }}</td>
                    </tr>
                    <tr>
                      <td>{{ date('d-m-Y', strtotime($yesterDay ?? '')) }}</td>
                      <td>{{ $yesterDaySum ?? '' }}</td>
                    </tr>
                    <tr>
                      <td>{{ date('d-m-Y', strtotime($beforeThreeDaySales ?? '')) }}</td>
                      <td>{{ $previousDaySales ?? '' }}</td>
                    </tr>
                  </tbody>
                    </table>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover datatable datatable-Event">
                        <span style="text-align: left;"><h2>Test Wise Sales in 7 Days</h2></span>  
                          <thead>
                          <tr>
                      <th>Test Name</th>
                      <th>Sales</th>
                    </tr>
                          </thead>
                          <tbody>
                    @foreach($salesForSenvenDays as $key => $todaySalesDispla)
                      <tr>
                        <td>{{ $todaySalesDispla->name }}</td>
                        <td>{{ $todaySalesDispla->test_performed_sum_fee }}</td>
                      </tr>
                    @endforeach
                  </tbody> 
                        </table>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="column">
                  <span style="text-align: left;"><h2>Test Wise Sales in 30 Days</h2></span>  
                    <table class="table table-bordered table-striped table-hover datatable datatable-Event">
                      <thead>
                      <tr>
                      <th>Test Name</th>
                      <th>Sales</th>
                    </tr>
                      </thead> 
                      <tbody>
                    @foreach($salesForThirtyDays as $key => $salesForThirtyDay)
                      <tr>
                        <td>{{ $salesForThirtyDay->name }}</td>
                        <td>{{ $salesForThirtyDay->test_performed_sum_fee }}</td>
                      </tr>
                    @endforeach
                  </tbody> 
                    </table>
                  </div>
                </div>  
              </div>
            </div>
          </div>
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