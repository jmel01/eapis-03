@extends('layouts.adminlte.template')

@section('title', 'Applications Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Applications</h3>
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
                    <th data-priority="10006">Date</th>
                    <th data-priority="10005">Remarks</th>
                    <th data-priority="10004">City/Mun/SubMun</th>
                    <th data-priority="10003">Province</th>
                    <th data-priority="10002">Region</th>
                    <th data-priority="10001">Actions</th>
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
        // Create DataTable
        // var table = $('#applicationList').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     responsive: true,
        //     ajax: '{{ route("applications.index") }}',
        //     deferRender: true,
        //     // lengthMenu: [
        //     //     [10, 25, 50, 100, -1],
        //     //     [10, 25, 50, 100, "All"]
        //     // ],
        //     // order: [],
        //     columns: [{
        //             data: 'avatar',
        //             defaultContent: ''
        //         }, {
        //             data: 'fullname',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'batch',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'type',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'level',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'status',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'created_at',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'remarks',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'city',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'province',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'region',
        //             defaultContent: ''
        //         },
        //         {
        //             data: 'action',
        //             defaultContent: ''
        //         },
        //     ],
        //     // columnDefs: [{
        //     //         targets: 0,
        //     //         data: "avatar",
        //     //         searchable: false,
        //     //         orderable: false,
        //     //         render: function(data, type, row, meta) {
        //     //             var img = '<div class="user-block icon-container"><img src="/storage/users-avatar/:imgID" class="img-circle img-bordered-sm cover" alt="User Image">:online</div>';
        //     //             var online = (row.active_status == 1 ? "<div class='status-circle'>" : "");
        //     //             img = img.replace(':imgID', row.avatar);
        //     //             img = img.replace(':online', online);
        //     //             return img;
        //     //         },
        //     //     }, {
        //     //         targets: 6,
        //     //         render: function(data) {
        //     //             return moment(data).format('LL');
        //     //         }
        //     //     },

        //     //     {
        //     //         targets: -1,
        //     //         render: function(data, type, row, meta) {
        //     //             var btnUserInfo = '<a href="' + '{{ route("users.show",":userID") }}' + '" class="btn btn-info btn-sm mr-1 mb-1">Student Info</a>';
        //     //             btnUserInfo = btnUserInfo.replace(':userID', row.user_id);

        //     //             var btnViewApplication = '@can("application-read")<a href="' + '{{ url("/applications/applicationForm/:appID") }}' + '" class="btn btn-info btn-sm mr-1 mb-1">Application Form</a> @endcan';
        //     //             btnViewApplication = btnViewApplication.replace(':appID', row.id);

        //     //             var btnViewDocs = '@can("document-browse")<a href="' + '{{ url("showAttachment/:grantID/:userID") }}' + '" class="btn btn-info btn-sm mr-1 mb-1">View Files</a> @endcan';
        //     //             btnViewDocs = btnViewDocs.replace(':grantID', row.grant_id);
        //     //             btnViewDocs = btnViewDocs.replace(':userID', row.user_id);

        //     //             var btnAppEdit = ' @can("application-edit")<button onclick="appEdit(this)" data-url="' + '{{ route("applications.edit",":appID") }}' + '" class="btn btn-primary btn-sm mr-1 mb-1">Edit Application</button>@endcan';
        //     //             btnAppEdit = btnAppEdit.replace(':appID', row.id);

        //     //             var btnAppDel = '@can("application-delete")<button onclick="appDel(this)" data-url="' + '{{ route("applications.destroy",":appID") }}' + '" class="btn btn-danger btn-sm mr-1 mb-1">Delete</button>@endcan';
        //     //             btnAppDel = btnAppDel.replace(':appID', row.id);

        //     //             if (row.status == "Approved") {
        //     //                 var btnPayment = '@hasanyrole("Admin|Regional Officer") @can("expenses-add")<button onclick="appPayment(this)" data-payee=":appPayee" data-particular="Grant Payment" data-province=":appProv" data-userId=":appUserID" data-applicationId=":appID" data-grantId=":appGrantID" class="btn btn-success btn-sm mr-1 mb-1">Payment</button>@endcan @endhasanyrole';
        //     //                 btnPayment = btnPayment.replace(':appPayee', row.firstName + ' ' + row.middleName.substr(0, 1) + '. ' + row.lastName);
        //     //                 btnPayment = btnPayment.replace(':appProv', row.province);
        //     //                 btnPayment = btnPayment.replace(':appUserID', row.user_id);
        //     //                 btnPayment = btnPayment.replace(':appID', row.id);
        //     //                 btnPayment = btnPayment.replace(':appGrantID', row.grant_id);
        //     //             } else {
        //     //                 btnPayment = "";
        //     //             }

        //     //             if (row.status == "Graduated" && row.level == "College") {
        //     //                 if (row.employerName) {
        //     //                     var btnEmployment = '<button onclick="Employment(this)" data-userID=":appUserID" data-yearEmployed=":empYear" data-employerType=":empType" data-position=":empPost" data-employerName=":empName" data-employerAddress=":empAddr" class="btn btn-primary btn-sm mr-1 mb-1">Employed</button>';
        //     //                     btnEmployment = btnEmployment.replace(':appUserID', row.user_id);
        //     //                     btnEmployment = btnEmployment.replace(':empYear', row.yearEmployed);
        //     //                     btnEmployment = btnEmployment.replace(':empType', row.employerType);
        //     //                     btnEmployment = btnEmployment.replace(':empPost', row.position);
        //     //                     btnEmployment = btnEmployment.replace(':empName', row.employerName);
        //     //                     btnEmployment = btnEmployment.replace(':empAddr', row.employerAddress);
        //     //                 } else {
        //     //                     var btnEmployment = '<button onclick="Employment(this)" data-userID=":appUserID" class="btn btn-warning btn-sm mr-1 mb-1 btn-add-employment">Not Employed</button>';
        //     //                     btnEmployment = btnEmployment.replace(':appUserID', row.user_id);
        //     //                 }
        //     //             } else {
        //     //                 btnEmployment = "";
        //     //             }


        //     //             return btnUserInfo + btnViewApplication + btnViewDocs + btnAppEdit + btnAppDel + btnPayment + btnEmployment;
        //     //         },
        //     //         searchable: false,
        //     //         orderable: false
        //     //     }
        //     // ],
        //     // dom: '<"row"<"col-md-5"l><"col-md-7"f>>' +
        //     //     '<"row"<"col-md-12 mb-3"B>>' +
        //     //     '<"row"<"col-md-12"t>>' +
        //     //     '<"row"<"col-md-5"i><"col-md-7"p>>',

        //     // buttons: [{
        //     //     title: 'Applications_Management_{{ Auth::user()->name }}_{{ date("YmdHis") }}',
        //     //     extend: 'excelHtml5',
        //     //     text: '<i class="fas fa-file-excel"></i> Excel',
        //     //     autoFilter: true,
        //     //     sheetName: 'List of Applications',
        //     //     footer: true,
        //     //     exportOptions: {
        //     //         columns: ':visible',
        //     //         rows: ':visible'
        //     //     }
        //     // }, 'colvis'],
        // });



        $('#applicationList').DataTable({
            searchDelay: 500,
            pagingType: 'full_numbers',
            iDisplayLength: 10,
            processing: true,
            serverSide: true,
            lengthMenu: [
                [10, 25, 50, 100, '{{$countOfTable}}'],
                [10, 25, 50, 100, 'All']
            ],
            columns: [
                {
                    data: 'avatar',
                    name: 'avatar'
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
                    data: 'created_at',
                    defaultContent: ''
                },
                {
                    data: 'remarks',
                    defaultContent: ''
                },
                {
                    data: 'city',
                    defaultContent: ''
                },
                {
                    data: 'province',
                    defaultContent: ''
                },
                {
                    data: 'region',
                    defaultContent: ''
                },
                {
                    data: 'action',
                    defaultContent: ''
                },
            ],
            columnDefs: [
                {
                    targets: -1,
                    render: function(data, type, row, meta) {
                        var btnUserInfo = '<a href="' + '{{ route("users.show",":userID") }}' + '" class="btn btn-info btn-sm mr-1 mb-1">Student Info</a>';
                        btnUserInfo = btnUserInfo.replace(':userID', row.user_id);

                        var btnViewApplication = '@can("application-read")<a href="' + '{{ url("/applications/applicationForm/:appID") }}' + '" class="btn btn-info btn-sm mr-1 mb-1">Application Form</a> @endcan';
                        btnViewApplication = btnViewApplication.replace(':appID', row.id);

                        var btnViewDocs = '@can("document-browse")<a href="' + '{{ url("showAttachment/:grantID/:userID") }}' + '" class="btn btn-info btn-sm mr-1 mb-1">View Files</a> @endcan';
                        btnViewDocs = btnViewDocs.replace(':grantID', row.grant_id);
                        btnViewDocs = btnViewDocs.replace(':userID', row.user_id);

                        var btnAppEdit = ' @can("application-edit")<button onclick="appEdit(this)" data-url="' + '{{ route("applications.edit",":appID") }}' + '" class="btn btn-primary btn-sm mr-1 mb-1">Edit Application</button>@endcan';
                        btnAppEdit = btnAppEdit.replace(':appID', row.id);

                        var btnAppDel = '@can("application-delete")<button onclick="appDel(this)" data-url="' + '{{ route("applications.destroy",":appID") }}' + '" class="btn btn-danger btn-sm mr-1 mb-1">Delete</button>@endcan';
                        btnAppDel = btnAppDel.replace(':appID', row.id);

                        if (row.status == "Approved") {
                            var btnPayment = '@hasanyrole("Admin|Regional Officer") @can("expenses-add")<button onclick="appPayment(this)" data-payee=":appPayee" data-particular="Grant Payment" data-province=":appProv" data-userId=":appUserID" data-applicationId=":appID" data-grantId=":appGrantID" class="btn btn-success btn-sm mr-1 mb-1">Payment</button>@endcan @endhasanyrole';
                            btnPayment = btnPayment.replace(':appPayee', row.firstName + ' ' + row.middleName.substr(0, 1) + '. ' + row.lastName);
                            btnPayment = btnPayment.replace(':appProv', row.province);
                            btnPayment = btnPayment.replace(':appUserID', row.user_id);
                            btnPayment = btnPayment.replace(':appID', row.id);
                            btnPayment = btnPayment.replace(':appGrantID', row.grant_id);
                        } else {
                            btnPayment = "";
                        }

                        if (row.status == "Graduated" && row.level == "College") {
                            if (row.employerName) {
                                var btnEmployment = '<button onclick="Employment(this)" data-userID=":appUserID" data-yearEmployed=":empYear" data-employerType=":empType" data-position=":empPost" data-employerName=":empName" data-employerAddress=":empAddr" class="btn btn-primary btn-sm mr-1 mb-1">Employed</button>';
                                btnEmployment = btnEmployment.replace(':appUserID', row.user_id);
                                btnEmployment = btnEmployment.replace(':empYear', row.yearEmployed);
                                btnEmployment = btnEmployment.replace(':empType', row.employerType);
                                btnEmployment = btnEmployment.replace(':empPost', row.position);
                                btnEmployment = btnEmployment.replace(':empName', row.employerName);
                                btnEmployment = btnEmployment.replace(':empAddr', row.employerAddress);
                            } else {
                                var btnEmployment = '<button onclick="Employment(this)" data-userID=":appUserID" class="btn btn-warning btn-sm mr-1 mb-1 btn-add-employment">Not Employed</button>';
                                btnEmployment = btnEmployment.replace(':appUserID', row.user_id);
                            }
                        } else {
                            btnEmployment = "";
                        }


                        return btnUserInfo + btnViewApplication + btnViewDocs + btnAppEdit + btnAppDel + btnPayment + btnEmployment;
                    },
                    searchable: false,
                    orderable: false
                }
            ],
            dom: '<"row"<"col-md-5"l><"col-md-7"f>>' +
                '<"row"<"col-md-12 mb-3"B>>' +
                '<"row"<"col-md-12"t>>' +
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
            }, 'colvis'],
            ajax: {
                url: '/applications/indexDT',
                type: 'post',
            }
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
