@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("available-test-create") }}">
                Add New Test
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            List of Available Tests
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                    <thead>
                    <tr>
                        <th>
                            Id
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Test Code
                        </th>
                        <th>
                            Test Fee
                        </th>
                        <th>
                            Urgent Fee
                        </th>
                        <th>
                        Standard Time
                        </th>
                        <th>
                        Urgent Time
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($availableTests as $key => $availableTest)
                        <tr data-entry-id="{{ $availableTest->id }}">
                            <td>
                                {{ $availableTest->id ?? '' }}
                            </td>
                            <td>
                                {{ $availableTest->category->Cname ?? '' }}
                            </td>
                            <td>
                                {{ $availableTest->name ?? '' }}
                            </td>
                            <td>
                                {{ $availableTest->testCode ?? '' }}
                            </td>
                            <td>
                                {{ $availableTest->testFee ?? '' }}
                            </td>

                            <td>
                                {{ $availableTest->urgentFee ?? '' }}
                            </td>
                            <td>
                            {{\Carbon\CarbonInterval::seconds($availableTest->stander_timehour)->cascade()->forHumans() }}
                            </td>
                            <td>
                            {{\Carbon\CarbonInterval::seconds($availableTest->urgent_timehour)->cascade()->forHumans() }}
                            </td>
                            <td> 
                                <a class="btn btn-xs btn-primary" href="{{ route('availabel-tests-show', $availableTest->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                                @if(auth::check() && Auth::user()->role == 'admin' || Auth::user()->role == 'manager')

                                <a class="btn btn-xs btn-info" href="{{ route('availabel-tests-edit', $availableTest->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                <form method="POST" action="{{ route("avaiable-test-delete", [$availableTest->id]) }}" onsubmit="return confirm('{{ trans('Are You Sure to Deleted  ?') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        function searchTable()
        {
            console.log("search funtion");
            // Setup - add a text input to each footer cell
            $('.datatable thead tr').clone(true).appendTo( '.datatable thead' );

            $('.datatable thead tr:eq(1) th').each( function (i) {
                if(i==1 || i==2 || i==0 || i ==3){
                var title = $(this).text();
                $(this).html( '<input type="text" style="width:100%;" placeholder="Search" />' );
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table.column(i).search( this.value ).draw();
                    }
                });
                }else{
                $(this).html( '' );
                }
            });

        }

        $(function () {

            searchTable();

            table = $('.datatable').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })



    </script>
@endsection