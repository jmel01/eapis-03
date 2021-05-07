@extends('layouts.adminlte.template')

@section('title', 'Scholars Alumni')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Graduated Scholars</h3>
    </div>
    <div class="card-body">

        <a href="/grants" class="btn btn-outline-primary btn-sm float-right mr-1">BACK</a>

        <table id="applicationList" class="table table-sm table-hover table-responsive-sm">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Date Graduated</th>
                    @if($subStrLen == '0')
                    <th>Region</th>
                    @endif
                    <th>Province</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $alumni)
                @if(substr($alumni->applicant->psgcBrgy->code, 0, $subStrLen) == $locationId || $subStrLen == '0')
                <tr>
                    <td>{{ ucwords($alumni->applicant->lastName) }}, {{ ucwords($alumni->applicant->firstName) }}
                        {{ ucwords(substr($alumni->applicant->middleName,1,'1')) }}.
                    </td>

                    <td>{{ $alumni->type }}</td>
                    <td>{{ $alumni->level }}</td>

                    <td>{{ $alumni->date_graduated }}</td>
                    @if($subStrLen == '0')
                    <td>{{ App\Models\Psgc::getRegion($alumni->applicant->psgcBrgy->code) }}</td>
                    @endif
                    <td>{{ App\Models\Psgc::getProvince($alumni->applicant->psgcBrgy->code) }}</td>
                    <td>
                        <a href="{{ route('users.show',$alumni->user_id) }}" class="btn btn-info btn-sm mr-1 mb-1">View Student Info</a>
                        @can('alumni-read')
                        <a href="{{ url('/applications/applicationForm/' . $alumni->id)}}" class="btn btn-info btn-sm mr-1 mb-1">View Application</a>
                        @endcan



                        @if($alumni->level=='College')
                        @if(App\Models\Employment::where('user_id',$alumni->user_id )->count() > 0)
                        <button data-userID="{{ $alumni->employment->user_id }}" data-yearEmployed="{{ $alumni->employment->yearEmployed }}" data-employerType="{{ $alumni->employment->employerType }}" data-position="{{ $alumni->employment->position }}" data-employerName="{{ $alumni->employment->employerName }}" data-employerAddress="{{ $alumni->employment->employerAddress }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-add-employment">Employed</button>
                        @else
                        <button data-userID="{{ $alumni->user_id }}" class="btn btn-warning btn-sm mr-1 mb-1 btn-add-employment">Not Employed</button>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js">
</script>

<script>
    $(document).ready(function() {

        $('.btn-add-cost').click(function() {
            document.getElementById("formGrantPayment").reset();
            $('#modalGrantPayment').modal('show')
            var payee = $(this).attr('data-payee');
            var particular = $(this).attr('data-particular');
            var province = $(this).attr('data-province');
            var userId = $(this).attr('data-userId');
            var applicationId = $(this).attr('data-applicationId');
            var grantId = $(this).attr('data-grantId');

            $('[name="payee"]').val(payee)
            $('[name="particulars"]').val(particular)
            $('[name="province"]').val(province)
            $('[name="user_id"]').val(userId)
            $('[name="application_id"]').val(applicationId)
            $('[name="grant_id"]').val(grantId)
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

        $('.btn-add-value').click(function() {
            document.getElementById("formApplication").reset();
            $('#modalApplication').modal('show')
        });

        $('.btn-edit-value').click(function() {
            var url_id = $(this).attr('data-url');
            $.get(url_id, function(data) {
                console.log(data)
                $('[name="type"]').val(data.value.type)
                $('[name="level"]').val(data.value.level)
                $('[name="school"]').val(data.value.school)
                $('[name="course"]').val(data.value.course)
                $('[name="contribution"]').val(data.value.contribution)
                $('[name="plans"]').val(data.value.plans)
                $('[name="status"]').val(data.value.status)
                $('[name="remarks"]').val(data.value.remarks)
                $('[name="user_id"]').val(data.value.user_id)
                $('[name="grant_id"]').val(data.value.grant_id)
                $('[name="id"]').val(data.value.id)

                $('#modalApplicationEdit').modal('show')
            })
        });

        $('.btn-delete-value').click(function() {
            var url_id = $(this).attr('data-url');
            document.getElementById("formDelete").action = url_id;
            $('#modalDelete').modal('show')

        });

        // Create DataTable
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
    });
</script>

<!-- Error/Modal Opener -->
@if (count($errors->value) > 0)
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