@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Edit Patient
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("patient-update", [$patients->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="Pname">Patient Name</label>
                            <input class="form-control {{ $errors->has('Pname') ? 'is-invalid' : '' }}" type="text" name="Pname" id="Pname" value="{{ old('Pname', $patients->Pname) }}" >
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
                            <label for="email">Email</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="email" name="email" id="name" value="{{ old('email', $patients->email) }}" >
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
                            <label for="phone">Phone</label>
                            <input class="form-control {{ $errors->has('capacity') ? 'is-invalid' : '' }}" type="number" name="phone" id="phone" value="{{ old('phone', $patients->phone) }}" step="1">
                            @if($errors->has('capacity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('capacity') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="dob">Birthday</label>
                            <input class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="date" name="dob" id="dob" value="{{ old('phone', $patients->dob) }}" >
                            @if($errors->has('dob'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('dob') }}
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
                            <label class="" for="patient_category_id">Select Patient Category</label>

                            <select class="form-control" name="patient_category_id" id="patient_category_id" >
                                @foreach($patientCategorys as $id => $patientCategory)
                                    <option value="{{ $id }}" {{ $patients->patient_category_id == $id ? 'selected' : '' }}>{{ $patientCategory }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('patient_category_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('patient_category_id') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="form-group">
                            <label for="gend" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gend" value="male" {{ $patients->gend == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gend" value="female" {{ $patients->gend == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

@endsection