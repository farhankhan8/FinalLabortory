<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AvailableTest;
use App\Models\TestPerformed;
use App\Models\Inventory;
use App\Models\AvailableTestInventory;
use App\Models\TestperformedEditor;
use App\Models\TestperformedWidal;
use App\Models\TestReportItem;
use Carbon\Carbon;
use Session;
use App\Models\Category;
use Gate;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AvailableTestController extends Controller
{
    public function index()
    {
        $availableTests = AvailableTest::all();
        return view('admin.availableTests.index', compact('availableTests'));
    }

    public function create()
    {
        $inventoryes = Inventory::all()->pluck('inventoryName', 'id')->prepend(trans('global.pleaseSelect'), '');
        $categoryNames = Category::all()->pluck('Cname', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.availableTests.create', compact('categoryNames', 'inventoryes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:available_tests|min:5',
        ]);

        $data_report_items = [];
        if (isset($request->title))
            foreach ($request->title as $key => $value) {
                if ($value == null  || $value == "")
                    continue;
                $data_report_items[] = new TestReportItem([
                    "title" => $value,
                    'item_index' => $request->order[$key],
                    'normalRange' => $request->normalRange[$key],
                    // 'finalNormalValue' => $request->finalNormalValue[$key],
                    'firstCriticalValue' => $request->firstCriticalValue[$key],
                    'finalCriticalValue' => $request->finalCriticalValue[$key],
                    'unit' => $request->units[$key],
                ]);
            }
        //for type 5 (two tables)
        if (isset($request->title2))
            foreach ($request->title2 as $key => $value) {
                if ($value == null  || $value == "")
                    continue;
                $data_report_items[] = new TestReportItem([
                    "title" => $value,
                    'item_index' => $request->order2[$key],
                    "table_num"=>2,
                    'normalRange' => $request->normalRange2[$key],
                    // 'finalNormalValue' => $request->finalNormalValue[$key],
                    'firstCriticalValue' => $request->firstCriticalValue2[$key],
                    'finalCriticalValue' => $request->finalCriticalValue2[$key],
                    'unit' => $request->units2[$key],
                ]);
            }

        $a = count($data_report_items);
        $availableTestId = AvailableTest::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'testFee' => $request->testFee,
            'urgentFee' => $request->urgentFee,
            'stander_timehour' => $request->stander_timehour,
            'urgent_timehour' => $request->urgent_timehour,
            'resultValueCount' => $a,
            'type' => $request->type,
            'testCode' => $request->testCode,

        ]);
        //available_test_inventories
        $data = [];
        if ($request->inventory_ids[0] !== null) {
            foreach ($request->inventory_ids as $key => $value) {
                $data[] = new AvailableTestInventory([
                    "inventory_id" => $value,
                    "itemUsed" => $request->inventory_quantity[$key]
                ]);
            }
            if (!empty($data)) {
                $availableTestId->available_test_inventories()->saveMany($data);
            }
        }
        //        $data = [];
