@extends('layouts.adminlte.template')

@section('title', 'Applicant Dashboard')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
<link rel="stylesheet" href="{{ asset('/css/full-calendar.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">XXXXXXX</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div id='calendar'></div>
            </div>

            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">My Applications</h3>
                    </div>
                    <div class="card-body">
                        ADMIN DASHBOARD
                    </div>
                    <div class="card-footer">
                        Footer
                    </div>
                </div>

            </div>
        </div>


    </div>
    <div class="card-footer">
        Footer
    </div>
</div>

@endsection

@push('scripts')

<script src="{{ asset('/js/full-calendar.js') }}"></script>
@include('calendars.scriptCalendar')

@endpush