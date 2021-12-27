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
        td {
            text-align: center;
        }
    </style>
    <div class="card">
        <div class="card-header">
            Test Detail
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <b> <label for="user_id">Test Name</label></b>
                        <p>{{ $testPerformedsId->availableTest->name ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Patient Name</label></b>
                        <p>{{ $testPerformedsId->patient->Pname ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Type</label></b>
                        <p>{{ $testPerformedsId->type ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Referred By</label></b>
                        <p>{{ $testPerformedsId->referred ?? '' }}</p>
                    </div>
                    <div class="col">
                        <b> <label for="user_id">Status</label></b>
                        @if($testPerformedsId->type === "urgent")
                            @if (\Carbon\Carbon::now()->timestamp < $testPerformedsId->availableTest->urgent_timehour + $testPerformedsId->created_at->timestamp && $testPerformedsId->Sname_id =='2')
                                <div>
                                    <button class="btn btn-xs btn-success">Verified</button>
                                </div>
                            @elseif (\Carbon\Carbon::now()->timestamp < $testPerformedsId->availableTest->urgent_timehour + $testPerformedsId->created_at->timestamp )
                                <div>
                                    <button class="btn btn-xs btn-info">In Process</button>
                                </div>
                            @elseif ($testPerformedsId->Sname_id =='2')
                                <div>
                                    <button class="btn btn-xs btn-success">Verified</button>
                                </div>
                            @elseif (\Carbon\Carbon::now()->timestamp > $testPerformedsId->availableTest->urgent_timehour + $testPerformedsId->created_at->timestamp)
                                <div>
                                    <button class="btn btn-xs btn-danger">Delayed</button>
                                </div>
                            @else
                                <div>
                                    <button class="btn btn-xs btn-info">Delayedddddd</button>
                                </div>
                            @endif
                        @endif
                        @if($testPerformedsId->type === 'standard')
                            @if (\Carbon\Carbon::now()->timestamp < $testPerformedsId->availableTest->stander_timehour + $testPerformedsId->created_at->timestamp && $testPerformedsId->Sname_id =='2')
                                <div>
                                    <button class="btn btn-xs btn-success">Verified</button>
                                </div>
                            @elseif (\Carbon\Carbon::now()->timestamp < $testPerformedsId->availableTest->stander_timehour + $testPerformedsId->created_at->timestamp )
                                <div>
                                    <button class="btn btn-xs btn-info">In Process</button>
                                </div>
                            @elseif ($testPerformedsId->Sname_id =='2')
                                <div>
                                    <button class="btn btn-xs btn-success">Verified</button>
                                </div>
                            @elseif (\Carbon\Carbon::now()->timestamp > $testPerformedsId->availableTest->stander_timehour + $testPerformedsId->created_at->timestamp)
                                <div>
                                    <button class="btn btn-xs btn-danger">Delayed</button>
                                </div>
                            @else
                                <div>
                                    <button class="btn btn-xs btn-info">Delayed</button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <hr class="hr">
                {{--                coagulation_type--}}

                @if($testPerformedsId->availableTest->type==3)
                    <div>
                        <h3>Report Details</h3>
                    </div>
                    <div class="row col-12">

                        <div class="col-4"><h5>Prothrombin Time</h5></div>
                        <div class="col-8">
                            <div class="col-md-6 mb-6">
                                <div class="form-group">
                                    <label class="required text-capitalize" for="pro_test_time">Test</label>
                                    <input readonly class="form-control" type="number" name="pro_test_time" id="pro_test_time" value="{{( isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "pro_test_time")->first()) ? $testPerformedsId->widal->where("type", "pro_test_time")->first()->value : ""}}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="form-group">
                                    <label class="required text-capitalize" for="pro_control_time">Control</label>
                                    <input readonly class="form-control" type="number" name="pro_control_time" id="pro_control_time" value="{{( isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "pro_control_time")->first()) ? $testPerformedsId->widal->where("type", "pro_control_time")->first()->value : ""}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-4"><h5>A.P.T.T</h5></div>
                        <div class="col-8">
                            <div class="col-md-6 mb-6">
                                <div class="form-group">
                                    <label class="required text-capitalize" for="aptt_test_time">Test</label>
                                    <input readonly class="form-control" type="number" name="aptt_test_time" id="aptt_test_time" value="{{( isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "aptt_test_time")->first()) ? $testPerformedsId->widal->where("type", "aptt_test_time")->first()->value : ""}}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="form-group">
                                    {{--                                            <div class="input-group">--}}
                                    <label class="required text-capitalize" for="aptt_control_time">Control</label>
                                    <input readonly class="form-control" type="number" name="aptt_control_time" id="aptt_control_time" value="{{( isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "aptt_control_time")->first()) ? $testPerformedsId->widal->where("type", "aptt_control_time")->first()->value : ""}}">
                                    {{--                                            </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($testPerformedsId->availableTest->type==4)
                    <div class="col-md-8 mb-8 offset-2">
                        <table border="1" class="w-100">
                            <tr>
                                <td></td>
                                <td>1:20</td>
                                <td>1:40</td>
                                <td>1:80</td>
                                <td>1:160</td>
                                <td>1:320</td>
                            </tr>
                            <tr>
                                <td>TO</td>
                                <td><input disabled type="checkbox" name="to[]" value="1" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "to_1")->first() && $testPerformedsId->widal->where("type", "to_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="to[]" value="2" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "to_2")->first() && $testPerformedsId->widal->where("type", "to_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="to[]" value="3" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "to_3")->first() && $testPerformedsId->widal->where("type", "to_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="to[]" value="4" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "to_4")->first() && $testPerformedsId->widal->where("type", "to_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="to[]" value="5" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "to_5")->first() && $testPerformedsId->widal->where("type", "to_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                            </tr>
                            <tr>
                                <td>TH</td>
                                <td><input disabled type="checkbox" name="th[]" value="1" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "th_1")->first() && $testPerformedsId->widal->where("type", "th_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="th[]" value="2" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "th_2")->first() && $testPerformedsId->widal->where("type", "th_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="th[]" value="3" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "th_3")->first() && $testPerformedsId->widal->where("type", "th_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="th[]" value="4" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "th_4")->first() && $testPerformedsId->widal->where("type", "th_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="th[]" value="5" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "th_5")->first() && $testPerformedsId->widal->where("type", "th_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                            </tr>
                            <tr>
                                <td>AO</td>
                                <td><input disabled type="checkbox" name="ao[]" value="1" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ao_1")->first() && $testPerformedsId->widal->where("type", "ao_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="ao[]" value="2" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ao_2")->first() && $testPerformedsId->widal->where("type", "ao_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="ao[]" value="3" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ao_3")->first() && $testPerformedsId->widal->where("type", "ao_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="ao[]" value="4" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ao_4")->first() && $testPerformedsId->widal->where("type", "ao_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="ao[]" value="5" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ao_5")->first() && $testPerformedsId->widal->where("type", "ao_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                            </tr>
                            <tr>
                                <td>AH</td>
                                <td><input disabled type="checkbox" name="ah[]" value="1" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ah_1")->first() && $testPerformedsId->widal->where("type", "ah_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="ah[]" value="2" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ah_2")->first() && $testPerformedsId->widal->where("type", "ah_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="ah[]" value="3" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ah_3")->first() && $testPerformedsId->widal->where("type", "ah_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="ah[]" value="4" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ah_4")->first() && $testPerformedsId->widal->where("type", "ah_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="ah[]" value="5" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "ah_5")->first() && $testPerformedsId->widal->where("type", "ah_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                            </tr>
                            <tr>
                                <td>BO</td>
                                <td><input disabled type="checkbox" name="bo[]" value="1" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bo_1")->first() && $testPerformedsId->widal->where("type", "bo_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="bo[]" value="2" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bo_2")->first() && $testPerformedsId->widal->where("type", "bo_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="bo[]" value="3" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bo_3")->first() && $testPerformedsId->widal->where("type", "bo_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="bo[]" value="4" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bo_4")->first() && $testPerformedsId->widal->where("type", "bo_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="bo[]" value="5" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bo_5")->first() && $testPerformedsId->widal->where("type", "bo_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                            </tr>
                            <tr>
                                <td>BH</td>
                                <td><input disabled type="checkbox" name="bh[]" value="1" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bh_1")->first() && $testPerformedsId->widal->where("type", "bh_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="bh[]" value="2" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bh_2")->first() && $testPerformedsId->widal->where("type", "bh_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="bh[]" value="3" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bh_3")->first() && $testPerformedsId->widal->where("type", "bh_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="bh[]" value="4" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bh_4")->first() && $testPerformedsId->widal->where("type", "bh_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                <td><input disabled type="checkbox" name="bh[]" value="5" <?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "bh_5")->first() && $testPerformedsId->widal->where("type", "bh_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 mt-2">
                        <input readonly class="form-control" type="text" name="widal_result" placeholder="Result" value="<?php echo (isset($testPerformedsId->widal) && $testPerformedsId->widal->where("type", "widal_result")->first()) ? $testPerformedsId->widal->where("type", "widal_result")->first()->value : ""; ?>">
                    </div>
                @else
                    <div>
                        <h3>Report Items</h3>
                    </div>
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
                                    <b><label>Result Values</label></b>
                                    <p>{{ $TestReportItem->TestReport->value }}</p>
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
                        <hr class="hr1">
                    @endforeach
                @endif
                <hr class="hr">
                <div>
                    <h3>Inventory Used</h3>
                </div>
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
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a class="btn btn-ls btn-primary" href="{{ route('test-performed-back') }}">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
