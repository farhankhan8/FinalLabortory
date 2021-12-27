@extends('layouts.admin')
  @section('content')
    <div class="card">
      <div class="card-header">
        Create New Inventory
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route("inventory-store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inventoryName">Enter Inventory Name</label>
                <input class="form-control {{ $errors->has('inventoryName') ? 'is-invalid' : '' }}" type="text" name="inventoryName" id="inventoryName" value="{{ old('inventoryName', '') }}"required>
              </div>
              <div class="form-group col-md-4 ">
               <label for="inventoryUnit">Inventory Units</label>
                <input class="form-control {{ $errors->has('inventoryUnit') ? 'is-invalid' : '' }}" type="text" name="inventoryUnit" id="inventoryUnit" value="{{ old('inventoryUnit', '') }}" required>
              </div>
              <div class="form-group col-md-4 ">
                <label for="remainingItem">Quantity</label>
                <input class="form-control {{ $errors->has('remainingItem') ? 'is-invalid' : '' }}" type="number" name="remainingItem" id="remainingItem" value="{{ old('remainingItem', '') }}" required>
              </div>
           </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

@endsection