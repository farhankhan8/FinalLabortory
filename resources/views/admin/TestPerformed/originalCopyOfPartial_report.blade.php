<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover datatable datatable-Event">
            <tr>
                <th>Test</th>
                <th>Unit</th>
                <th>Result</th>
                <th>REFERENCE RANGE</th>
                @php $x=1; @endphp
                @foreach($getpatient->testPerformed->where("available_test_id",$testPerformedsId->availableTest->id)->where("id","<",$testPerformedsId->id)->take(2) as $old_test)
                <th>History {{$x}}</th>
                @php $x++; @endphp
                @endforeach
            </tr>
                @foreach($testPerformedsId->testReport as $testReport)
                    <tr>
                        <td class="text-capitalize">{{$testReport->report_item->title}}</td>
                        <td class="">{{$testReport->report_item->unit}}</td>
                        <td>{{ $testReport->value }}</td>
                        <td>({{$testReport->report_item->initialNormalValue}}-{{$testReport->report_item->finalNormalValue}}){{$testReport->report_item->unit}}</td>
                        @foreach($getpatient->testPerformed->where("available_test_id",$testPerformedsId->availableTest->id)->where("id","<",$testPerformedsId->id)->take(2) as $old_test)
                        <td>{{ $old_test->testReport->where("test_report_item_id",$testReport->test_report_item_id)->first()->value }} <span class="text-black-50"></span>({{$old_test->created_at}})</td>
                        @endforeach
                    </tr>
                @endforeach
        </table>
    </div>
</div>

