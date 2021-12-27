<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use Illuminate\Http\Request;
class InventoryController extends Controller
{
    public function index()
    {
        $inventoryes   = Inventory::all();
        return view('admin.inventory.index', compact('inventoryes'));
    }
    public function create()
    {
        return view('admin.inventory.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'inventoryName' => 'required|max:120', 
            'inventoryUnit' => 'required',
            'remainingItem' => 'required|max:9',

            ]);
        $input = $request->all();
        Inventory::create($input);
        return redirect()->route('inventory-list');
    }
    public function edit($id)
    {
        $inventoryes = Inventory::findOrFail($id);
        return view('admin.inventory.edit', compact('inventoryes'));
    }
    public function update($id, Request $request)
    {
        $this->validate($request,[
            'inventoryName' => 'required|max:120', 
            'inventoryUnit' => 'required',
            'remainingItem' => 'required|max:9',

            ]);
    $Inventoryes = Inventory::findOrFail($id);
    $input = $request->all();
    $Inventoryes->fill($input)->save();
    return redirect()->route('inventory-list');
    }
    public function show($id) 
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.inventory.show', compact('inventory'));
    }
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return redirect()->route('inventory-list');
    }
}
