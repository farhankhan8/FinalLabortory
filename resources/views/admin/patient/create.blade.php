@extends('layouts.admin')
  @section('content')
    <div class="card">
      <div class="card-header">
          Create New Patient
      </div>
      <div class="card-body">
          <form method="POST" action="{{ route("patient-store") }}" enctype="multipart/form-data">
            @csrf 
            <div class="form-row">
      <div class="col-md-4 mb-3">
        <div class="form-group">
                <label class="required" for="Pname">Enter Patient Name</label>
                <input class="form-control {{ $errors->has('Pname') ? 'is-invalid' : '' }}" type="text" name="Pname" id="Pname" value="{{ old('Pname', '') }}" required>

                @if($errors->has('Pname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('Pname') }}
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
                <label class="" for="email">Email</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', '') }}" >
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
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
                <label class="" for="phone">Phone</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="number" name="phone" id="phone" value="{{ old('phone', '') }}" step="1">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block"></span>
          </div>
        </div>
      </div>
  
      <div class="form-row">
      <div class="col-md-4 mb-3">
       <div class="form-group">
                <label class="required" for="dob">Birthday</label>
                <input class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="date" name="dob" id="dob" value="{{ old('dob', '') }}"required>
                @if($errors->has('dob'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dob') }}
                    </div>
                @endif
                <span class="help-block"></span>
          </div>
          <div class="invalid-feedback">
            Please provide a valid city.
          </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="form-group">
                <label class="required" for="patient_category_id">Patient Catagory</label>
                <select class="form-control select2 {{ $errors->has('patient_category_id') ? 'is-invalid' : '' }}" name="patient_category_id" id="patient_category_id" required>
                    @foreach($patientCategorys as $id => $patientCategory)
                        <option value="{{ $id }}">{{ $patientCategory }}</option>
                    @endforeach
                </select>                
                @if($errors->has('patient_category_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('patient_category_id') }}
                    </div>
                @endif
                <span class="help-block"></span>
        </div>
        <div class="invalid-feedback">
          Please provide a valid state.
        </div>
      </div>
      <div class="col-md-3 mt-4">
      <div class="form-group">
          <label for="gend" class= "col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
          <div class="form-check form-check-inline" >
            <input class="form-check-input" type="radio" name="gend" value="male" checked>
            <label class="form-check-label" for="male">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gend" value="female">
            <label class="form-check-label" for="female">Female</label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
            <label class="form-check-label" for="invalidCheck3">
            </label>
          <div class="invalid-feedback">
        </div>
      </div>
    </div>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
  </form>
@endsection