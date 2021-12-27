@extends('layouts.admin')
  @section('content')
    <div class="card">
      <div class="card-header">
        Create New Patient Category
      </div>

      <div class="card-body">
        <form method="POST" action="{{ route("patient-category-store") }}" enctype="multipart/form-data">
            @csrf 

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Enter Patient Category</label>
              <input class="form-control {{ $errors->has('Pcategory') ? 'is-invalid' : '' }}" type="text" name="Pcategory" id="Pname" value="{{ old('Pcategory', '') }}"required>
            </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Discount</label>
            <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', '') }}" required>
          </div>
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

@endsection