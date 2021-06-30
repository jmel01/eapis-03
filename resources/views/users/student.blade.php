@extends('layouts.adminlte.template')

@section('title', 'Users Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    .icon-container {
        position: relative;
    }

    .status-circle {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #28a745;
        border: 2px solid white;
        bottom: 0;
        right: 0;
        position: absolute;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Users (Student)</h3>
        <div class="card-tools">
            @can('user-add')
            <button class="btn btn-outline-primary btn-sm btn-add-user float-right">CREATE NEW USER</button>
            @endcan
        </div>
    </div>
    <div class="card-body">

        <table id="userList" class="table table-sm table-hover table-responsive-sm compact nowrap" style="width:100%">
            <thead>
                <tr>
                    <th data-priority="1">Avatar</th>
                    <th data-priority="2">Username</th>
                    <th data-priority="3">Profile Name</th>
                    <th data-priority="4">Email</th>
                    <th data-priority="5">Role</th>
                    <th data-priority="6">Date Registered</th>
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

@include('layouts.adminlte.modalDelete')
@include('users.modalUser')

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function userEdit(data_attr) {
        var url_id = data_attr.getAttribute('data-url');
        $.get(url_id, function(data) {
            console.log(data)
            $('[name="id"]').val(data.user.id)
            $('[name="region"]').val(data.user.region)
            $('[name="name"]').val(data.user.name)
            $('[name="email"]').val(data.user.email)

            var roles = $('#roles');

            let selectArray = []

            $.each(data.user.roles, (key, value) => {
                if (roles.find("option[value='" + value.name + "']").length) {
                    selectArray.push(value.name)
                }
            })

            roles.val(selectArray).trigger('change');

            $('#modalUser').modal('show')
        })
    }

    function userDel(data_attr) {
        var url_id = data_attr.getAttribute('data-url');
        document.getElementById("formDelete").action = url_id;
        $('#modalDelete').modal('show')
    }
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Initialize Select2 Elements
        $('.select2').select2();

        $('.btn-add-user').click(function() {
            document.getElementById("formUser").reset();
            $('[name="id"]').val('')
            $('#modalUser').modal('show')
        });

        $('#userList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/users/indexDT',
                type: 'post',
                data: {
                    "statusFilter": 'student'
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'lastName',
                    name: 'lastName',
                    defaultContent: ''
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'userRoles',
                    name: 'userRoles',
                    defaultContent: '',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'created_at',
                    defaultContent: '',
                    searchable: false
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
                targets: 5,
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