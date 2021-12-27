<?php

namespace App\Http\Controllers;

use App\Models\TestperformedEditor;
use App\Models\TestperformedWidal;
use App\Models\TestReport;
use App\Models\AvailableTest;
use App\Models\Patient;
use App\Models\TestPerformed;
use App\Models\Status;
use App\Models\Category;
use Carbon\Carbon;
use DB;
use Session;
use Gate;
use Illuminate\Http\Request;

class TestsPerformedController extends Controller
{
    public function index()
    {
        $testPerformeds = TestPerformed::join('patients', 'test_performeds.patient_id', '=', 'patients.id')
            ->join('available_tests', 'test_performeds.available_test_id', '=', 'available_tests.id')
            ->join('categories', '.available_tests.category_id', '=', 'categories.id')
            ->select('test_performeds.*', 'patients.Pname', 'patients.dob', 'available_tests.name', 'available_tests.stander_timehour', 'available_tests.urgent_timehour',
                'available_tests.testFee', 'categories.Cname', 'test_performeds.created_at', 'test_performeds.specimen')
            ->orderBy('patient_id', 'DESC')
            ->get();
        return view('admin.TestPerformed.index', compact('testPerformeds'));
    }

    public function create()
    { 
        $patientNames = Patient::with('category')->get();
        $availableTests = AvailableTest::get(['name', 'testCode', 'id']);
        //dd($patientNames);
        // $availableTests = AvailableTest::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $allAvailableTests = AvailableTest::all();
        return view('admin.TestPerformed.create', compact('patientNames', 'availableTests', "allAvailableTests"));
    }

    public function store(Request $request)
    {

        $patient = Patient::findorfail($request->patient_id);
        if (!$patient)
            return abort(503, "Invalid request");

        //                dd($request->all());
        $specimen = "";
        if(!$request->available_test_ids)
          return back()->with('success','Test field is required');

        $num_of_tests = count($request->available_test_ids);
        $each_test_concession = (int) $request->concession / (int) $num_of_tests;

        foreach ($request->available_test_ids as $key => $available_test_id) {
            //this is to count that how much tests of same type are performed so values can be accessed by index
            if (isset(${"test" . $available_test_id})) {
                ${"test" . $available_test_id}++;
            } else {
                ${"test" . $available_test_id} = 0;
            }
            //            dd(isset(${"test".$available_test_id}),${"test".$available_test_id});


            $available_test = AvailableTest::findorfail($available_test_id);
            if (!$available_test)
                return abort(503, "Invalid request");

            //inventory
            foreach ($available_test->available_test_inventories as $test_inventory) {
                $test_inventory->inventory->update([
                    "remainingItem" => $test_inventory->inventory->remainingItem - $test_inventory->itemUsed
                ]);
            }

            //fee
            if (isset($request->fees[$key]) && $request->fees[$key])
                $fee = $request->fees[$key] - $each_test_concession;
            // else {
            //     $fee = $request->types[$key] == "urgent" ? $available_test->urgentFee : $available_test->testFee;
            //     if ($patient->category && $patient->category->discount)
            //         $fee = $fee - ($fee * $patient->category->discount / 100);
            // }

            if ($specimen == "") {
                $specimen = "S-" . Carbon::now()->format("y") . "-" . TestPerformed::next_id();
            }

            //store
            $test_performed = new TestPerformed();
            $test_performed->available_test_id = $available_test_id;
            $test_performed->patient_id = $request->patient_id;
            $test_performed->type = $request->types[$key];
            $test_performed->specimen = $specimen;
            $test_performed->fee = $fee;

            if (!empty($request->comments[$key])) {
                $test_performed->comments = $request->comments[$key];
            } else {
                $test_performed->comments = '';
            }
            if (!empty($request->referred[$key])) {
                $test_performed->referred = $request->referred[$key];
            } else {
                $test_performed->referred = '';
            }
                $test_performed->status = 'process';

            $test_performed->save();
            //dd($test_performed);

            if ($available_test->type == 1 || $available_test->type == 5) {
                //test_report store
                foreach ($available_test->TestReportItems->where("status", "active")->pluck("id") as $value) {
                    $field_name = "testResult" . $value;
                    // if (!$request->$field_name[${"test" . $available_test_id}])
                    //dd($field_name, $request->$field_name[${"test" . $available_test_id}], $request->all());

                    TestReport::create([
                        'test_performed_id' => $test_performed->id,
                        'test_report_item_id' => $value,
                        // 'value' => $request->$field_name[${"test" . $available_test_id}],
                    ]);
                }
                if ($available_test->type==5){
                    TestperformedWidal::create([
                        "test_performed_id" => $test_performed->id,
                        "type"=>"test_performed_heading",
                        "value"=>""
                    ]);
                }
            } elseif ($available_test->type == 2) {
                $field_name = "ckeditor";
                TestperformedEditor::create([
                    'test_performed_id' => $test_performed->id,
                    // 'editor' => $request->$field_name[${"test" . $available_test_id}]
                ]);
            }
        }
        return redirect()->route('tests-performed');
    }

