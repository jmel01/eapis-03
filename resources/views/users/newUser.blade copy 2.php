@extends('layouts.adminlte.template')

@section('title', 'New Registered Users')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/kt-2.6.2/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of New Users</h3>
    </div>
    <div class="card-body">

        <table id="userList" class="table table-sm table-hover table-responsive-sm" style="width:100%">
            <thead>
                <tr>
                    <th class="align-middle">Avatar</th>
                    <th class="align-middle" data-priority="1">Username</th>
                    <th class="align-middle">Profile Name</th>
                    <th class="align-middle">Email</th>
                    <th class="align-middle">City/Mun/SubMun</th>
                    <th class="align-middle">Prov/Dist</th>
                    <th class="align-middle">Region</th>
                    <th class="align-middle">Date Registered</th>
                    <th class="align-middle" data-priority="2">Actions</th>
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
@include('applications.modalApplication')
@include('applications.modalApplicationNotAvailable')
@include('profiles.modalProfile')

@endsection

@push('scripts')
@include('psgc.scriptPsgc')
@include('ethnogroups.scriptEthno')
@include('profiles.scriptAddSibling')
@include('profiles.scriptAddSchool')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/kt-2.6.2/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.js"></script>
<script>
    function profileEdit(data_attr) {
        var id = data_attr.getAttribute('data-id');
        var url_id = data_attr.getAttribute('data-url');

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
            $('#region').trigger("change")
        })
    }

    function userApply(data_attr) {

        document.getElementById("formApplication").reset();
        var id = data_attr.getAttribute('data-id');

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
    }
</script>
<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#userList').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('newUser') }}',
            deferRender: true,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [],
            columns: [{
                    data: 'avatar',
                    defaultContent: ''
                },
                {
                    data: 'name'
                },
                {
                    data: 'fullname',
                    defaultContent: ''
                },
                {
                    data: 'email'
                },
                {
                    data: 'userCity',
                    defaultContent: '',
                    visible: false
                },
                {
                    data: 'userProv',
                    defaultContent: '',
                    visible: false
                },
                {
                    data: 'userRegion',
                    defaultContent: ''
                },
                {
                    data: 'created_at',
                    defaultContent: ''
                },
                {
                    data: null,
                    defaultContent: ''
                }
            ],
            columnDefs: [{
                    targets: 0,
                    data: "avatar",
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        var img = '<div class="user-block icon-container"><img src="/storage/users-avatar/:imgID" class="img-circle img-bordered-sm cover" alt="User Image">:online</div>';
                        var online = (row.active_status == 1 ? "<div class='status-circle'>" : "");
                        img = img.replace(':imgID', data);
                        img = img.replace(':online', online);
                        return img;
                    },
                },
                {
                    targets: 7,
                    render: function(data) {
                        return moment(data).format('llll');
                    }
                },
                {
                    targets: -1,
                    render: function(data, type, row, meta) {

                        var btnProfileEdit = ' @can("profile-edit")<button onclick="profileEdit(this)" data-id=":userID" data-url="' + '{{ route("profiles.edit",":userID") }}' + '" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-profile">Update Profile</button>@endcan';
                        btnProfileEdit = btnProfileEdit.replaceAll(':userID', row.id);

                        var btnProfileCreate = ' @can("profile-edit")<button onclick="profileEdit(this)" data-id=":userID" data-url="' + '{{ route("profiles.edit",":userID") }}' + '" class="btn btn-warning btn-sm mr-1 mb-1 btn-edit-profile">Create Profile</button>@endcan';
                        btnProfileCreate = btnProfileCreate.replaceAll(':userID', row.id);

                        var btnApply = '@can("application-add")<button onclick="userApply(this)" data-id=":userID" class="btn btn-success btn-sm mr-1 mb-1 btn-add-application">Apply</button>@endcan';
                        btnApply = btnApply.replace(':userID', row.id);


                        if (row.profile !== null) {
                            return btnProfileEdit + btnApply;
                        } else {
                            return btnProfileCreate;
                        }
                    },
                    searchable: false,
                    orderable: false
                }
            ]
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

@endpush