<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\AvailableTest;
use App\Models\TestPerformed;
use Session;
use App\Models\Category;
use Gate;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestCatagoryController extends Controller
{
    public function index()
    {
        $categoryes   = Category::all();
        return view('admin.catagory.index', compact('categoryes'));
    }
    public function create()
    {
        return view('admin.catagory.create');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        Category::create($input);
        return redirect()->route('catagory-list');
    }
    public function edit($id)
    { 
        $catagory = Category::findOrFail($id);
        return view('admin.catagory.edit', compact('catagory'));
    }
    public function update($id, Request $request)
   {
        $catagoryId = Category::findOrFail($id);
        $input = $request->all();
        $catagoryId->fill($input)->save();
        return redirect()->route('catagory-list');
   }
    public function show($id) 
    {
        $testPerformeds = DB::table('test_performeds')
        ->join('patients', 'test_performeds.patient_id', '=', 'patients.id')
        ->join('available_tests', 'test_performeds.available_test_id', '=', 'available_tests.id')
        ->join('categories', '.available_tests.category_id', '=', 'categories.id')
        ->select('patients.Pname','available_tests.name','categories.Cname')
        ->where('available_tests.category_id', $id)
        ->orderBy('category_id', 'DESC')
        ->get();
        $catagoryId = Category::findOrFail($id);
        $testInThisCategory = $catagoryId->availableTest->pluck('name');
        return view('admin.catagory.show', compact('catagoryId','testInThisCategory','testPerformeds'));
    }
    public function destroy($id)
    {
        $catagoryId = Category::findOrFail($id);
        $catagoryId->delete();
        return redirect()->route('catagory-list');
    }
}
