@extends('layouts.adminlte.template')

@section('title', 'Applications Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Applications for SY {{$grant->acadYr}}-{{$grant->acadYr+1}} ({{$grant->psgCode->name}})</h3>
    </div>
    <div class="card-body">

        <a href="/grants" class="btn btn-outline-primary btn-sm float-right mr-1">BACK</a>

        <table id="applicationList" class="table table-sm table-hover table-responsive-sm" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Batch</th>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Remarks</th>
                    <th>Region</th>
                    <th>Province</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $application)
                    @if(substr($application->applicant->psgcBrgy->code, 0, $subStrLen) == $locationId || $subStrLen == '0')
                    <tr>
                        <td>{{ ucwords($application->applicant->firstName) }} {{ ucwords(substr($application->applicant->middleName,0,'1')) }}. {{ ucwords($application->applicant->lastName) }}</td>
                        <td>{{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1 }}</td>
                        <td>{{ $application->type }}</td>
                        <td>{{ $application->level }}</td>
                        <td>{{ $application->status }}</td>
                        <td>
                            @if($application->status=='On Process')
                                {{ $application->date_process }}
                            @elseif($application->status=='Approved')
                                {{ $application->date_approved }}
                            @elseif($application->status=='Graduated')
                                {{ $application->date_graduated }}
                            @elseif($application->status == 'Terminated-FSD' || $application->status == 'Terminated-FG' || $application->status == 'Terminated-DS' || $application->status == 'Terminated-NE' || $application->status == 'Terminated-FPD' || $application->status == 'Terminated-EOGS' || $application->status == 'Terminated-Others')
                                {{ $application->date_terminated }}
                            @elseif($application->status=='Denied')
                                {{ $application->date_denied }}
                            @else
                                {{ $application->created_at }} 
                            @endif
                        </td>
                        <td>{{ $application->remarks }}</td>
                        <td>{{ App\Models\Psgc::getRegion($application->applicant->psgcBrgy->code) }}</td>
                        <td>{{ App\Models\Psgc::getProvince($application->applicant->psgcBrgy->code) }}</td>
                        <td>
                            <a href="{{ route('users.show',$application->user_id) }}" class="btn btn-info btn-sm mr-1 mb-1">View Student Info</a>
                            @can('application-read')
                            <a href="{{ url('/applications/applicationForm/' . $application->id)}}" class="btn btn-info btn-sm mr-1 mb-1">View Application</a>
                            @endcan
                            @can('document-browse')
                            <a href="{{ url('showAttachment/' . $application->grant_id . '/' . $application->user_id)}}" class="btn btn-info btn-sm mr-1 mb-1">View Files</a>
                            @endcan
                            @can('application-edit')
                            <button data-url="{{ route('applications.edit',$application->id) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-application">Edit Application</button>
                            @endcan
                            @can('application-delete')
                            <button data-url="{{ route('applications.destroy', $application->id) }}" class="btn btn-danger btn-sm mr-1 mb-1 btn-delete-application">Delete</button>
                            @endcan

                            @hasanyrole('Admin|Regional Officer')
                            @can('expenses-add')
                            @if($application->status=='Approved')
                            <button data-payee="{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }} {{ ucwords(substr($application->applicant->middleName,0,'1')) }}." data-particular="Grant Payment" data-province="{{ substr($application->applicant->psgcBrgy->code, 0, 4) }}00000" data-userId="{{ $application->user_id }}" data-grantId="{{ $application->grant_id }}" data-applicationId="{{ $application->id }}" class="btn btn-success btn-sm mr-1 mb-1 btn-add-cost">Payment</button>
                            @endif
                            @endcan
                            @endhasanyrole

                            @if($application->status=='Graduated' && $application->level=='College')
                            @if(App\Models\Employment::where('user_id',$application->user_id )->count() > 0)
                            <button data-userID="{{ $application->employment->user_id }}" data-yearEmployed="{{ $application->employment->yearEmployed }}" data-employerType="{{ $application->employment->employerType }}" data-position="{{ $application->employment->position }}" data-employerName="{{ $application->employment->employerName }}" data-employerAddress="{{ $application->employment->employerAddress }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-add-employment">Employed</button>
                            @else
                            <button data-userID="{{ $application->user_id }}" class="btn btn-warning btn-sm mr-1 mb-1 btn-add-employment">Employment</button>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @endif
                @empty

                @endforelse
            </tbody>
           
        </table>

    </div>
    <div class="card-footer">
        
    </div>
