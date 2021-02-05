@extends('layouts.adminlte.template')

@section('title', 'Student Dashboard')

@push('style')
<link rel="stylesheet" href="{{ asset('/css/full-calendar.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

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
                    <div class="col-12">
                        @if($userProfile == '')
                        <button data-id="{{ Auth::id() }}" data-url="{{ route('profiles.edit',Auth::id()) }}" class="btn btn-warning btn-sm float-right btn-edit-profile">UPDATE PROFILE FIRST!</button>
                        @else
                        <button data-id="{{ Auth::id() }}" data-url="{{ route('profiles.edit',Auth::id()) }}" class="btn btn-outline-primary btn-sm float-right btn-edit-profile">UPDATE PROFILE</button>
                        @endif
                        <h4>Student Details</h4>
                        <hr>
                        <img class="img-circle img-bordered-sm cover mx-3 float-left" style="height: 90px; width: 90px;" alt="user image" src="/storage/users-avatar">
                        <p>
                            @if(!empty(Auth::user()->profile))
                            <strong>{{ Auth::user()->profile->firstName ?? '' }} {{ Auth::user()->profile->middleName ?? '' }} {{ Auth::user()->profile->lastName ?? '' }}</strong><br>
                            @endif
                            {{ Auth::user()->name ?? '' }}<br>
                            {{ Auth::user()->email ?? '' }}<br>
                            <small class="text-primary">Member since {{ Auth::user()->created_at->format('F Y') }}</small>
                        </p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        @if($userProfile != '')
                        <button data-id="{{ Auth::id() }}" class="btn btn-outline-success btn-sm float-right btn-add-application">APPLY SCHOLARSHIP</button>
                        @endif
                        <h4>Scholarship/Grant</h4>
                    </div>

                    <div class="col-md-12">

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
                                <tr>
                                    <td>{{ $application->grant->psgCode->name }} SY: {{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1}}</td>
                                    <td>{{ $application->type }}</td>
                                    <td>{{ $application->level }}</td>
                                    <td>{{ $application->school }}</td>
                                    <td>{{ $application->course }}</td>
                                    <td>{{ $application->status }}</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm btn-add-document" data-grantID="{{ $application->grant_id }}">ADD FILE</button>
                                        <a href="{{ route('documents.show', $application->grant_id) }}" class="btn btn-outline-info btn-sm">VIEW FILES</a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h4>Financial Assistance</h4>

                        <table id="paymentList" class="table table-sm table-hover table-responsive-lg">
                            <thead>
                                <tr>
                                    <th class="text-center">Date Received</th>
                                    <th class="text-center">Particulars</th>
                                    <th class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                <tr>
                                    <td class="text-center">{{ date('j F Y', strtotime($payment->dateRcvd)) }}</td>
                                    <td>{{ $payment->particulars }}</td>
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
                url : '/user/validate/apply',
                type : 'GET',
                data : {id: id},
            }).done(result => {
                if(result.message == 'success'){
                    $('[name="user_id"]').val(id)
                    $('#modalApplication').modal('show')
                }

                if(result.message == 'notAvailable'){
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
                url : '/profile/update/show-modal',
                type : 'GET',
                data : {id: id},
            }).done(result => {
                $('#modalProfile .modal-body').empty()
                $('#modalProfile .modal-body').append(result)
                $('#modalProfile').modal('show')
            })
        });

        var table = $('#applicationList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        var table = $('#paymentList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
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

                // Total over all pages
                total = api
                    .column(2)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(2, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(2).footer()).html(
                    'Total: ₱  ' + pageTotal.toLocaleString("en-US") + ' ( ₱ ' + total.toLocaleString("en-US") + ')'
                );
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
