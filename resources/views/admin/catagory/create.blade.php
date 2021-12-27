@extends('layouts.admin')
   @section('content')
      <div class="card">
        <div class="card-header">
           Create New Category 
        </div>

        <div class="card-body">
        <form method="POST" action="{{ route("catagory-store") }}" enctype="multipart/form-data">
            @csrf
        
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label class="required" for="Cname">Enter New Category  Name</label>
                    <input class="form-control {{ $errors->has('Cname') ? 'is-invalid' : '' }}" type="text" name="Cname" id="Cname" value="{{ old('Cname', '') }}" required>
                    @if($errors->has('Cname'))
                        <div class="invalid-feedback">
                            {{ $errors->first('Cname') }}
                        </div>
                    @endif
                    <span class="help-block"></span>
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-3 mb-3">

                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
    </div>
@endsection