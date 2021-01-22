@extends('layouts.adminlte.template')

@section('title', 'Dashboard')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
<link rel="stylesheet" href="{{ asset('/css/full-calendar.css') }}">
@endpush

@section('content')
<div class="card bg-light">
    <div class="card-header">
        <h3 class="card-title">XXXXXXX</h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12">
                @if($userProfile == '')
                <button data-id="{{ Auth::id() }}" data-url="{{ route('profiles.edit',Auth::id()) }}" class="btn btn-outline-warning btn-lg float-right btn-edit-profile">UPDATE PROFILE FIRST!</button>
                @else
                <button data-id="{{ Auth::id() }}" class="btn btn-outline-success btn-lg float-right btn-add-application">APPLY SCHOLARSHIP</button>
                @endif
            </div>
        </div>
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
                        @foreach($applications as $application)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $application->grant->psgCode->name }}
                                    SY: {{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1}}</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                        <i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <input type="text" value="{{ $application->type }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Level</label>
                                                    <input type="text" value="{{ $application->level }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>School</label>
                                            <input type="text" value="{{ $application->school }}" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Course</label>
                                            <input type="text" value="{{ $application->course }}" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="row">
                                            <strong>Status</strong>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="form-group">
                                            <button data-id="{{ Auth::id() }}" class="btn btn-outline-primary m-1 float-right btn-add-application">Update Application</button>
                                                <button data-id="{{ Auth::id() }}" class="btn btn-outline-primary m-1 float-right btn-add-application">My Document</button>
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
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

@include('layouts.adminlte.modalDelete')
@include('profiles.modalProfile')
@include('applications.modalApplication')
@endsection

@push('scripts')
@include('psgc.scriptPsgc')

<script>
    $(document).ready(function() {

        $('.btn-add-application').click(function() {
            document.getElementById("formApplication").reset();
            var id = $(this).attr('data-id');
            $('[name="user_id"]').val(id)
            $('#modalApplication').modal('show')
        });

        $('.btn-edit-profile').click(function() {
            var id = $(this).attr('data-id');
            var url_id = $(this).attr('data-url');
            $('[name="id"]').val(id)

            $.get(url_id, function(data) {
                console.log(data)
                $('[name="lastName"]').val(data.lastName)
                $('[name="firstName"]').val(data.firstName)
                $('[name="middleName"]').val(data.middleName)
                $('[name="birthdate"]').val(data.birthdate)
                $('[name="placeOfBirth"]').val(data.placeOfBirth)
                $('[name="gender"]').val(data.gender)
                $('[name="civilStatus"]').val(data.civilStatus)
                $('[name="ethnoGroup"]').val(data.ethnoGroup)
                $('[name="contactNumber"]').val(data.contactNumber)
                $('[name="email"]').val(data.email)
                /*  document.getElementById('region').value = data.psgCode.substr(0, 2) + "0000000"
                 document.getElementById('province').value = data.psgCode.substr(0, 4) + "00000"
                 document.getElementById('city').value = data.psgCode.substr(0, 6) + "000"
                 document.getElementById('barangay').value = data.psgCode */
                $('[name="address"]').val(data.address)
                $('[name="fatherName"]').val(data.fatherName)
                $('[name="fatherAddress"]').val(data.fatherAddress)
                $('[name="fatherOccupation"]').val(data.fatherOccupation)
                $('[name="fatherOffice"]').val(data.fatherOffice)
                $('[name="fatherEducation"]').val(data.fatherEducation)
                $('[name="fatherEthnoGroup"]').val(data.fatherEthnoGroup)
                $('[name="fatherIncome"]').val(data.fatherIncome)
                $('[name="motherName"]').val(data.motherName)
                $('[name="motherAddress"]').val(data.motherAddress)
                $('[name="motherOccupation"]').val(data.motherOccupation)
                $('[name="motherOffice"]').val(data.motherOffice)
                $('[name="motherEducation"]').val(data.motherEducation)
                $('[name="motherEthnoGroup"]').val(data.motherEthnoGroup)
                $('[name="motherIncome"]').val(data.motherIncome)

                $('#modalProfile').modal('show')
            })
        })

    });
</script>
<script src="{{ asset('/js/full-calendar.js') }}"></script>
@include('calendars.scriptCalendar')

<!-- Error/Modal Opener -->
@if (count($errors->application) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalApplication').modal('show');
    });
</script>
@endif

@if (count($errors->profile) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalProfile').modal('show');
    });
</script>
@endif

@endpush