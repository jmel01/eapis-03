@if ($student->hasAnyRole('Admin|Executive Officer|Regional Officer|Provincial Officer|Community Service Officer'))
@php ($title = 'User Information')
@else
@php ($title = 'Student Information')
@endif

@extends('layouts.adminlte.template')

@section('title', $title )

@push('style')
<link rel="stylesheet" href="{{ asset('/css/full-calendar.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-9">

                <!-- START ACCORDION & CAROUSEL-->
                <div id="accordion">
                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h4 class="card-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Personal Information
                                </a>
                            </h4>
                        </div>

                        <div id="collapseOne" class="panel-collapse collapse in collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <div class="box-profile col-md-4">
                                        <div class="text-center">
                                            <img class="img-circle img-bordered-sm img-fluid cover mx-3" style="height: 200px; width: 200px;" alt="user image" src="/storage/users-avatar/{{ $student->avatar ?? 'avatar.png' }}">
                                        </div>

                                        <h3 class="profile-username text-center">{{ $student->name ?? '' }}</h3>
                                        <p class="text-center">{{ $student->email ?? '' }}<br />
                                            Member since {{ $student->created_at->format('F Y') }}</p>
                                    </div>

                                    <div class="col-md-8">
                                        @can('profile-edit')
                                        <div>
                                            <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm float-right mr-1 d-print-none">BACK</a>
                                            @if($userProfile == '')
                                            <button data-id="{{ $id }}" data-url="{{ route('profiles.edit', $id) }}" class="btn btn-warning btn-sm float-right mr-1 btn-edit-profile">UPDATE PROFILE!</button>
                                            @else
                                            <button data-id="{{ $id }}" data-url="{{ route('profiles.edit', $id) }}" class="btn btn-outline-primary btn-sm float-right mr-1 btn-edit-profile">UPDATE PROFILE</button>
                                            @endif
                                        </div>
                                        @endcan
                                        @if(!empty($student->profile))
                                        <p>Name: <strong>{{ $student->profile->firstName ?? '' }} {{ $student->profile->middleName ?? '' }} {{ $student->profile->lastName ?? '' }}</strong></p>
                                        <p>Age: <strong>{{ \Carbon\Carbon::parse($student->profile->birthdate)->diff(\Carbon\Carbon::now())->format('%y') }} years old</strong></p>
                                        <p>Birthplace: <strong>{{ $student->profile->placeOfBirth ?? '' }}</strong></p>
                                        <p>Gender: <strong>{{ $student->profile->gender ?? '' }}</strong></p>
                                        <p>Civil Status: <strong>{{ $student->profile->civilStatus ?? '' }}</strong></p>
                                        <p>Ethnolinguistic Group: <strong>{{ App\Models\Ethnogroup::getEthno($student->profile->ethnoGroup ?? '') }}</strong></p>
                                        <p>Phone: <strong>{{ $student->profile->contactNumber ?? '' }}</strong></p>
                                        <p>Address: <strong>{{ $student->profile->address ?? '' }}, {{ App\Models\Psgc::getBarangay($student->profile->psgCode ?? '') }}, {{ App\Models\Psgc::getCity($student->profile->psgCode ?? '') }}, {{ App\Models\Psgc::getProvince($student->profile->psgCode ?? '') }}, {{ App\Models\Psgc::getRegion($student->profile->psgCode ?? '') }}</strong></p>
                                        @else
                                        <p>Name:</p>
                                        <p>Age:</p>
                                        <p>Birthplace:</p>
                                        <p>Gender:</p>
                                        <p>Civil Status:</p>
                                        <p>Ethnolinguistic Group:</p>
                                        <p>Phone:</p>
                                        <p>Address:</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($student->hasAnyRole('Admin|Executive Officer|Regional Officer|Provincial Officer|Community Service Officer'))
                    @else
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h4 class="card-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    Scholarship/Grant
                                </a>
                            </h4>
                        </div>

                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="card-body">
                                @can('application-add')
                                @if($userProfile != '')
                                <button data-id="{{ $id }}" class="btn btn-outline-success btn-sm float-right btn-add-application">APPLY SCHOLARSHIP</button>
                                @endif
                                @endcan

                                <table id="applicationList" class="table table-sm table-hover table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th>Scholarship/Grant</th>
                                            <th>Type</th>
                                            <th>Level</th>
                                            <th>School</th>
                                            <th>Course</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($applications as $application)
                                        @if (isset($application->grant))
                                        <tr>
                                            <td>{{ $application->grant->psgCode->name }} SY: {{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1}}</td>
                                            <td>{{ $application->type }}</td>
                                            <td>{{ $application->level }}</td>
                                            <td>{{ $application->school }}</td>
                                            <td>{{ $application->course }}</td>
                                            <td>{{ $application->status }}</td>
                                            <td>
                                                @can('application-read')
                                                <a href="{{ url('/applications/applicationForm/' . $application->id)}}" class="btn btn-outline-success btn-sm mr-1 mb-1">VIEW APPLICATION</a>
                                                @endcan
                                                @can('document-add')
                                                <button class="btn btn-outline-primary btn-sm mr-1 mb-1 btn-add-document" data-grantID="{{ $application->grant_id }}">ADD FILE</button>
                                                @endcan
                                                @can('document-browse')
                                                <a href="{{ route('documents.show', $application->grant_id) }}" class="btn btn-outline-info btn-sm mr-1 mb-1">VIEW FILES</a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @else
                                        <tr class="text-danger">
                                            <td>Grant already deleted!</td>
                                            <td>{{ $application->type }}</td>
                                            <td>{{ $application->level }}</td>
                                            <td>{{ $application->school }}</td>
                                            <td>{{ $application->course }}</td>
                                            <td></td>
                                            <td>
                                                <a href="{{ route('documents.show', $application->grant_id) }}" class="btn btn-outline-info btn-sm mr-1 mb-1">VIEW FILES</a>
                                            </td>
                                        </tr>
                                        @endif
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h4 class="card-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                    Financial Assistance
                                </a>
                            </h4>
                        </div>

                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="card-body">
                                <table id="paymentList" class="table table-sm table-hover table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Date Received</th>
                                            <th class="text-center">Particulars</th>
                                            <th class="text-center sum">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $payment)
                                        <tr>
                                            <td class="text-center">{{ date('j F Y', strtotime($payment->dateRcvd)) }}</td>
                                            <td class="text-center">{{ $payment->particulars }}</td>
                                            <td class="text-right">{{ number_format($payment->amount, 2, '.', ',') }}</td>

                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th class="text-right"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

            <div class="col-12 col-md-12 col-lg-3 bg-light">

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
@include('profiles.modalProfile')
@include('applications.modalApplication')
@include('applications.modalApplicationNotAvailable')
@include('documents.modalDocument')
@include('calendars.modalShowAnnouncement')
@endsection

