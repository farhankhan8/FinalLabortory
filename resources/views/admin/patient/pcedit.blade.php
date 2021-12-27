@extends('layouts.admin')
  @section('content')
    <div class="card">
      <div class="card-header">
        Edit Patient
      </div>

      <div class="card-body">
        <form method="POST" action="{{ route("patient-category-update", [$patientCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <div class="form-group">
                <label  for="Pcategory">Patient Category</label>
                <input class="form-control {{ $errors->has('Pcategory') ? 'is-invalid' : '' }}" type="text" name="Pcategory" id="Pcategory" value="{{ old('Pcategory', $patientCategory->Pcategory) }}" required>
                @if($errors->has('Pcategory'))
                    <div class="invalid-feedback">
                        {{ $errors->first('Pcategory') }}
                    </div>
                @endif
                <span class="help-block"></span>
              </div>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>

        <div class="col-md-4 mb-3">
          <div class="form-group">
                <label for="discount">Discount</label>
                <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', $patientCategory->discount) }}" required>
                @if($errors->has('discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="valid-feedback">
            Looks good!
            </div>
          </div>
  
      <div class="card-body">
        <div class="form-row">
        <div class="col-md-4 mb-3">
        <div class="form-group">
        <button class="btn btn-primary" type="submit">Update</button>
      </div>
    </div>
    </div>
    </div>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>       
    </form>
      </div>
  </div>
@endsection