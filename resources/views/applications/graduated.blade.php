@extends('layouts.adminlte.template')

@section('title', 'Applications Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Applications (Graduated)</h3>
        <div class="card-tools">
            <a href="/grants" class="btn btn-outline-primary btn-sm float-right mr-1">BACK</a>
        </div>
    </div>
    <div class="card-body">

        <table id="applicationList" class="table table-sm table-hover table-responsive-sm compact nowrap" style="width:100%">
            <thead>
                <tr>
                    <th data-priority="1">Avatar</th>
                    <th data-priority="2">Name</th>
                    <th data-priority="3">Batch</th>
                    <th data-priority="4">Type</th>
                    <th data-priority="5">Level</th>
                    <th data-priority="6">Status</th>
                    <th data-priority="7">Date</th>
                    <th data-priority="8">Remarks</th>
                    <th data-priority="10003">City/Mun/SubMun</th>
                    <th data-priority="10002">Province</th>
                    <th data-priority="10001">Region</th>
                    <th data-priority="10004">Actions</th>
                </tr>
            </thead>
            <tbody>

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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.js"></script>
<script>
    function appEdit(data_attr) {
        var url_id = data_attr.getAttribute('data-url');
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
    }

    function appDel(data_attr) {
        var url_id = data_attr.getAttribute('data-url');
        document.getElementById("formDelete").action = url_id;
        $('#modalDelete').modal('show')
    }

    function appPayment(data_attr) {
        document.getElementById("formGrantPayment").reset();

        var payee = data_attr.getAttribute('data-payee');
        var particular = data_attr.getAttribute('data-particular');
        var province = data_attr.getAttribute('data-province');
        var userId = data_attr.getAttribute('data-userId');
        var applicationId = data_attr.getAttribute('data-applicationId');
        var grantId = data_attr.getAttribute('data-grantId');

        $('[name="payee"]').val(payee)
        $('[name="particulars"]').val(particular)
        $('[name="province"]').val(province)
        $('[name="user_id"]').val(userId)
        $('[name="application_id"]').val(applicationId)
        $('[name="grant_id"]').val(grantId)
        $('#modalGrantPayment').modal('show')
    }

    function Employment(data_attr) {
        document.getElementById("formEmployment").reset();

        var userID = data_attr.getAttribute('data-userID');
        var yearEmployed = data_attr.getAttribute('data-yearEmployed');
        var employerType = data_attr.getAttribute('data-employerType');
        var position = data_attr.getAttribute('data-position');
        var employerName = data_attr.getAttribute('data-employerName');
        var employerAddress = data_attr.getAttribute('data-employerAddress');

        $('[name="user_id"]').val(userID)
        $('[name="yearEmployed"]').val(yearEmployed)
        $('[name="employerType"]').val(employerType)
        $('[name="position"]').val(position)
        $('[name="employerName"]').val(employerName)
        $('[name="employerAddress"]').val(employerAddress)
        $('#modalEmployment').modal('show')
    }
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#applicationList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/applications/indexDT',
                type: 'post',
                data: {
                    "statusFilter": 'graduated'
                }
            },
            lengthMenu: [
                [10, 25, 50, 100, 500, '{{$countOfTable}}'],
                [10, 25, 50, 100, 500, 'All']
            ],
            responsive: true,
            deferRender: true,
            searchDelay: 2000,

            columns: [{
                    data: 'avatar',
                    name: 'avatar',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fullname',
                    name: 'fullname'
                },
                {
                    data: 'batch',
                    name: 'batch'
                },
                {
                    data: 'type',
                    defaultContent: ''
                },
                {
                    data: 'level',
                    defaultContent: ''
                },
                {
                    data: 'status',
                    defaultContent: ''
                },
                {
                    data: 'date_graduated',
                    defaultContent: '',
                },
                {
                    data: 'remarks',
                    defaultContent: ''
                },
                {
                    data: 'city_name',
                    defaultContent: ''
                },
                {
                    data: 'province_name',
                    defaultContent: ''
                },
                {
                    data: 'region_name',
                    defaultContent: ''
                },
                {
                    data: 'action',
                    defaultContent: '',
                    searchable: false,
                    orderable: false
                },
            ],
            columnDefs: [{
                targets: 6,
                render: function(data) {
                    return moment(data).format('LL');
                }
            }],

            dom: '<"row"<"col-md-5"l><"col-md-7"f>>' +
                '<"row"<"col-md-12 mb-3"B>>' +
                '<"row"<"col-md-12"tr>>' +
                '<"row"<"col-md-5"i><"col-md-7"p>>',

            buttons: [{
                title: 'Applications_Management_{{ Auth::user()->name }}_{{ date("YmdHis") }}',
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                autoFilter: true,
                sheetName: 'List of Applications',
                footer: true,
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                }
            }, 'colvis']
        })
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