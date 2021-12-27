@extends('layouts.admin')
@section('content')
    <style>
        @media print {
            .noprint {
                display: none;
            }
        }
    </style>
    <div class="card" style="background: white; font-size: 16px;">

        @include("admin.TestPerformed.partial_patient")
        @include("admin.TestPerformed.partial_report")
        @if($testPerformedsId->status == 'verified')
        <div style="background: white" class="col-md-12 mb-12 noprint text-center py-3">
            <button class="btn btn-primary" onclick="window.print()">Print Report</button>
        </div>
        @endif

    </div>

@endsection