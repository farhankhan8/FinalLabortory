@extends('layouts.admin')
@section('content')
    <style>
        hr {
            border-top: 1px solid rgb(47 53 58);
        }

        .hr1 {
            border-top: 1px dashed #777;
        }

        .parent {
            display: flex;
            width: 1100px;
        }

        .parent input {

            width: 200px;
            margin-left: 10px;
        }

        .total_price {
            font-size: 22px;
            font-weight: bold;
        }


        .parent p {
            /* width:100%; */
            margin-top: 7px;
            margin-left: 10px;

        }

        .parent button {
            width: 100px;
            height: 35px;
            /* margin-top:10px; */
            margin-left: 10px;
            /* padding-top: -2px; */

        }


    </style>

    <div class="card">
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(\Session::has('success'))
            <div class="alert alert-danger">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <div class="card-header">
            Performed New Test
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('test-performed') }}" id="test_form" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="required" for="patient_id">Select Patient Name</label>
                            <select onchange="set_patient()" data-placeholder="Select Patient" class="form-control select2 {{ $errors->has('patients') ? 'is-invalid' : '' }}" name="patient_id" id="patient_id" required>
                                @foreach($patientNames as $patientName)
                                    <option patientName="{{$patientName->Pname}}" discount="{{ $patientName->category->discount }}" value="{{ $patientName->id }}">{{ $patientName->Pname }} ({{ $patientName->id }})</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
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
                            <label class="" for="referred">Referred By</label>
                            <input class="form-control {{ $errors->has('referred') ? 'is-invalid' : '' }}" type="text" name="referred" id="referred" value="{{ old('referred', '') }}">
                            @if($errors->has('referred'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('referred') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                </div>


                <div id="test_block">
                    <div class="form-row test_form_div">

                        <div class="col-md-3 col-6 mb-3">
                            <div class="form-group">
                                <label for="available_test_id" class="required">Select Test Name</label>
                                <select class="form-control select2  {{ $errors->has('available_tests') ? 'is-invalid' : '' }}" onchange="set_test_form(this)" name="available_test_id[]" id="available_test_id">
                                <option selected> Please select</option>
                                @foreach($availableTests as   $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}({{ $item->testCode}})</option>
                                @endforeach
                                </select>
                                @if($errors->has('available_tests'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('available_tests') }}
                                    </div>
                            @endif
                            <!-- ziyad -->
                                <small id="name_error" style="color: red"></small>
                                <!-- ziyad -->
                            </div>
                        </div>

                        <div class="col-md-3 col-12 mb-3">
                            <div class="form-group">
                                <label for="type" class="required">Test Type</label>
                                <select class="form-control" name="type[]" id="type">
                                    <option value="standard" selected>Standard<p class="standard_fee"></p></option>
                                    <option value="urgent">Urgent<p class="urgent_fee"></p></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-3 ml-2" style="padding-top: 28px;">
                            <button type="button" class="btn btn-success add_btn " id="">Add Test</button>
                            <br/>
                        </div>

                        <div class="col-12 mt-2 mb-2" id="all"></div>

                        <div class="col-md-3 mb-2 mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Concession</span>
                                </div>
                                <input oninput="updateConcession()" name="concession" type="number" class="form-control concession">
                            </div>
                        </div>

                        <div class="total_price col-12"></div>
                        <div class="discountText col-12"></div>
                        <div class="d-none username">{{Auth::user()->name}}</div>

                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-lg save_btn" type="submit">Save</button>
                    </div>
                </div>
            </form>
        
        </div>
        <div class="alert alert-danger error_msg text-center" style="display: none"></div>

        <div>
            @foreach($allAvailableTests as $test)

                <script>
                    var test{{$test->id}}_standard ={{$test->testFee}};
                    var test{{$test->id}}_urgent ={{$test->urgentFee}};
                </script>

            @endforeach
        </div>
    </div>

    <script>

        let arr = Array.from(Array(100).keys(), n => n + 1);
        let DiscountPercentage = 0;
        let final_fee = 0;
        let username = $(".username").text();

        set_patient();
        make_receipt();

        function set_patient() {
            DiscountPercentage = Number($('#patient_id option:selected').attr('discount'))
            updateFee()
        }
        

        function make_receipt(){

            $( ".save_btn" ).click(function() {
                let Receipt_styles = "<style>"
                Receipt_styles+=".receipt_con{font-family: Arial; width:300px; margin: 0 auto; border-radius: 5px; margin-bottom: 10px; border: 1px solid black; padding: 20px;}"
                Receipt_styles+=".receipt_con h2{text-align: center; margin-top:0;}"
                Receipt_styles+=".receipt_con table{text-align: left; width: 100%}"
                Receipt_styles+="</style>"

                let d = Date.now();
                d = new Date(d);
                let date = d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear();
                let t = (d.getHours() > 12 ? d.getHours() - 12 : d.getHours())+':'+d.getMinutes()+' '+(d.getHours() >= 12 ? "PM" : "AM");

                let Receipt_html = Receipt_styles+"<div class='receipt_con'><h2>USAE Laboratory</h2>";
                Receipt_html+="<table class='table'><tr><td>Patient's name</td><td>"+$('#patient_id option:selected').attr('patientName').trim()+"</td></tr>"
                Receipt_html+="<tr><td>MR ID</td><td>"+$("#patient_id").val()+"</td></tr>"
                Receipt_html+="<tr><td>Date</td><td>"+date+"</td></tr>"
                Receipt_html+="<tr><td>Time</td><td>"+t+"</td></tr>"
                Receipt_html+="<tr><td>Lab attendant</td><td>"+username+"</td></tr></table><hr />"
                Receipt_html+="<table><tr><th>Test</th><th>Fee</th></tr>"

                $( ".parent" ).each(function() {
                    Receipt_html=Receipt_html+"<tr><td>"+$( this ).find(".name").val()+"</td><td>Rs "+$( this ).find(".fees").val()+"</td></tr>";
                });
                Receipt_html+="<tr><td> </td><td> </td></tr>"

                Receipt_html+="<tr><td> </td><td> </td></tr>"
                let concessionVal = $(".concession").val();
                if(Number(concessionVal) > 0){
                    Receipt_html+="<tr><td>Discount</td><td>Rs "+Number(concessionVal)+"</td></tr>"
                }
                Receipt_html+="<tr><td><strong>Total</strong></td><td>Rs "+$(".finalfee").html()+"</td></tr>"
                Receipt_html+="</table>";
                Receipt_html+="</div>";
                console.log(Receipt_html);
                var newWin = open('','Print Receipt','width=300');
                newWin.document.write(Receipt_html);
                newWin.print()
            });
        }

        // upon selecting test
        function set_test_form(select) {
            //console.log(eval("test" + select.value + "_urgent"))
            if (select.value) {
                //select.parentElement.parentElement.parentNode.getElementsByClassName("test_form")[0].innerHTML = eval("test" + select.value);
                document.getElementById("type").getElementsByTagName("option")[1].innerText = "Urgent" + "(" + eval("test" + select.value + "_urgent") + ")";
                document.getElementById("type").getElementsByTagName("option")[0].innerText = "Standard" + "(" + eval("test" + select.value + "_standard") + ")";

                let st = document.getElementById("type").getElementsByTagName("option")[0].innerText,
                    ur = document.getElementById("type").getElementsByTagName("option")[1].innerText,
                    st_num = st.replace(/\D/g, ''),
                    ur_num = ur.replace(/\D/g, '');

                $(".add_btn").attr("standardfee", st_num);
                $(".add_btn").attr("urgentfee", ur_num);
            } else {
                select.parentElement.parentElement.parentNode.getElementsByClassName("test_form")[0].innerHTML = "";
                select.parentElement.parentElement.parentNode.getElementsByClassName("urgent_fee")[0].innerText = "";
                select.parentElement.parentElement.parentNode.getElementsByClassName("standard_fee")[0].innerText = "";
            }


            if (select.parentElement.parentElement.parentElement.getElementsByClassName("ckeditor")[0]) {
                CKEDITOR.replace(select.parentElement.parentElement.parentElement.getElementsByClassName("ckeditor")[0], {
                    width: '100%',
                });
            }


        }

        //show input data
        let add_btn = document.querySelector('.add_btn');
        add_btn.onclick = function (e) {
            //'ziyad'
            let all = document.getElementById('all'),
                type = document.getElementById("type").value,
                fee,
                name = document.getElementById('available_test_id'),
                name_value = document.getElementById('available_test_id').value,
                text = name.options[name.selectedIndex].text,
                error_ele = document.getElementById('name_error'),
                //random_num       = Math.floor((Math.random() * 10000) + 1);
                random_num = arr.shift();

            //console.log(arr);

            if (!fee) {
                if (type == 'standard') {
                    let st = $(".add_btn").attr("standardfee");
                    fee = st
                } else {
                    let ur = $(".add_btn").attr("urgentfee");
                    fee = ur
                }
            }

            if (!name_value) {
                error_ele.textContent = 'You should select test name';
                return
            }


            all.insertAdjacentHTML('beforeend',

                '<div class="ele' + random_num + ' parent">' +
                '<input value="' + name_value + '" name="available_test_ids[]" style="display:none"  >' + '</input><br/>' +
                '<p>Test Name </p>' + '<input readonly   value="' + text + '" class="name form-control">' + '</input>' +

                '<p>Test Type</p>' + '<input readonly class="type form-control" name="types[]" value="' + type + '">' + '</input>' +
                '<p>Test Fee </p>' + '<input readonly class="fees form-control" name="fees[]" id="fees_id' + random_num + '" value="' + fee + '">' + '</input>' +


                '<small class="concession_error' + random_num + '" style="color:red">' + '</small>' +
                '<button type="button"  class=" btn' + random_num + ' btn btn-danger" id="' + random_num + '">Remove Test</button>' +

                '</div>'
            );

            //document.getElementById('fee_final').value=''
            document.getElementById("type").value = 'standard';
            document.getElementById('available_test_id').value = '';
            $("#available_test_id").val(null);

            updateFee();

            //delete record
            let delete_btn = document.querySelector('.btn' + random_num);
            delete_btn.onclick = function (e) {
                let id = e.target.id,
                    test_elements = document.getElementsByClassName('ele' + id)[0];

                test_elements.remove();
                updateFee();
            }
        };

        function updateFee() {

            final_fee = 0;
            let total_fees_test = document.getElementsByClassName('fees');
            for (let i = 0; i < total_fees_test.length; i++) {
                final_fee += Number(total_fees_test[i].value)
            }

            if (DiscountPercentage >= 0) {
                $(".discountText").html("Discount of " + DiscountPercentage + "% for this patient");
                $(".concession").val(Math.round((DiscountPercentage / 100) * final_fee));
            }

            let concessionVal = $(".concession").val();

            //console.log(final_fee);
            if (final_fee === 0) {
                $(".total_price").html("");
            } else if (final_fee <= concessionVal) {
                $(".total_price").html("Concession should be less than total fee");
            } else {
                $(".total_price").html("Total price: Rs <span class='finalfee'>" + (final_fee - concessionVal) + "</span>");
            }
        }

        function updateConcession() {
            let concessionVal = $(".concession").val();
            //console.log(final_fee);
            if (final_fee === 0) {
                $(".total_price").html("");
            } else if (final_fee <= concessionVal) {
                $(".total_price").html("Concession should be less than total fee");
            } else {
                $(".total_price").html("Total price: Rs <span class='finalfee'>" + (final_fee - concessionVal) + "</span>");
            }
        }

    </script>
@endsection
