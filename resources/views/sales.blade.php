@extends('layouts.admin1')
  @section('content')
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card lab-container">
            <div class="card-header">
              Dashboard 
            </div>
            <div class="container-fluid">
              <div class="row mt-2 mb-4 widgets">
                <div class="col-md-3 col-sm-6 py-2">
                  <div class="card card-1 text-white h-100">
                    <div style="background-color:rgb(0,200,255);" class="card-body card-1">
                      
                      <i class="mr-2 fa fa-hospital-o" style="font-size:36px;"></i>
                      
                      <h5 class="mb-3 d-inline-block">Today Sales</h5>
                      <h3 class="amount-position">Rs {{ $todaySales }}</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 py-2">
                  <div class="card card-1 text-white h-100">
                    <div style="background-color:rgb(50,150,255);" class="card-body card-1">
                      
                      <i class="mr-2 fa fa-user-md" style="font-size:36px;"></i>
                      
                      <h5 class="mb-3 d-inline-block">Weekly  Sales</h5>
                      <h3 class="amount-position">Rs {{ $thisWeekSeles }}</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 py-2">
                  <div class="card card-1 text-white h-100">
                    <div  style="background-color:rgb(200,150,255);" class="card-body card-1">
                      
                      <i class="mr-2 fa fa-stethoscope" style="font-size:36px;"></i>
                      
                      <h5 class="mb-3 d-inline-block">Monthly Sales</h5>
                      <h3 class="amount-position">Rs {{ $thisMongthSales }}</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 py-2">
                  <div class="card card-1 text-white h-100">
                    <div  style="background-color:rgb(200,50,90);;" class="card-body card-1">    
                      
                      <i class="mr-2 fa fa-wheelchair" style="font-size:36px;"></i>
                      
                      <h5 class="mb-3 d-inline-block">Yearly Sales</h5>
                      <h3>Rs {{ $thisYearSales }}</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="container-fluid mb-4">
              
                <div class="row">
                  <div class="col-md-6">
                    <h2>Sales Per Day</h2>
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
                  <div class="col-md-6">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-hover datatable datatable-Event">
                        <h2>Test Wise Sales in 7 Days</h2>
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
                  <div class="col-md-6">
                    <h2>Test Wise Sales in 30 Days</h2>
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
@endsection
@section('scripts')
@parent
<script>
    $(function () {
      
      $('.datatable-Event:not(.ajaxTable)').DataTable({
          "paging":   false,
          "info":     false
      })

      $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
      });
    })

</script>
@endsection




