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
.h12 {
  background-color: #ddd;
  text-align:center;
  padding: 5px;
}
</style>
<div class="card-body">
    
        <div class="row dont-break-inside">
            <div class="offset-0 col-md-6" style="display: flex; align-items: center;">
                <img style="width: 7rem;" class="d-none" src="{{ asset('images/logo_print.jpg') }}"/>
                <span class="d-none" style="justify-content: center; display: flex;  flex-direction: column; padding-left: 15px;">
                    <!-- <div style="margin-bottom: 4px; color: #283583;" class="fas  fa-3x" >اسامہ لیبارٹری</div> -->
                    <div style="font-size:24px; margin-top:4px; line-height: 1.9rem; font-weight: bold">
                        <span style=" font-size:35px;">Usama</span> PCR and<br /> Clinical Laboratory
                    </div>
                </span>
            </div>
            <div class="col-md-6 pr-5">
                <div class="offset-4">
                    <!--
                    <h3 class="h12">Detail</h3>
                    -->
                    <div class="row">
                        <b class="col-md-6">MR No.</b>
                        <b class="text-capitalize col-md-6 m-0">{{ $getpatient->id }}</b>
                        <strong class="col-sm-6 text-nowrap">Patient Name</strong>
                        <b class="text-capitalize col-md-6 m-0"><span>{{ $getpatient->Pname }}</span></b>
                    </div>
                </div>
                <div class="offset-4">
                    <div class="row">
                        <span class="col-md-6">Age/Gender</span>
                        <p class="text-capitalize col-md-6 m-0 text-nowrap">{{ date('d-m-Y', strtotime($getpatient->dob)) }}/{{ $getpatient->gend }}</p>
                    </div>
                </div>
                <div class="offset-4">

                    @if($testPerformedsId->referred != '')
                        <div class="row">
                            <span class="col-md-6">Referred By</span>
                            <p class="col-md-6 m-0 text-nowrap">{{ $testPerformedsId->referred }}</p>
                        </div>
                    @else
                        <div class="row">
                            <span class="col-md-6">Ordered By</span>
                            <p class="col-md-6 m-0 text-nowrap">Self</p>
                        </div>
                    @endif
            
                </div>
                <div class="offset-4">
                    <div class="row">
                        <span class="col-md-6">Ordered On</span>
                        <p class="col-md-6 m-0 text-nowrap">{{ date('d-m-Y H:m:s', strtotime($getpatient->start_time)) }}</p>
                    </div>
                </div>
                <div class="offset-4">
                    <div class="row">
                        <span class="col-md-6">Specimen</span>
                        <p class="col-md-6 m-0 text-nowrap">{{$testPerformedsId->specimen}}</p>
                    </div>
                </div> 
            </div>
        </div>
    
</div>
