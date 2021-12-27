<style>
.row {
  display: flex; /* equal height of the children */
}

.col {
  flex: 1; /* additionally, equal width */
  
  padding: 1em;
  /* border: solid gray; */
}
.hr {
    border-top: 2px solid red;

}
</style>
<div class="card-body">
    <div class="form-row">
        <div class="col">
            <div class="offset-5 col-md-6">
                <h1>Usama Laboratory</h1>
                <hr class="hr">
                    <img style="width: 2rem;" class="card-img-top card d-flex"src="{{ asset('images/public.jpeg') }}"/>
                <b class="col-md-16 mb-5 text-capitalize">
                {{ $testPerformedsId->availableTest->category->Cname }}
                </b>
                <h5>
                <b class="col-md-16 mb-5 text-capitalize">{{$testPerformedsId->availableTest->name}}</b>
                </h5>
            </div>
        </div>
        <div class="col">
                <div class="offset-1 col-md-6">
                    <div class="row">
                        <b class="col-md-6">Patient Name</b>
                        <b class="text-capitalize col-md-6 m-0">{{ $getpatient->Pname }}</b>
                    </div>
                </div>

                <div class="offset-1 col-md-6">
                    <div class="row">
                        <span class="col-md-6">Phone</span>
                        <p class="col-md-6 m-0">{{ $getpatient->phone }}</p>
                    </div>
                </div>
            
                <div class="offset-1 col-md-6">
                    <div class="row">
                        <span class="col-md-6">Gender</span>
                        <p class="col-md-6 m-0">{{ $getpatient->gend }}</p>
                    </div>
                </div>

                <div class="offset-1 col-md-6">
                    <div class="row">
                        <span class="col-md-6">Start Time</span>
                        <p class="col-md-6 m-0">{{ $getpatient->start_time }}</p>
                    </div>
                </div>

                <div class="offset-1 col-md-6">
                    <div class="row">
                        <span class="col-md-6">Date of Birth</span>
                        <p class="col-md-6 m-0">{{ $getpatient->dob }}</p>
                    </div>
                </div>   

                <div class="offset-1 col-md-6">
                    <div class="row">
                        <p class="col-md-6">Email</b>
                        <p class="col-md-6 m-0">{{ $getpatient->email }}</p>
                    </div>
                </div>
     
        </div>
    </div>
</div>