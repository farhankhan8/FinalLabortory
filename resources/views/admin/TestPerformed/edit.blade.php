@extends('layouts.admin')
@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    <style>
        hr {
            border-top: 1px solid rgb(47 53 58);
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
            Edit Test
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("performed-test-update", [$performed->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Patient: </strong>{{$performed->patient->Pname}} ({{$performed->patient->id}})
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>

                <hr/>
               
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="available_test_id"><h4>{{$performed->availableTest->name}}</h4></label>
                            <select onchange="set_test_form()" class="form-control d-none" name="available_test_id" id="available_test_id" required>
                                @foreach($getNameFromAvailbles as $id => $getNameFromAvailble)
                                    <option value="{{ $id }}" {{ $performed->available_test_id   == $id ? 'selected' : '' }}>{{ $getNameFromAvailble }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('available_test_id '))
                                <div class="invalid-feedback">
                                    {{ $errors->first('available_test_id ') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="required" for="status ">Select Status</label>
                            <select class="form-control" name="status" id="status" required>
                                
                                @if($performed->status  == 'verified' && Auth::user()->role == 'technician')
                                    <option selected value="verified">Verified</option>
                                @else
                                    <option {{$performed->status == "process" ? "selected" : "" }} value="process">In Process</option>
                                    <option {{$performed->status == "verified" ? "selected" : "" }} value="verified">Verified</option>
                                    <option {{$performed->status == "cancelled" ? "selected" : "" }} value="cancelled">Cancelled</option>
                                @endif
                                
                                    
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3 d-none">
                        <div class="form-group">
                            <p class="required">Test Type</p>
                            <label for="urgent">Urgent</label>
                            <input type="radio" name="type" id="urgent" required {{$performed->type=="urgent" ? "checked":""}} value="urgent">
                            <label for="standard">Standard</label>
                            <input type="radio" name="type" id="standard" required {{$performed->type=="standard" ? "checked":""}} value="standard">
                        </div>
                    </div>


                    <div id="test_form" class="row col-md-12 mb-2 d-none">

                        @foreach($allAvailableTests as $test)
                            <div class="form-row col-md-12" id="test{{$test->id}}" class="tests">
                                
                                @if($test->type==1)

                                    @if($performed->availableTest->id==$test->id)
                                        @php  $foreach_variable=$test->TestReportItems->whereIn("id",$performed->testReport->pluck("test_report_item_id")->all()); @endphp
                                    @else
                                        @php  $foreach_variable=$test->TestReportItems->where("status","active"); @endphp
                                    @endif
                                    @foreach($foreach_variable as $report_item)
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label class="required text-capitalize" for="testResult{{$report_item->id}}">{{$report_item->title}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">{{$report_item->unit}}</span>
                                                    </div>
                                                    <input class="form-control" type="text" name="testResult{{$report_item->id}}" id="testResult{{$report_item->id}}" value="{{$performed->availableTest->id==$test->id ? $performed->testReport->where("test_report_item_id",$report_item->id)->first()->value:""}}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                @elseif($test->type==5)
{{--@dd($performed->testReport->pluck("test_report_item_id")->all())--}}
                                    @if($performed->availableTest->id==$test->id)
                                        @php  $foreach_variable=$test->TestReportItems->whereIn("id",$performed->testReport->pluck("test_report_item_id")->all()); @endphp
                                    @else
                                        @php  $foreach_variable=$test->TestReportItems->where("status","active"); @endphp
                                    @endif
{{--                                @dd($foreach_variable)--}}
                                    @foreach($foreach_variable->where("table_num",1)->sortBy("item_index") as $report_item)
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label class="required text-capitalize" for="testResult{{$report_item->id}}">{{$report_item->title}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">{{$report_item->unit}}</span>
                                                    </div>
                                                    <input class="form-control" type="text" name="testResult{{$report_item->id}}" id="testResult{{$report_item->id}}" value="{{$performed->availableTest->id==$test->id ? $performed->testReport->where("test_report_item_id",$report_item->id)->first()->value:""}}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <div class="col-12">
                                        <input type="text" name="heading" value="{{($performed->heading && $performed->heading->value) ? $performed->heading->value : 'Microscopic Examination'}}" placeholder="Middle Heading of Tables" class="font-2xl form-control my-2 text-center">
                                    </div>

                                    @foreach($foreach_variable->where("table_num",2)->sortBy("item_index") as $report_item)
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label class="required text-capitalize" for="testResult{{$report_item->id}}">{{$report_item->title}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">{{$report_item->unit}}</span>
                                                    </div>
                                                    <input class="form-control" type="text" name="testResult{{$report_item->id}}" id="testResult{{$report_item->id}}" value="{{$performed->availableTest->id==$test->id ? $performed->testReport->where("test_report_item_id",$report_item->id)->first()->value:""}}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{--editor type--}}
                                @elseif($test->type==2)
                                    <div class="col-md-12 mb-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <textarea class='w-100 col-12' name="ckeditor">{{($test->id==$performed->availableTest->id) ? $performed->editor:""}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{--Coagulation--}}
                                @elseif($test->type==3)
                                    <div class="col-4"><h5>Prothrombin Time</h5></div>
                                    <div class="col-8">
                                        <div class="col-md-6 mb-6">
                                            <div class="form-group">
                                                <label class="required text-capitalize" for="pro_test_time">Test</label>
                                                <input class="form-control" type="number" name="pro_test_time" id="pro_test_time" value="{{($test->id==$performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "pro_test_time")->first()) ? $performed->widal->where("type", "pro_test_time")->first()->value : ""}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <div class="form-group">
                                                <label class="required text-capitalize" for="pro_control_time">Control</label>
                                                <input class="form-control" type="number" name="pro_control_time" id="pro_control_time" value="{{($test->id==$performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "pro_control_time")->first()) ? $performed->widal->where("type", "pro_control_time")->first()->value : ""}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4"><h5>A.P.T.T</h5></div>
                                    <div class="col-8">
                                        <div class="col-md-6 mb-6">
                                            <div class="form-group">
                                                <label class="required text-capitalize" for="aptt_test_time">Test</label>
                                                <input class="form-control" type="number" name="aptt_test_time" id="aptt_test_time" value="{{($test->id==$performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "aptt_test_time")->first()) ? $performed->widal->where("type", "aptt_test_time")->first()->value : ""}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <div class="form-group">
                                                {{--                                            <div class="input-group">--}}
                                                <label class="required text-capitalize" for="aptt_control_time">Control</label>
                                                <input class="form-control" type="number" name="aptt_control_time" id="aptt_control_time" value="{{($test->id==$performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "aptt_control_time")->first()) ? $performed->widal->where("type", "aptt_control_time")->first()->value : ""}}">
                                                {{--                                            </div>--}}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- widal--}}
                                @elseif($test->type==4)
                                    {{--                                    @dd($performed->widal,$performed->widal->where("type","to_1")->first())--}}
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
                                                <td><input type="checkbox" name="to[]" value="1" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "to_1")->first() && $performed->widal->where("type", "to_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="to[]" value="2" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "to_2")->first() && $performed->widal->where("type", "to_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="to[]" value="3" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "to_3")->first() && $performed->widal->where("type", "to_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="to[]" value="4" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "to_4")->first() && $performed->widal->where("type", "to_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="to[]" value="5" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "to_5")->first() && $performed->widal->where("type", "to_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>TH</td>
                                                <td><input type="checkbox" name="th[]" value="1" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "th_1")->first() && $performed->widal->where("type", "th_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="th[]" value="2" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "th_2")->first() && $performed->widal->where("type", "th_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="th[]" value="3" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "th_3")->first() && $performed->widal->where("type", "th_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="th[]" value="4" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "th_4")->first() && $performed->widal->where("type", "th_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="th[]" value="5" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "th_5")->first() && $performed->widal->where("type", "th_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>AO</td>
                                                <td><input type="checkbox" name="ao[]" value="1" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ao_1")->first() && $performed->widal->where("type", "ao_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="ao[]" value="2" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ao_2")->first() && $performed->widal->where("type", "ao_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="ao[]" value="3" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ao_3")->first() && $performed->widal->where("type", "ao_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="ao[]" value="4" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ao_4")->first() && $performed->widal->where("type", "ao_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="ao[]" value="5" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ao_5")->first() && $performed->widal->where("type", "ao_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>AH</td>
                                                <td><input type="checkbox" name="ah[]" value="1" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ah_1")->first() && $performed->widal->where("type", "ah_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="ah[]" value="2" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ah_2")->first() && $performed->widal->where("type", "ah_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="ah[]" value="3" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ah_3")->first() && $performed->widal->where("type", "ah_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="ah[]" value="4" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ah_4")->first() && $performed->widal->where("type", "ah_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="ah[]" value="5" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "ah_5")->first() && $performed->widal->where("type", "ah_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>BO</td>
                                                <td><input type="checkbox" name="bo[]" value="1" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bo_1")->first() && $performed->widal->where("type", "bo_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="bo[]" value="2" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bo_2")->first() && $performed->widal->where("type", "bo_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="bo[]" value="3" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bo_3")->first() && $performed->widal->where("type", "bo_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="bo[]" value="4" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bo_4")->first() && $performed->widal->where("type", "bo_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="bo[]" value="5" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bo_5")->first() && $performed->widal->where("type", "bo_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>BH</td>
                                                <td><input type="checkbox" name="bh[]" value="1" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bh_1")->first() && $performed->widal->where("type", "bh_1")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="bh[]" value="2" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bh_2")->first() && $performed->widal->where("type", "bh_2")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="bh[]" value="3" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bh_3")->first() && $performed->widal->where("type", "bh_3")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="bh[]" value="4" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bh_4")->first() && $performed->widal->where("type", "bh_4")->first()->value == "true") ? "checked" : ""; ?>></td>
                                                <td><input type="checkbox" name="bh[]" value="5" <?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "bh_5")->first() && $performed->widal->where("type", "bh_5")->first()->value == "true") ? "checked" : ""; ?>></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <input class="form-control" type="text" name="widal_result" placeholder="Result" value="<?php echo ($test->id == $performed->availableTest->id && isset($performed->widal) && $performed->widal->where("type", "widal_result")->first()) ? $performed->widal->where("type", "widal_result")->first()->value : ""; ?>">
                                    </div>
                                @endif

                                <script>
                                    var test{{$test->id}}= document.getElementById("test{{$test->id}}").outerHTML;
                                    document.getElementById("test{{$test->id}}").outerHTML = "";
                                </script>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group shadow-textarea col-md-12">
                        <label>Comment</label>
                        <textarea class="form-control z-depth-1" name="comments" rows="3">{{ $performed->comments}}</textarea>
                    </div>
                    <button class="btn btn-primary mt-3 ml-1" type="submit">Update</button>
                </div>

            </form>
        </div>
    </div>
    <script>

        function set_test_form() {
            if (document.getElementById("available_test_id").value)
                document.getElementById("test_form").innerHTML = eval("test" + document.getElementById("available_test_id").value);
            else
                document.getElementById("test_form").innerHTML = "";

            if (document.getElementsByName("ckeditor").length) {
                CKEDITOR.replace("ckeditor", {
                    width: '100%',
                });
            }
            document.getElementById("test_form").classList.remove("d-none");
        }

        set_test_form();
    </script>
@endsection