//        if (isset($request->heading)) {
            //            foreach ($request->title as $key => $value) {
            //                $data[] = new TestReportItem([
            //                    "title" => $value,
            //                    'normalRange' => $request->normalRange[$key],
            //                    // 'finalNormalValue' => $request->finalNormalValue[$key],
            //                    'firstCriticalValue' => $request->firstCriticalValue[$key],
            //                    'finalCriticalValue' => $request->finalCriticalValue[$key],
            //                    'unit' => $request->units[$key],
            //                ]);
            //            }
            //            $a = count($data);
            //            AvailableTest::where('id', $availableTestId)->update(array('resultValueCount' => $a));
            if (!empty($data_report_items)) {
                $availableTestId->TestReportItems()->saveMany($data_report_items);
//            }
        }
        return redirect()->route('available-tests');
    }

    public function edit($id)
    {
        $availableTest = AvailableTest::findOrFail($id);
        $catagorys = Category::all()->pluck('Cname', 'id')->prepend(trans('global.pleaseSelect'), '');
        $inventoryes = Inventory::all()->pluck('inventoryName', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.availableTests.edit', compact('availableTest', 'catagorys', "inventoryes"));
    }

    public function update($id, Request $request)
    {
        $task = AvailableTest::findOrFail($id);
//        $input = $request->all();
        $task->fill([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'testFee' => $request->testFee,
            'urgentFee' => $request->urgentFee,
            'stander_timehour' => $request->stander_timehour,
            'urgent_timehour' => $request->urgent_timehour,
            'testCode' => $request->testCode,


        ])->save();

        //inventory
        $data = [];

        $task->available_test_inventories()->delete();
        if (isset($request->inventory_ids)) {
            foreach ($request->inventory_ids as $key => $value) {
                //agr inventory set ni ha to
                if ($value == null)
                    continue;
                // if (in_array($value, $task->available_test_inventories()->pluck("inventory_id")->all())) {
                //     $task->available_test_inventories()->where("inventory_id", $value)->first()->update([
                //         "itemUsed" => $request->inventory_quantity[$key]
                //     ]);
                //     continue;
                // }
                $data[] = new AvailableTestInventory([
                    "inventory_id" => $value,
                    "itemUsed" => $request->inventory_quantity[$key]
                ]);
            }
            if (count($data))
                $task->available_test_inventories()->saveMany($data);
        }


//        dd($task->TestReportItems,$request->all());
        //TestReportItems
        $data_report_items = [];
        if (isset($request->title)) {
            $task->TestReportItems()->where("table_num",1)->where("test_id",$task->id)->whereNotIn("title",$request->title)->whereNotIn("status", ["inactive", "deleted"])->update([
                "status" => "inactive"
            ]);
            foreach ($request->title as $key => $value) {
                if ($value == null)
                    continue;
                $title_exist=$task->TestReportItems()->where("table_num",1)->where("test_id",$task->id)->where("title",$value)->whereNotIn("status", ["inactive", "deleted"])->first();

                if ($title_exist){
                    $title_exist->update([
                        'normalRange' => $request->normalRange[$key],
                        'item_index' => $request->order[$key],
                        "table_num"=>1,
                        // 'finalNormalValue' => $request->finalNormalValue[$key],
                        'firstCriticalValue' => $request->firstCriticalValue[$key],
                        'finalCriticalValue' => $request->finalCriticalValue[$key],
                        'unit' => $request->units[$key],
                    ]);
                    continue;
                }
                else{
                     $data_report_items[] = new TestReportItem([
                        "title" => $value,
                        'item_index' => $request->order[$key],
                        "table_num"=>1,
                        'normalRange' => $request->normalRange[$key],
                        // 'finalNormalValue' => $request->finalNormalValue[$key],
                        'firstCriticalValue' => $request->firstCriticalValue[$key],
                        'finalCriticalValue' => $request->finalCriticalValue[$key],
                        'unit' => $request->units[$key],
                    ]);
                }
            }

        }
        //fot type 5 test two tables
        if (isset($request->title2)) {
            $task->TestReportItems()->where("table_num",2)->where("test_id",$task->id)->whereNotIn("title",$request->title2)->whereNotIn("status", ["inactive", "deleted"])->update([
                "status" => "inactive"
            ]);
            foreach ($request->title2 as $key => $value) {
                if ($value == null)
                    continue;
                $title_exist=$task->TestReportItems()->where("table_num",2)->where("test_id",$task->id)->where("title",$value)->whereNotIn("status", ["inactive", "deleted"])->first();

                if ($title_exist){
                    $title_exist->update([
                        'normalRange' => $request->normalRange2[$key],
                        'item_index' => $request->order2[$key],
                        "table_num"=>2,
                        'firstCriticalValue' => $request->firstCriticalValue2[$key],
                        'finalCriticalValue' => $request->finalCriticalValue2[$key],
                        'unit' => $request->units2[$key],
                    ]);
                    continue;
                }
                else{
                    $data_report_items[] = new TestReportItem([
                        "title" => $value,
                        'item_index' => $request->order2[$key],
                        "table_num"=>2,
                        'normalRange' => $request->normalRange2[$key],
                        'firstCriticalValue' => $request->firstCriticalValue2[$key],
                        'finalCriticalValue' => $request->finalCriticalValue2[$key],
                        'unit' => $request->units2[$key],
                    ]);
                }
            }
        }
        if (count($data_report_items)){
            $task->TestReportItems()->saveMany($data_report_items);
        }
        return redirect()->route('available-tests');
    }

    public function show($id)
    {
        $availableTestId = AvailableTest::findOrFail($id);
        return view('admin.availableTests.show', compact('availableTestId'));
    }

    public function destroy($id)
    {
        $task = AvailableTest::findOrFail($id);
        $task->delete();
        return redirect()->route('available-tests');
    }
}
