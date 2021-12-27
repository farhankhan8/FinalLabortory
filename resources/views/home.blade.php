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
                        <div class="row mt-2 widgets">
                            <div class="col-md-3 col-sm-6 py-2">
                                <div class="card card-1 text-white h-100">
                                    <div style="background-color:rgb(0,200,255);" class="card-body card-1">

                                        <i class="mr-2 fa fa-hospital-o" style="font-size:48px;"></i>

                                        <h5 class="mb-3 d-inline-block">Today Verified Tests</h5>
                                        <h3 class="amount-position"> {{ $today }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 py-2">
                                <div class="card card-1 text-white h-100">
                                    <div style="background-color:rgb(50,150,255);" class="card-body card-1">
                                        <i class="mr-2 fa fa-user-md" style="font-size:48px;"></i>
                                        <h5 class="mb-3 d-inline-block">Weekly Verified Tests</h5>
                                        <h3 class="amount-position"> {{ $thisWeekPatient }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 py-2">
                                <div class="card card-1 text-white h-100">
                                    <div style="background-color:rgb(200,150,255);" class="card-body card-1">
                                        <i class="mr-2 fa fa-stethoscope" style="font-size:48px;"></i>
                                        <h5 class="mb-3 d-inline-block">Monthly Verified Tests </h5>
                                        <h3 class="amount-position"> {{ $thisMongthPatient }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 py-2">
                                <div class="card card-1 text-white h-100">
                                    <div style="background-color:rgb(200,50,90);;" class="card-body card-1">
                                        <i class="mr-2 fa fa-wheelchair" style="font-size:48px;color:white"></i>
                                        <h5 class="mb-3 d-inline-block">Critical Test Today</h5>
                                        <h3>{{ count($criticalTestToday) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-1 mb-4">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h2>All Tests Performed Today</h2>
                                <table class="table table-bordered table-striped table-hover datatable datatable-Event">
                                    <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Patient Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($testPerformeds as $key => $testPerformed)
                                        <tr>
                                            <td><a class="" href="{{ route('test-performed-edit', $testPerformed->id) }}">{{ $testPerformed->availableTest->name ?? '' }}</a></td>
                                            <td><a class="" href="{{ route('patient-show', $testPerformed->patient->id) }}">{{ $testPerformed->patient->Pname  ?? '' }}</a></td>
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
                                                <a class="btn btn-xs btn-info" href="{{ route('test-performed-edit', $testPerformed->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                                <form method="POST" action="{{ route("performed-test-delete", [$testPerformed->id]) }}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                            <div class="col-md-6 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover datatable datatable-Event">
                                        <h2>Top Tests</h2>
                                        <thead>
                                        <tr>
                                            <th>Test Name</th>
                                            <th>No Of Tests Today</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($availableTestNameAndCountTests as $key => $availableTestNameAndCountTest)
                                            <tr>
                                                <td><a class="" href="{{ route('test-performed-edit', $availableTestNameAndCountTest->id) }}">{{ $availableTestNameAndCountTest->name }}</a></td>
                                                <td>{{ $availableTestNameAndCountTest->test_performed_count }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h2>Critical Tests Today </h2>
                                <table class="table table-bordered table-striped table-hover datatable datatable-Event">
                                    <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Patient Name</th>
                                        <th>Phone Number</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($criticalTestToday as $key => $criticalTestToda)
                                        <tr>
                                            <td>{{ $criticalTestToda->name ?? '' }}</a></td>
                                            <td>{{ $criticalTestToda->Pname  ?? '' }}</td>
                                            <td>{{ $criticalTestToda->phone  ?? '' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($criticalTestToda->created_at)->isoFormat('MMM Do YYYY H:m:s')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h2>Delayed Tests Today</h2>
                                <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                                    <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Patient Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($todayDelayeds as $todayDelayed)
                                        @if($todayDelayed->type === "standard")
                                            @if(\Carbon\Carbon::now()->timestamp > $todayDelayed->availableTest->stander_timehour + $todayDelayed->created_at->timestamp)
                                                <tr>
                                                    <td><a class="" href="{{ route('test-performed-edit', $todayDelayed->id) }}">{{ $todayDelayed->availableTest->name ?? '' }}</a></td>
                                                    <td><a class="" href="{{ route('patient-show', $testPerformed->patient->id) }}">{{ $todayDelayed->patient->Pname  ?? '' }}</a></td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($todayDelayed->created_at)->isoFormat('MMM Do YYYY H:m:s')}}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-xs btn-danger">Delayed</button>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-xs btn-info" href="{{ route('test-performed-edit', $todayDelayed->id) }}">
                                                            {{ trans('global.edit') }}
                                                        </a>
                                                        <form method="POST" action="{{ route('performed-test-delete', [$todayDelayed->id]) }}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                    @foreach($todayDelayeds as $todayDelayed)
                                        @if($todayDelayed->type === "urgent")
                                            @if(\Carbon\Carbon::now()->timestamp > $todayDelayed->availableTest->urgent_timehour + $todayDelayed->created_at->timestamp)
                                                <tr>
                                                    <td>
                                                    <a class="" href="{{ route('test-performed-edit', $todayDelayed->id) }}">{{ $todayDelayed->availableTest->name ?? '' }}</a>
                                                    </td>
                                                    <td>
                                                    <a class="" href="{{ route('patient-show', $testPerformed->patient->id) }}">{{ $todayDelayed->patient->Pname  ?? '' }}</a>
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($todayDelayed->created_at)->isoFormat('MMM Do YYYY H:m:s')}}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-xs btn-danger">Delayed</button>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-xs btn-info" href="{{ route('test-performed-edit', $todayDelayed->id) }}">
                                                            {{ trans('global.edit') }}
                                                        </a>
                                                        <form method="POST" action="{{ route('performed-test-delete', [$todayDelayed->id]) }}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
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
                "paging": false,
                "info": false
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection