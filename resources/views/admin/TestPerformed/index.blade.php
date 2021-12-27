@extends('layouts.admin')
    @section('content')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("create") }}">
                  Performed New Test
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                List of Performed Tests
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="performedTable" class="table table-bordered table-striped table-hover datatable datatable-Event">
                    <thead>
                        <tr>
                            <th width="10">
                            </th>
                            <th>
                            Id
                            </th>
                            <th>
                            Test Catagory
                            </th>
                            <th>
                            Test Name
                            </th>
                            <th>
                            Patient Name
                            </th>
                            <th>
                            Specimen
                            </th>
                            <th>
                            Referred By
                            </th>
                            <th>
                            Test Created
                            </th>
                            <th>
                            Status
                            </th>
                            <th>
                            Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testPerformeds as $key => $testPerformed)
                            <tr data-entry-id="{{ $testPerformed->id }}">
                                <td id="{{$testPerformed->id}}">

                                </td>
                                <td>
                                {{ $testPerformed->id ?? '' }}
                                </td>
                                <td>
                                {{ $testPerformed->Cname }}
                                </td>
                                <td>
                                {{ $testPerformed->name }}
                                </td>
                                <td>
                                {{ $testPerformed->Pname }}
                                </td>
                                <td>
                                    {{ $testPerformed->specimen }}
                                </td>
                                <td>
                                {{ $testPerformed->referred }}
                                </td>
                                <td>
                                {{ date('d-m-Y H:m:s', strtotime($testPerformed->created_at)) }}
                                </td>
                                <td>
                                @php
                                    if($testPerformed->type === "urgent") 
                                        $timehour = $testPerformed->availableTest->urgent_timehour;
                                        elseif($testPerformed->type === "standard")
                                        $timehour = $testPerformed->availableTest->stander_timehour;
                                @endphp
                                @if ($testPerformed->status =='verified')
                                    <button class="btn btn-xs btn-success">Verified</button>
                                    @elseif ((\Carbon\Carbon::now()->timestamp > $timehour + $testPerformed->created_at->timestamp) && $testPerformed->status == "process")
                                    <button class="btn btn-xs btn-danger">Delayed</button>
                                    @elseif ( $testPerformed->status == "process" )
                                    <button class="btn btn-xs btn-info">In Process</button>
                                    @elseif ( $testPerformed->status == "cancelled" )
                                    <button class="btn btn-xs btn-info">Cancelled</button>
                                    @else
                                    <button class="btn btn-xs btn-danger">No status</button>
                                @endif
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('test-performed-show', $testPerformed->id) }}">
                                        Report
                                    </a>
                                    <a class="btn btn-xs btn-primary" href="{{ route('test-performed-table', $testPerformed->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                    @if(auth::check() && Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'technician')

                                    <a class="btn btn-xs btn-info" href="{{ route('test-performed-edit', $testPerformed->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    @endif
                                    @if(Auth::user()->role != 'receptionist')
                                    <form  method="POST" action="{{ route("performed-test-delete", [$testPerformed->id]) }}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"  style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                    @endif
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
            // Setup - add a text input to each footer cell
            $('#performedTable thead tr').clone(true).appendTo( '#performedTable thead' );

            $('#performedTable thead tr:eq(1) th').each( function (i) {
                if(i==1 || i==2 || i==3 || i==4){
                    var title = $(this).text();
                    $(this).html( '<input type="text" style="width:100%;" placeholder="Search" />' );
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
                        console.log(entry);
                        $(document.getElementById("form_block")).append("<input type=\"text\" name=\"report_ids[]\" value=\"" + $(entry)[0].cells[0].id + "\">");
                        return $(entry)[0].cells[0].id;
                    });

                    var pnames = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry)[0].cells[4].innerHTML.replace(/\s/g, '');
                    });

                    //checking if patient names are different. Leter check for MRID
                    if(!pnames.every( (val, i, arr) => val === arr[0] )){
                        alert('Different patients selected');
                        return
                    }


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

            table = $('#performedTable').DataTable({
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