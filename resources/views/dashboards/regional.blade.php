@extends('layouts.adminlte.template')

@section('title', 'Regional Officer Dashboard')

@push('style')
<link rel="stylesheet" href="{{ asset('/css/full-calendar.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Estimated budget</span>
                                <span class="info-box-number text-center text-muted mb-0">2300</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Total amount spent</span>
                                <span class="info-box-number text-center text-muted mb-0">2000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Estimated project duration</span>
                                <span class="info-box-number text-center text-muted mb-0">20 <span>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>

            <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2 bg-light">

                <nav>
                    <div class="nav nav-tabs nav-fill" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#eventTab1" role="tab">
                            Events
                        </a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#messageTab2" role="tab">
                            Scholarship Community
                        </a>
                    </div>
                </nav>

                <div class="tab-content p-3" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="eventTab1" role="tabpanel">
                        <div id='calendar'></div>
                    </div>

                    <div class="tab-pane fade" id="messageTab2" role="tabpanel">
                        <iframe src="/community" style="display:block; min-height:600px; width:100%;" frameborder="0" marginwidth="0" marginheight="0" scrolling="yes" onload="" allowtransparency="false"></iframe>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

@include('layouts.adminlte.modalDelete')
@include('calendars.modalShowAnnouncement')
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

        $('.btn-add-document').click(function() {
            document.getElementById("formDocument").reset();
            var grantID = $(this).attr('data-grantID');
            $('[name="grantID"]').val(grantID)
            $('#modalDocument').modal('show')

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
                $('#region').trigger("change")
            })
        })

    });
</script>

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

<script src="{{ asset('/js/full-calendar.js') }}"></script>
@include('calendars.scriptCalendarApplicant')
@include('profiles.scriptAddSchool')
@endpush