@push('scripts')
@include('psgc.scriptPsgc')
@include('ethnogroups.scriptEthno')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {

        $('.btn-add-application').click(function() {
            document.getElementById("formApplication").reset();
            var id = $(this).attr('data-id');

            $.ajax({
                url: '/user/validate/apply',
                type: 'GET',
                data: {
                    id: id
                },
            }).done(result => {
                if (result.message == 'success') {
                    $('[name="user_id"]').val(id)
                    $('#modalApplication').modal('show')
                }

                if (result.message == 'notAvailable') {
                    $('#modalApplicationNotAvailable').modal('show')
                }
            })

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

            $.ajax({
                url: '/profile/update/show-modal',
                type: 'GET',
                data: {
                    id: id
                },
            }).done(result => {
                $('#modalProfile .modal-body').empty()
                $('#modalProfile .modal-body').append(result)
                $('#modalProfile').modal('show')
            })
        });

        var table = $('#applicationList').DataTable({
            "fixedHeader": {
                header: true,
                footer: true
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [],
        });

        var table = $('#paymentList').DataTable({
            "fixedHeader": {
                header: true,
                footer: true
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [],
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                api.columns('.sum', {
                    page: 'current'
                }).every(function() {
                    var pageSum = this
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    this.footer().innerHTML = 'TOTAL: ' + pageSum.toLocaleString('us-US');
                });
            },
        });



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
@include('profiles.scriptAddSibling')
@endpush