@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("patient-create") }}">
            Register New Patient
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            List of All Patients
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="patientTable"class=" table table-bordered table-striped table-hover datatable datatable-Event">
                    <thead>
                        <tr>
                            <th>
                            MR Id
                            </th>
                            <th>
                            Patient Name
                            </th>
                            <th>
                            Phone
                            </th>
                            <th>
                            Email
                            </th>
                            <th>
                            Age
                            </th>
                            <th>
                            Registration
                            </th>   
                            <th>
                            Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $key => $patient)
                            <tr data-entry-id="{{ $patient->id }}">
                                
                                <td>
                                {{ $patient->id ?? '' }}
                                </td>
                                <td>
                                {{ $patient->Pname  ?? '' }}
                                </td>
                                <td>
                                {{ $patient->phone ?? '' }}
                                </td>
                                <td>
                                {{ $patient->email ?? '' }}
                                </td>
                                <td>
                                {{ \Carbon\Carbon::parse($patient->dob)->diff(\Carbon\Carbon::now())->format('%y years old') }}
                                </td>
                                <td>
                                {{ date('d-m-Y H:m:s', strtotime($patient->start_time ?? '')) }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('patient-show', $patient->id) }}">
                                        {{ trans('global.view') }}
                                    </a>

                                    <a class="btn btn-xs btn-info" href="{{ route('patient-edit', $patient->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    @if(Auth::user()->role != 'receptionist')
                                    <form  method="POST" action="{{ route("patient-delete", [$patient->id]) }}" onsubmit="return confirm('{{ trans('Are You Sure to Deleted  ?') }}');"  style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>



<script type="text/javascript">
    
    function searchTable()
    {
        console.log("search funtion");
        // Setup - add a text input to each footer cell
        $('#patientTable thead tr').clone(true).appendTo( '#patientTable thead' );

        $('#patientTable thead tr:eq(1) th').each( function (i) {
            if(i==1 || i==2 || i==3 || i == 0){
              var title = $(this).text();
              console.log(i);
              $(this).html( '<input type="text" placeholder="Search" />' );
              $( 'input', this ).on( 'keyup change', function () {
                  if ( table.column(i).search() !== this.value ) {
                    table.column(i).search( this.value ).draw();
                  }
              });
            }else{
              $(this).html( '' );
            }
        });

        table = $('#patientTable').DataTable({
            orderCellsTop: true,
            fixedHeader: true
        });
        
    }

    $( document ).ready(function() {
        searchTable()
    });
</script>


@endsection

