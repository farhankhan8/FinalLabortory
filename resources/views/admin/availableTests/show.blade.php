@extends('layouts.admin')
@section('content')
    <style>
        .hr {
            border-style: solid;
            border-color: black;
            }
        .hr1 {
            border-top: 1px dashed #777;
            }
    </style>

    <div class="card">
        <div class="card-header">
            Test Detail
        </div>
        <div class="card-body">
            <div><h4>Basic</h4></div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <b><label>Category</label></b>
                        <p>{{ $availableTestId->category->Cname}}</p>
                    </div>
                    <div class="col">
                        <b> <label>Name</label></b>
                        <p>{{ $availableTestId->name}}</p>
                    </div>
                    <div class="col">
                        <b> <label>Test Fee</label></b>
                        <p>{{ $availableTestId->testFee}}</p>
                    </div>
                    <div class="col">
                        <b> <label>Urgent Fee</label></b>
                        <p>{{ $availableTestId->urgentFee}}</p>
                    </div>
                </div>
            </div>
            <hr class="hr">
            <div><h3>Report Items</h3>
            </div>
            @php
            $length = count($availableTestId->TestReportItems->where("status","active"));
            $x = 1;
            @endphp
            @foreach($availableTestId->TestReportItems->where("status","active") as $TestReportItem)
            <div class="text-capitalize"><h4>{{$TestReportItem->title}}</h4></div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <b><label>Normal Range</label></b>
                        <p>@php echo $TestReportItem->normalRange @endphp</p>
                    </div>
                    <div class="col">
                        <b><label>Critical Values</label></b>
                        <p>{{ $TestReportItem->firstCriticalValue }}{{ $TestReportItem->unit ?? '' }}-{{ $TestReportItem->finalCriticalValue }}{{ $TestReportItem->unit ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b><label></label></b>
                        <p></p>
                    </div>
                    <div class="col">
                        <b><label></label></b>
                        <p></p>
                    </div>
                </div>
            </div>
                    @php
                    if($length === $x)
                    {
                        echo "";
                    }else{
                        echo "<hr class='hr1'>";
                    }
                    $x++;
                    @endphp
            @endforeach
            <hr class="hr">

            <div><h3>Inventory Used</h3></div>
                @foreach($availableTestId->available_test_inventories as $test_inventories)

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <b><label></label></b>
                            <p>{{ $test_inventories->inventory->inventoryName ?? '' }}&nbsp = &nbsp {{ $test_inventories->itemUsed }}{{ $test_inventories->inventory->inventoryUnit }}</p>
                        </div>
                    </div>
                </div>
                <hr class="hr1">
                @endforeach
                <hr class="hr">
            <div>
                    <a class="btn btn-primary" href="{{ route('available-tests') }}">
                        <button class="btn btn-primary">
                            Back
                        </button>
                    </a>
                </div>
            </div>
        </div>

@endsection