    public function edit($id)
    {
        $performed = TestPerformed::with('AvailableTest')->get()->find($id);
        //dd($performed);
        $getNameFromAvailbles = AvailableTest::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $patientNames = Patient::all()->pluck('Pname', 'id')->prepend(trans('global.pleaseSelect'), '');
        $allAvailableTests = AvailableTest::all();

        return view('admin.TestPerformed.edit', compact("allAvailableTests", 'performed', 'getNameFromAvailbles', 'patientNames'));
    }

    public function update($id, Request $request)
    {
        //        dd($request->all());
        $test_performed = TestPerformed::findOrFail($id);
        $available_test = AvailableTest::findorfail($request->available_test_id);
        //$patient = Patient::findorfail($request->patient_id);
        if ( !$available_test || !$test_performed)
            return abort(503, "Invalid Request");
        //        store
        $test_performed->update([
            'status' => $request->status,
            "comments" => $request->comments,
        ]);

        if ($test_performed->availableTest->type == 1 || $test_performed->availableTest->type == 5) {
            //test_report store
            $delete_items = $test_performed->testReport->pluck("id")->all();

            $created = 0;
            foreach ($available_test->TestReportItems->where("status", "active")->pluck("id") as $value) {
                $field_name = "testResult" . $value;
                $test_report_new = new TestReport();
                $test_report_new->test_performed_id = $test_performed->id;
                $test_report_new->test_report_item_id = $value;
                if (isset($request->$field_name))
                    $test_report_new->value = $request->$field_name;
                $test_report_new->save();

                //                TestReport::create([
                //                    'test_performed_id' => $test_performed->id,
                //                    'test_report_item_id' => $value,
                //                    'value' => $request->$field_name,
                //                ]);
                $created++;
            }
            if ($created) {
                TestReport::whereIn("id", $delete_items)->each(function ($item, $key) {
                    $item->delete();
                });
            }
//            for test type 5 two tables
            if (isset($request->heading))
            TestperformedWidal::where("test_performed_id",$test_performed->id)->where("type","test_performed_heading")->update([
                "value"=>$request->heading
            ]);
        } elseif ($test_performed->availableTest->type == 2) {
            $test_performed->testPerformedEditor->update([
                "editor" => $request->ckeditor
            ]);
        } elseif ($test_performed->availableTest->type == 3) {
            TestperformedWidal::where("test_performed_id", $test_performed->id)->delete();
            $data = [];
            $fields = ["pro_test_time", "pro_control_time", "aptt_test_time", "aptt_control_time"];
            foreach ($fields as $field) {
                if (isset($request->$field)) {
                    $data[] = [
                        'test_performed_id' => $test_performed->id,
                        'type' => $field,
                        'value' => $request->$field,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }
            TestperformedWidal::insert($data);
//            dd($request->all());
        } elseif ($test_performed->availableTest->type == 4) {
            //dd($request->all());
            $data = [];
            $fields = ["to", "th", "ao", "ah", "bo", "bh"];
            TestperformedWidal::where("test_performed_id", $test_performed->id)->delete();
            foreach ($fields as $field) {
                if (isset($request->$field)) {
                    foreach ($request->$field as $value) {
                        $data[] = [
                            'test_performed_id' => $test_performed->id,
                            'type' => $field . "_" . $value,
                            'value' => 'true',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                    }
                }
            }

            if (isset($request->widal_result)) {
                $data[] = [
                    'test_performed_id' => $test_performed->id,
                    'type' => 'widal_result',
                    'value' => $request->widal_result,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            TestperformedWidal::insert($data);
        }
        return redirect()->route('tests-performed');
    }

    public function show($id)
    {
        $testPerformedsId = TestPerformed::findOrFail($id);
        $getpatient = $testPerformedsId->patient;
        return view('admin.TestPerformed.show', compact('testPerformedsId', 'getpatient'));
    }

    public function showDataOfTestPerformedTable($id)
    {
        $testPerformedsId = TestPerformed::findOrFail($id);
        $availableTestId = $testPerformedsId->availableTest;
        return view('admin.TestPerformed.showData', compact('testPerformedsId', 'availableTestId'));
    }

    public function destroy($id)
    {
        $task = TestPerformed::findOrFail($id);
        $task->delete();
        Session::flash('flash_message', 'Task successfully deleted!');
        return redirect()->route('tests-performed');
    }
}
