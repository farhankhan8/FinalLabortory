<?php

namespace App\Http\Controllers;
use App\Models\PatientCategory;
use Session;
use Illuminate\Http\Request;

class PatientCategoryController extends Controller
{
    public function index()
    {
        $patientCategorys  = PatientCategory::all();
        return view('admin.patient.pcindex', compact('patientCategorys'));
    }
    public function create()
    {
        return view('admin.patient.pccreate');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'Pcategory' => 'required|max:120', 
            'discount' => 'required|max:2',
            ]);
        $patientCategoryes = PatientCategory::create($request->all());
        return redirect()->route('patient-category');
    }
    public function show($id)
    { 
        $patientCategory = PatientCategory::findOrFail($id);
         $getAllPatientsInCategorys = $patientCategory->getAllPatients;
        //  dd($a);
        return view('admin.patient.pcshow', compact('patientCategory','getAllPatientsInCategorys'));
    }
    public function edit($id)
    {
        $patientCategory = PatientCategory::findOrFail($id);
        return view('admin.patient.pcedit', compact('patientCategory'));
    }
    public function update($id, Request $request)
    {
        $this->validate($request,[
            'Pcategory' => 'required|max:120', 
            'discount' => 'required|max:2',
            ]);
        $patientCategory = PatientCategory::findOrFail($id);
        $input = $request->all(); 
        $patientCategory->fill($input)->save();
        return redirect()->route('patient-category');
    }
    public function destroy($id)
    {
        $patientCategory = PatientCategory::findOrFail($id);
        $patientCategory->delete();
        return redirect()->route('patient-category');
    }
}
