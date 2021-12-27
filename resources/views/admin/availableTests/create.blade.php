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
            Create New Test
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('availale-tests-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-12"><h4>Basic</h4></div>
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom01">Test Category</label>
                        <select class="form-control select2 {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                            @foreach($categoryNames as $id => $categoryName)
                                <option value="{{ $id }}">{{ $categoryName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="" for="name">Test Name</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
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
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="" for="testCode">Test Code</label>
                            <input class="form-control {{ $errors->has('testCode') ? 'is-invalid' : '' }}" type="text" name="testCode" id="testCode" value="{{ old('testCode', '') }}" required>
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
                    <div class="col-md-2 mb-3">
                        <label for="validationCustomUsername">Standard Charges</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rs</span>
                            </div>
                            <input class="form-control {{ $errors->has('testFee') ? 'is-invalid' : '' }}" type="number" name="testFee" id="testFee" value="{{ old('testFee', '') }}" step="1" required>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="urgentFee">Urgent Charges</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="urgentFee">Rs</span>
                            </div>
                            <input class="form-control {{ $errors->has('urgentFee') ? 'is-invalid' : '' }}" type="number" name="urgentFee" id="urgentFee" value="{{ old('urgentFee', '') }}" step="1" required>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="timehour">Standard Completed time</label>
                        <div class="input-group">
                            <input type="text" name="stander_timehour" class="form-control" id="duration"required>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="urgent_timehour">Urgent Completed time</label>
                        <div class="input-group">
                            <input type="text" name="urgent_timehour" class="form-control" id="duration2"required>
                        </div>
                    </div>
                    {{--type--}}
                    <div class="col-md-6 mb-6">
                        <label for="">Test Type</label>
                        <br>
                        <div class="form-check form-check-inline my-1">
                            <input id="normal" class="form-check-input" type="radio" name="type" value="1" checked onchange="change_type(this);">
                            <label class="form-check-label" for="normal">Normal</label>
                        </div>
                        <div class="form-check form-check-inline my-1">
                            <input id="editor" class="form-check-input" type="radio" name="type" value="2" onchange="change_type(this);">
                            <label class="form-check-label" for="editor">Editor</label>
                        </div>

                        <div class="form-check form-check-inline my-1">
                            <input id="widal" class="form-check-input" type="radio" name="type" value="4" onchange="change_type(this);">
                            <label class="form-check-label text-capitalize" for="widal">Widal</label>
                        </div>
                        <div class="form-check form-check-inline my-1">
                            <input id="two-table" class="form-check-input" type="radio" name="type" value="5" onchange="change_type(this);">
                            <label class="form-check-label text-capitalize" for="two-table">Two Table</label>
                        </div>
                    </div>

                </div>
                <hr class="hr1">
                <div class="col-12" id="items_main_div">
                    <div class="form-row" id="result_section">
                        <div class="col-md-12 mb-12"><h4>Result Values</h4></div>
                        <div class="col-md-12" id="report_item_form">
                            <div class="form-row report_item_class">

                                <div class="col-md-4 mb-3">
                                    <label for="">Order</label>
                                    <input class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" type="number" step="1" min="1" name="order[]" value="1"required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label class="">Title</label>
                                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title[]" value="{{ old('title[]', '') }}"required>
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
                                    <label>Test Unit</label>
                                    <input class="form-control {{ $errors->has('units') ? 'is-invalid' : '' }}" type="text" name="units[]" value="{{ old('units[]', '') }}"required>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label>First Critical Value</label>
                                    <input class="form-control {{ $errors->has('firstCriticalValue') ? 'is-invalid' : '' }}" type="number" name="firstCriticalValue[]" value="{{ old('firstCriticalValue[]', '') }}" step="1"required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label>Final Critical Value</label>
                                    <input class="form-control {{ $errors->has('finalCriticalValue') ? 'is-invalid' : '' }}" type="number" name="finalCriticalValue[]" value="{{ old('finalCriticalValue[]', '') }}" step="1"required>
                                </div>
                                <div class="col-md-12 mb-0">
                                    <div class="form-group">
                                        <label>Normal Range</label>
                                        <textarea class="form-control ckeditor {{ $errors->has('normalRange') ? 'is-invalid' : '' }}" name="normalRange[]" rows="0" placeholder="Enter Normal Range of Test As This Format 60-120"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr class="hr1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="button" onclick="add_item()" class="btn btn-xs btn-success">Add Item</button>
                            <button type="button" onclick="remove_item()" class="btn btn-xs btn-danger">Remove Item</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-12 mb-12"><h4>Inventory</h4></div>
                    <div class="col-md-12" id="inventory_item_form">
                        <div class="form-row inventory_item_class">
                            <div class="col-md-6 mb-6">
                                <label>Inventory Item</label>
                                <select class="form-control  {{ $errors->has('inventory_id') ? 'is-invalid' : '' }}" name="inventory_ids[]">
                                    @foreach($inventoryes as $key=>$value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-6">
                                <label>Quantity</label>
                                <input class="form-control {{ $errors->has('inventory_quantity') ? 'is-invalid' : '' }}" type="number" name="inventory_quantity[]" value="" step="1">
                            </div>
                            <hr class="hr1">

                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="button" onclick="add_inventory()" class="btn btn-xs btn-success">Add Inventory</button>
                        <button type="button" onclick="remove_inventory()" class="btn btn-xs btn-danger">Remove Inventory</button>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
    </div>
    {{--    for js of type 5--}}

        <div class="form-row d-none" id="result_section2">
            <div class="col-md-12 mb-12"><h4>Result Values 2</h4></div>
            <div class="col-md-12" id="report_item_form2">
                <div class="form-row report_item_class2">

                    <div class="col-md-4 mb-3">
                        <label for="">Order</label>
                        <input class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" type="number" step="1" min="1" name="order2[]" value="1"required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="">Title</label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title2[]" value="{{ old('title2[]', '') }}"required>
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
                        <label>Test Unit</label>
                        <input class="form-control {{ $errors->has('units') ? 'is-invalid' : '' }}" type="text" name="units2[]" value="{{ old('units2[]', '') }}"required>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>First Critical Value</label>
                        <input class="form-control {{ $errors->has('firstCriticalValue') ? 'is-invalid' : '' }}" type="number" name="firstCriticalValue2[]" value="{{ old('firstCriticalValue2[]', '') }}" step="1"required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Final Critical Value</label>
                        <input class="form-control {{ $errors->has('finalCriticalValue') ? 'is-invalid' : '' }}" type="number" name="finalCriticalValue2[]" value="{{ old('finalCriticalValue2[]', '') }}" step="1"required>
                    </div>
                    <div class="col-md-12 mb-0">
                        <div class="form-group">
                            <label>Normal Range</label>
                            <textarea class="form-control ckeditor {{ $errors->has('normalRange') ? 'is-invalid' : '' }}" name="normalRange2[]" rows="0" placeholder="Enter Normal Range of Test As This Format 60-120"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr class="hr1">
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <button type="button" onclick="add_item('report_item_form2')" class="btn btn-xs btn-success">Add Item</button>
                <button type="button" onclick="remove_item('report_item_class2')" class="btn btn-xs btn-danger">Remove Item</button>
            </div>
        </div>

    <script>
        var items = 1, items2 = 1, item_block = 0, inventories = 1, inventory_block = 0;
        item_block = document.getElementById("report_item_form").innerHTML;
        item_block2 = document.getElementById("report_item_form2").innerHTML;

        function add_item(id = "report_item_form") {
            if (id==="report_item_form" && items >= 1) {
                $("#" + id).append(item_block);
                items++;
            }else if(id==="report_item_form2" && items2 >= 1){
                $("#" + id).append(item_block2);
                items2++;
            }
            else {
                console.log(id,items,items2);
            }
            editor_check();
        }

        function remove_item(class_name = "report_item_class") {
            var index_remove;
            if (class_name === "report_item_class" && items > 1) {
                index_remove = document.getElementsByClassName(class_name).length - 1;
                document.getElementsByClassName(class_name)[index_remove].outerHTML = "";
                items--;
            }else if (class_name === "report_item_class2" && items2 > 1) {
                index_remove = document.getElementsByClassName(class_name).length - 1;
                document.getElementsByClassName(class_name)[index_remove].outerHTML = "";
                items--;
            }
        }

        function add_inventory() {
            if (!inventory_block) {
                inventory_block = document.getElementById("inventory_item_form").innerHTML;
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

        var result_section = document.getElementById("result_section").innerHTML;
        var result_section2 = document.getElementById("result_section2").innerHTML;

        function change_type(a) {
            if (a.value == "2" || a.value == "3" || a.value == "4") {
                document.getElementById("result_section").innerHTML = "";
            } else if (a.value == "1") {
                document.getElementById("result_section").innerHTML = result_section;
            } else if (a.value == "5") {
                document.getElementById("result_section").innerHTML = result_section;
                document.getElementById("result_section").insertAdjacentHTML( 'beforeend', result_section2);
            }
            else {
                document.getElementById("result_section").innerHTML = "";
            }
            editor_check();
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