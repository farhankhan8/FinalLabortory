@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header"> 
            Patients Detail
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <b> <label for="user_id">MRID</label></b>
                        <p>{{ $patient->id ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Patient Name</label></b>
                        <p>{{ $patient->Pname ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Phone</label></b>
                        <p>{{ $patient->phone ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Email</label></b>
                        <p>{{ $patient->email ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Register Date</label></b>
                        <p>{{ date('d-m-Y H:m:s', strtotime($patient->start_time ?? '')) }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Birthday </label></b>
                        <p>{{ date('d-m-Y', strtotime($patient->dob ?? '')) }}</p>
                    </div>
                    <!-- <div class="col">
                        <b> <label for="user_id">Tests Performed</label></b>
                        <p>{{ $tests ?? '' }}</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Tests Performed By <span>{{ $patient->Pname ?? '' }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="patientTable" class="table table-bordered table-striped table-hover datatable datatable-Event">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Test Category
                        </th>

                        <th>
                            Test Name
                        </th>
                        <!-- <th>
                            Result
                        </th> -->
                        <!-- <th>
                            Range
                        </th> -->
                        <th>
                            Date
                        </th>
                        <th>Charged Amount</th>
                        <th>
                            Status
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allTests as $key => $test)
                        <tr>
                            <td id="{{$test->id}}">

                            </td>
                            <td>
                                {{ $test->Cname  ?? '' }}
                            </td>
                            <td>
                                {{ $test->name  ?? '' }}
                            </td>
                            <td>
                            {{ date('d-m-Y H:m:s', strtotime($test->created_at ?? '')) }}
                            </td>
                            <td>
                            {{ $test->fee}}
                            </td>
                            <td>
                                @php
                                    if($test->type === "urgent") 
                                        $timehour = $test->urgent_timehour;
                                        elseif($test->type === "standard")
                                        $timehour = $test->stander_timehour;
                                @endphp
                                @if ($test->status =='verified')
                                    <button class="btn btn-xs btn-success">Verified</button>
                                    @elseif ((\Carbon\Carbon::now()->timestamp > $timehour + $test->created_at->timestamp) && $test->status == "process")
                                    <button class="btn btn-xs btn-danger">Delayed</button>
                                    @elseif ( $test->status == "process" )
                                    <button class="btn btn-xs btn-info">In Process</button>
                                    @elseif ( $test->status == "cancelled" )
                                    <button class="btn btn-xs btn-info">Cancelled</button>
                                    @else
                                    <button class="btn btn-xs btn-danger">No status</button>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('test-performed-show', $test->id) }}">
                                    Report
                                </a>
                                <a class="btn btn-xs btn-primary" href="{{ route('test-performed-table', $test->id) }}">
                                        {{ trans('global.view') }}
                                </a>
                                @if(auth::check() && Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                <a class="btn btn-xs btn-info" href="{{ route('test-performed-edit', $test->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                @endif

                                <form method="POST" action="{{ route("performed-test-delete", [$test->id]) }}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <form class="d-none" id="report" method="post" action="{{route("patient-view-multiple-report")}}">
                    @csrf
                    <div id="form_block">

                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>

        function searchTable()
        {
            console.log("search funtion");
            // Setup - add a text input to each footer cell
            $('#patientTable thead tr').clone(true).appendTo( '#patientTable thead' );

            $('#patientTable thead tr:eq(1) th').each( function (i) {
                if(i==1 || i==2 || i==3){
                var title = $(this).text();
                console.log(i);
                $(this).html( '<input type="text" placeholder="Search" />' );
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table.column(i).search( this.value ).draw();
                    }
                });
                }else{
                $(this).html( '' );
                }
            });
            
        }

        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
                    
            let reportBtn = {
                text: "Report",
                url: "{{ route('patient-view-multiple-report') }}",
                className: 'btn-primary',
                action: function (e, dt, node, config) {
                    document.getElementById("form_block").innerHTML = "";
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        console.log(entry)
                        $(document.getElementById("form_block")).append("<input type=\"text\" name=\"report_ids[]\" value=\"" + $(entry)[0].cells[0].id + "\">");
                        return $(entry)[0].cells[0].id;
                    });

                    console.log(ids);

                    if (ids.length === 0) {
                        alert('No record selected');
                        return
                    }
                    document.getElementById("report").submit();
                }
            };
            dtButtons.push(reportBtn);
            

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 100,
            });

            searchTable();

            table = $('#patientTable').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                buttons: dtButtons
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection