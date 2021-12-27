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
    </style>
    <div class="card">
        <div class="card-header">
            Edit Test
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("availabel-tests-update", [$availableTest->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="form-row">
                    <div class="col-md-12 mb-12"><h4>Basic</h4></div>

                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="category_id ">Test Category</label>
                            <select class="form-control" name="category_id" id="category_id" required>
                                @foreach($catagorys as $id => $catagory)
                                    <option value="{{ $id }}" {{ $availableTest->category_id  == $id ? 'selected' : '' }}>{{ $catagory }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category_id') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="name">Test Name</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $availableTest->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="testCode">Test Code</label>
                            <input class="form-control {{ $errors->has('testCode') ? 'is-invalid' : '' }}" type="text" name="testCode" id="testCode" value="{{ old('testCode', $availableTest->testCode) }}" required>
                            @if($errors->has('testCode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('testCode') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="timehour">Standard Completion timeee</label>
                        <div class="input-group">
                            <input type="text" name="stander_timehour" class="form-control" id="duration" value="{{ old('testFee', $availableTest->stander_timehour) }}">
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="urgent_timehour">Urgent Completion time</label>
                        <div class="input-group">
                            <input type="text" name="urgent_timehour" class="form-control" id="duration2" value="{{ old('testFee', $availableTest->urgent_timehour) }}">
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="testFee">Test Fee</label>
                            <input class="form-control {{ $errors->has('testFee') ? 'is-invalid' : '' }}" type="number" name="testFee" id="testFee" value="{{ old('testFee', $availableTest->testFee) }}" step="1">
                            @if($errors->has('testFee'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('testFee') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label for="urgentFee">Urgent Fee</label>
                            <input class="form-control {{ $errors->has('urgentFee') ? 'is-invalid' : '' }}" type="number" name="urgentFee" id="urgentFee" value="{{ $availableTest->urgentFee }}" step="1">
                            @if($errors->has('urgentFee'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('urgentFee') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    {{--type--}}
                    <div class="col-md-5 mb-5">
                        <label for="">Test Type</label>
                        <br>
                        <div class="form-check form-check-inline my-1">
                            <input id="normal" class="form-check-input" type="radio" disabled name="type" value="1" {{$availableTest->type==1 ? "checked":""}}>
                            <label class="form-check-label" for="normal">Normal</label>
                        </div>
                        <div class="form-check form-check-inline my-1">
                            <input id="editor" class="form-check-input" type="radio" disabled name="type" value="2" {{$availableTest->type==2 ? "checked":""}}>
                            <label class="form-check-label" for="editor">Editor</label>
                        </div>

                        <div class="form-check form-check-inline my-1">
                            <input id="widal" class="form-check-input" type="radio" disabled name="type" value="4" {{$availableTest->type==4 ? "checked":""}}>
                            <label class="form-check-label text-capitalize" for="widal">Widal</label>
                        </div>
                        <div class="form-check form-check-inline my-1">
                            <input id="two-table" class="form-check-input" type="radio" disabled name="type" value="5" {{$availableTest->type==5 ? "checked":""}}>
                            <label class="form-check-label text-capitalize" for="two-table">Two Table</label>
                        </div>
                    </div>

                </div>
                <hr class="hr1">

                <div class="form-row">
                    @if($availableTest->type==1 || $availableTest->type==5)
                        <div class="col-md-12 mb-12"><h4>Report Items</h4></div>
                        <div class="col-md-12" id="report_item_form">
                            @php $y=1; @endphp
                            @foreach($availableTest->TestReportItems->where("status","active")->where("table_num",1) as $TestReportItem)
                                <div class="col-md-12 report_item_class">
                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label for="">Order</label>
                                            <input class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" type="number" step="1" min="1" name="order[]" value="{{$TestReportItem->item_index}}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label class="" for="title">Title</label>
                                                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title[]" id="title" value="{{$TestReportItem->title}}">
                                                @if($errors->has('title'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('title') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="units">Test Unit</label>
                                                <input class="form-control {{ $errors->has('units') ? 'is-invalid' : '' }}" type="text" name="units[]" id="units" value="{{ $TestReportItem->unit }}">
                                                @if($errors->has('units'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('units') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>


                                        <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                                <label for="firstCriticalValue">First Critical Range</label>
                                                <input class="form-control {{ $errors->has('firstCriticalValue') ? 'is-invalid' : '' }}" type="number" name="firstCriticalValue[]" id="firstCriticalValue" value="{{ $TestReportItem->firstCriticalValue}}" step="0.01">
                                                @if($errors->has('firstCriticalValue'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('firstCriticalValue') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                                <label for="finalCriticalValue">Final Critical Range</label>
                                                <input class="form-control {{ $errors->has('finalCriticalValue') ? 'is-invalid' : '' }}" type="number" name="finalCriticalValue[]" id="finalCriticalValue" value="{{ $TestReportItem->finalCriticalValue }}" step="1">
                                                @if($errors->has('finalCriticalValue'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('finalCriticalValue') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label>Normal Range</label>
                                                <textarea class="form-control ckeditor {{ $errors->has('normalRange') ? 'is-invalid' : '' }}" name="normalRange[]">{{ $TestReportItem->normalRange }}</textarea>
                                                @if($errors->has('normalRange'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('normalRange') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr class="hr1">
                                        </div>
                                    </div>
                                </div>
                                @php $y++; @endphp
                            @endforeach
                            {{--to handle null values--}}
                            @if($y==1)
                                <div class="col-md-12 report_item_class">
                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label for="">Order</label>
                                            <input class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" type="number" step="1" min="1" name="order[]" value="1">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label class="" for="title">Title</label>
                                                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title[]" id="title" value="">
                                                @if($errors->has('title'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('title') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="units">Test Unit</label>
                                                <input class="form-control {{ $errors->has('units') ? 'is-invalid' : '' }}" type="text" name="units[]" id="units" value="">
                                                @if($errors->has('units'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('units') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                                <label for="firstCriticalValue">First Critical Range</label>
                                                <input class="form-control {{ $errors->has('firstCriticalValue') ? 'is-invalid' : '' }}" type="number" name="firstCriticalValue[]" id="firstCriticalValue" value="" step="0.01">
                                                @if($errors->has('firstCriticalValue'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('firstCriticalValue') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                                <label for="finalCriticalValue">Final Critical Range</label>
                                                <input class="form-control {{ $errors->has('finalCriticalValue') ? 'is-invalid' : '' }}" type="number" name="finalCriticalValue[]" id="finalCriticalValue" value="" step="1">
                                                @if($errors->has('finalCriticalValue'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('finalCriticalValue') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label>Normal Range</label>
                                                <textarea class="form-control ckeditor {{ $errors->has('normalRange') ? 'is-invalid' : '' }}" name="normalRange[]"></textarea>
                                                @if($errors->has('normalRange'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('normalRange') }}
                                                    </div>
                                                @endif
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr class="hr1">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="button" onclick="add_item('report_item_form')" class="btn btn-xs btn-success">Add Item</button>
                            <button type="button" onclick="remove_item('report_item_class')" class="btn btn-xs btn-danger">Remove Item</button>
                        </div>

                        @if($availableTest->type==5)
                            <div class="col-md-12 mb-12"><h4>Report Items 2</h4></div>
                            <div class="col-md-12" id="report_item_form2">
                                @php $y=1; @endphp
                                @foreach($availableTest->TestReportItems->where("status","active")->where("table_num",2) as $TestReportItem)
                                    <div class="col-md-12 report_item_class2">
                                        <div class="row">

                                            <div class="col-md-4 mb-3">
                                                <label for="">Order</label>
                                                <input class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" type="number" step="1" min="1" name="order2[]" value="{{$TestReportItem->item_index}}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label class="" for="title">Title</label>
                                                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title2[]" id="title" value="{{$TestReportItem->title}}">
                                                    @if($errors->has('title'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('title') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="units">Test Unit</label>
                                                    <input class="form-control {{ $errors->has('units') ? 'is-invalid' : '' }}" type="text" name="units2[]" id="units" value="{{ $TestReportItem->unit }}">
                                                    @if($errors->has('units'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('units') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid state.
                                                </div>
                                            </div>


                                            <div class="col-md-2 mb-3">
                                                <div class="form-group">
                                                    <label for="firstCriticalValue">First Critical Range</label>
                                                    <input class="form-control {{ $errors->has('firstCriticalValue') ? 'is-invalid' : '' }}" type="number" name="firstCriticalValue2[]" id="firstCriticalValue" value="{{ $TestReportItem->firstCriticalValue}}" step="0.01">
                                                    @if($errors->has('firstCriticalValue'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('firstCriticalValue') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid state.
                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-3">
                                                <div class="form-group">
                                                    <label for="finalCriticalValue">Final Critical Range</label>
                                                    <input class="form-control {{ $errors->has('finalCriticalValue') ? 'is-invalid' : '' }}" type="number" name="finalCriticalValue2[]" id="finalCriticalValue" value="{{ $TestReportItem->finalCriticalValue }}" step="1">
                                                    @if($errors->has('finalCriticalValue'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('finalCriticalValue') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid city.
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label>Normal Range</label>
                                                    <textarea class="form-control ckeditor {{ $errors->has('normalRange') ? 'is-invalid' : '' }}" name="normalRange2[]">{{ $TestReportItem->normalRange }}</textarea>
                                                    @if($errors->has('normalRange'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('normalRange') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid city.
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <hr class="hr1">
                                            </div>
                                        </div>
                                    </div>
                                    @php $y++; @endphp
                                @endforeach
                                {{--to handle null values--}}
                                @if($y==1)
                                    <div class="col-md-12 report_item_class">
                                        <div class="row">

                                            <div class="col-md-4 mb-3">
                                                <label for="">Order</label>
                                                <input class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" type="number" step="1" min="1" name="order2[]" value="1">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label class="" for="title">Title</label>
                                                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title2[]" id="title" value="">
                                                    @if($errors->has('title'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('title') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label for="units">Test Unit</label>
                                                    <input class="form-control {{ $errors->has('units') ? 'is-invalid' : '' }}" type="text" name="units2[]" id="units" value="">
                                                    @if($errors->has('units'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('units') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid state.
                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-3">
                                                <div class="form-group">
                                                    <label for="firstCriticalValue">First Critical Range</label>
                                                    <input class="form-control {{ $errors->has('firstCriticalValue') ? 'is-invalid' : '' }}" type="number" name="firstCriticalValue2[]" id="firstCriticalValue" value="" step="0.01">
                                                    @if($errors->has('firstCriticalValue'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('firstCriticalValue') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid state.
                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-3">
                                                <div class="form-group">
                                                    <label for="finalCriticalValue">Final Critical Range</label>
                                                    <input class="form-control {{ $errors->has('finalCriticalValue') ? 'is-invalid' : '' }}" type="number" name="finalCriticalValue2[]" id="finalCriticalValue" value="" step="1">
                                                    @if($errors->has('finalCriticalValue'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('finalCriticalValue') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid city.
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label>Normal Range</label>
                                                    <textarea class="form-control ckeditor {{ $errors->has('normalRange') ? 'is-invalid' : '' }}" name="normalRange2[]"></textarea>
                                                    @if($errors->has('normalRange'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('normalRange') }}
                                                        </div>
                                                    @endif
                                                    <span class="help-block"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid city.
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <hr class="hr1">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="button" onclick="add_item('report_item_form2')" class="btn btn-xs btn-success">Add Item</button>
                                <button type="button" onclick="remove_item('report_item_class2')" class="btn btn-xs btn-danger">Remove Item</button>
                            </div>
                        @endif
                    @endif
                </div>

                <hr>
                {{--inventry--}}
                <div class="form-row">
                    <div class="col-md-12 mb-12"><h4>Inventory</h4></div>
                    <div class="row col-md-12" id="inventory_item_form">
                        @php $x=1; @endphp
                        @foreach($availableTest->available_test_inventories as $available_test_inventory)
                            <div class="col-md-12 inventory_item_class">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Inventory Item</label>
                                        <select class="form-control  {{ $errors->has('inventory_id') ? 'is-invalid' : '' }}" name="inventory_ids[]">
                                            @foreach($inventoryes as $key=>$value)
                                                <option value="{{ $key }}" {{ $available_test_inventory->inventory_id==$key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="inventory_quantity{{$x}}">Quantity</label>
                                        <input class="form-control {{ $errors->has('inventory_quantity') ? 'is-invalid' : '' }}" type="number" name="inventory_quantity[]" id="inventory_quantity{{$x}}" value="{{$available_test_inventory->itemUsed}}" step="1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr class="hr1">
                                </div>
                            </div>
                            @php $x++; @endphp
                        @endforeach
                        {{--if null values are submitted--}}
                        @if(!count($availableTest->available_test_inventories))
                            <div class="col-md-12 inventory_item_class">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Inventory Item</label>
                                        <select class="form-control  {{ $errors->has('inventory_id') ? 'is-invalid' : '' }}" name="inventory_ids[]">
                                            @foreach($inventoryes as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label>Quantity</label>
                                        <input class="form-control {{ $errors->has('inventory_quantity') ? 'is-invalid' : '' }}" type="number" name="inventory_quantity[]" value="" step="1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr class="hr1">
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="col-md-12 text-center">
                        <button type="button" onclick="add_inventory()" class="btn btn-xs btn-success">Add Inventory</button>
                        <button type="button" onclick="remove_inventory()" class="btn btn-xs btn-danger">Remove Inventory</button>
                    </div>
                </div>
                <hr>

                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label" for="invalidCheck3">
                        </label>
                        <div class="invalid-feedback">
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
            </form>

        </div>
    </div>

    {{--    for js--}}
    <div class="d-none">
        {{--    2nd table js--}}
        <div id="report_item_class2_js">
            <div class="col-md-12 report_item_class2">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="">Order</label>
                        <input class="form-control" type="number" step="1" min="1" name="order2[]" value="1">
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="">Title</label>
                            <input class="form-control " type="text" name="title2[]" value="">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Test Unit</label>
                            <input class="form-control" type="text" name="units2[]" value="">
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label>First Critical Range</label>
                            <input class="form-control" type="number" name="firstCriticalValue2[]" value="" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label>Final Critical Range</label>
                            <input class="form-control" type="number" name="finalCriticalValue2[]" value="" step="1">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Normal Range</label>
                            <textarea class="form-control ckeditor" name="normalRange2[]"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr class="hr1">
                    </div>
                </div>
            </div>
        </div>
        {{--    first table js--}}
        <div id="report_item_class_js">
            <div class="col-md-12 report_item_class">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="">Order</label>
                        <input class="form-control" type="number" step="1" min="1" name="order[]" value="1">
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="">Title</label>
                            <input class="form-control " type="text" name="title[]" value="">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Test Unit</label>
                            <input class="form-control" type="text" name="units[]" value="">
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label>First Critical Range</label>
                            <input class="form-control" type="number" name="firstCriticalValue[]" value="" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label>Final Critical Range</label>
                            <input class="form-control" type="number" name="finalCriticalValue[]" value="" step="1">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Normal Range</label>
                            <textarea class="form-control ckeditor" name="normalRange[]"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr class="hr1">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        var
            items = {{count($availableTest->TestReportItems->where("status","active")->where("table_num",1))}},
            items2 = {{count($availableTest->TestReportItems->where("status","active")->where("table_num",2))}},
            item_block = document.getElementById("report_item_class_js").innerHTML,
            item_block2 = document.getElementById("report_item_class2_js").innerHTML,
            inventory_block = 0,
            inventories = {{count($availableTest->available_test_inventories)}};

        if (!items) {
            items = 1;
        }
        if (!items2) {
            items2 = 1;
        }
        if (!inventories) {
            inventories = 1;
        }

        function add_item(id = "report_item_form") {
            if (id === "report_item_form" && items >= 0) {
                $("#" + id).append(item_block);
                items++;
            } else if (id === "report_item_form2" && items2 >= 0) {
                $("#" + id).append(item_block2);
                items2++;
            } else {
                console.log(id, items, items2);
            }
            editor_check();
        }

        function remove_item(class_name = "report_item_class") {
            var index_remove;
            console.log(items);
            if (class_name === "report_item_class" && items >= 1) {
                index_remove = document.getElementsByClassName(class_name).length - 1;
                document.getElementsByClassName(class_name)[index_remove].outerHTML = "";
                items--;
            } else if (class_name === "report_item_class2" && items2 >=  1) {
                index_remove = document.getElementsByClassName(class_name).length - 1;
                document.getElementsByClassName(class_name)[index_remove].outerHTML = "";
                items--;
            }
        }

        function add_inventory() {
            if (!inventory_block) {
                inventory_block = document.getElementsByClassName("inventory_item_class")[0].outerHTML;
            }
            if (inventories >= 1) {
                $("#inventory_item_form").append(inventory_block);
                inventories++;
            }
        }

        function remove_inventory() {
            if (inventories > 1) {
                var index_remove = document.getElementsByClassName("inventory_item_class").length - 1;
                document.getElementsByClassName("inventory_item_class")[index_remove].outerHTML = "";
                inventories--;
            }
        }

        editor_check();

        function editor_check() {
            if (document.getElementsByClassName("ckeditor").length) {
                Array.from(document.getElementsByClassName("ckeditor")).forEach(function (currentValue, index, arr) {
                    CKEDITOR.replace(currentValue, {
                        width: '100%',
                    });
                    currentValue.classList.remove("ckeditor");
                    // console.log(currentValue, index, arr);
                });
            }
        }

    </script>
@endsection