@extends('layouts.admin')
    @section('content')
        <div class="card">
            <div class="card-header">
                Edit Inventory
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route("inventory-update", [$inventoryes->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="" for="inventoryName">Inventory Name</label>
                        <input class="form-control {{ $errors->has('inventoryName') ? 'is-invalid' : '' }}" type="text" name="inventoryName" id="inventoryName" value="{{ old('Cname', $inventoryes->inventoryName) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="" for="inventoryUnit">Inventory Units</label>
                        <input class="form-control {{ $errors->has('inventoryUnit') ? 'is-invalid' : '' }}" type="text" name="inventoryUnit" id="inventoryUnit" value="{{ old('inventoryUnit', $inventoryes->inventoryUnit) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="" for="remainingItem">Remaining Quantity</label>
                        <input class="form-control {{ $errors->has('remainingItem') ? 'is-invalid' : '' }}" type="number" name="remainingItem" id="remainingItem" value="{{ old('remainingItem', $inventoryes->remainingItem) }}" required>
                    </div>
            </div>

                        <div class="col-md-3 mb-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
        </form>
    </div>
</div>



@endsection