</div>

@include('applications.modalApplication')
@include('applications.modalApplicationEdit')
@include('costs.modalGrantPayment')
@include('employment.modalEmployment')
@include('layouts.adminlte.modalDelete')

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>
</script>

<script>
    $(document).ready(function() {

        $('.btn-add-cost').click(function() {
            document.getElementById("formGrantPayment").reset();
            
            var payee = $(this).attr('data-payee');
            var particular = $(this).attr('data-particular');
            var province = $(this).attr('data-province');
            var userId = $(this).attr('data-userId');
            var grantId = $(this).attr('data-grantId');
            var applicationId = $(this).attr('data-applicationId');

            $('[name="payee"]').val(payee)
            $('[name="particulars"]').val(particular)
            $('[name="province"]').val(province)
            $('[name="user_id"]').val(userId)
            $('[name="grant_id"]').val(grantId)
            $('[name="application_id"]').val(applicationId)

            $('#modalGrantPayment').modal('show')
        });

        $('.btn-add-employment').click(function() {
            document.getElementById("formEmployment").reset();
            $('#modalEmployment').modal('show')
            var userID = $(this).attr('data-userID');
            var yearEmployed = $(this).attr('data-yearEmployed');
            var employerType = $(this).attr('data-employerType');
            var position = $(this).attr('data-position');
            var employerName = $(this).attr('data-employerName');
            var employerAddress = $(this).attr('data-employerAddress');

            $('[name="user_id"]').val(userID)
            $('[name="yearEmployed"]').val(yearEmployed)
            $('[name="employerType"]').val(employerType)
            $('[name="position"]').val(position)
            $('[name="employerName"]').val(employerName)
            $('[name="employerAddress"]').val(employerAddress)
        });

        $('.btn-add-application').click(function() {
            document.getElementById("formApplication").reset();
            $('#modalApplication').modal('show')
        });

        $('.btn-edit-application').click(function() {
            var url_id = $(this).attr('data-url');
            $.get(url_id, function(data) {
                console.log(data)
                $('[name="type"]').val(data.application.type)
                $('[name="level"]').val(data.application.level)
                $('[name="school"]').val(data.application.school)
                $('[name="course"]').val(data.application.course)
                $('[name="contribution"]').val(data.application.contribution)
                $('[name="plans"]').val(data.application.plans)
                $('[name="status"]').val(data.application.status)
                $('[name="remarks"]').val(data.application.remarks)
                $('[name="user_id"]').val(data.application.user_id)
                $('[name="grant_id"]').val(data.application.grant_id)
                $('[name="id"]').val(data.application.id)

                $('#modalApplicationEdit').modal('show')
            })
        });

        $('.btn-delete-application').click(function() {
            var url_id = $(this).attr('data-url');
            document.getElementById("formDelete").action = url_id;
            $('#modalDelete').modal('show')

        });

         // Create DataTable
         var table = $('#applicationList').DataTable({
            stateSave: true,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [],
            dom:'<"row"<"col-md-6 mb-3"B><"col-md-6"Q>>' +
                '<"row"<"col-md-5"l><"col-md-7"f>>' +
                '<"row"<"col-md-12"t>>' +
                '<"row"<"col-md-5"i><"col-md-7"p>>',

            buttons: [{
                title: 'Applications_Management_{{ Auth::user()->name }}_{{ date('YmdHis') }}',
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                autoFilter: true,
                sheetName: 'All Application per Grant',
                footer: true,
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                }
            }, 'colvis'],
        });
    });
</script>

<!-- Error/Modal Opener -->
@if (count($errors->application) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalApplicationEdit').modal('show');
    });
</script>
@endif

@if (count($errors->employment) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalEmployment').modal('show');
    });
</script>
@endif

@if (count($errors->cost) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalGrantPayment').modal('show');
    });
</script>
@endif

@endpush