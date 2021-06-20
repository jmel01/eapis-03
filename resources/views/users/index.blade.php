@extends('layouts.adminlte.template')

@section('title', 'Users Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/kt-2.6.2/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.css" />
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
        <h3 class="card-title">List of Users</h3>
    </div>
    <div class="card-body">
        @can('user-add')
        <button class="btn btn-outline-primary btn-sm btn-add-user float-right">CREATE NEW USER</button>
        @endcan
        <table id="userList" class="table table-sm table-hover table-responsive-lg" style="width:100%">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th data-priority="1">Username</th>
                    <th>Profile Name</th>
                    <th>Email</th>
                    <th>City/Mun/SubMun</th>
                    <th>Prov/Dist</th>
                    <th>Region</th>
                    <th>Role</th>
                    <th>Date Registered</th>
                    <th data-priority="2">Actions</th>
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
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/kt-2.6.2/r-2.2.9/sc-2.0.4/sb-1.1.0/datatables.min.js"></script>
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

        //Initialize Select2 Elements
        $('.select2').select2();

        $('.btn-add-user').click(function() {
            document.getElementById("formUser").reset();
            $('[name="id"]').val('')
            $('#modalUser').modal('show')
        });

        // Create DataTable
        var table = $('#userList').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('users.index') }}',
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
                    data: 'roles',
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
                    targets: 8,
                    render: function(data) {
                        return moment(data).format('llll');
                    }
                },
                {
                    targets: -1,
                    render: function(data, type, row, meta) {
                        var btnUserInfo = '<a href="' + '{{ route("users.show",":userID") }}' + '" class="btn btn-info btn-sm mr-1 mb-1">View User Info</a>';
                        btnUserInfo = btnUserInfo.replace(':userID', row.id);

                        var btnUserEdit = ' @can("user-edit")<button onclick="userEdit(this)" data-url="' + '{{ route("users.edit",":userID") }}' + '" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-user">Update</button>@endcan';
                        btnUserEdit = btnUserEdit.replace(':userID', row.id);

                        var btnUserDel = '@can("user-delete")<button onclick="userDel(this)" data-url="' + '{{ route("users.destroy",":userID") }}' + '" class="btn btn-danger btn-sm mr-1 mb-1 btn-delete-user">Delete</button>@endcan';
                        btnUserDel = btnUserDel.replace(':userID', row.id);

                        return btnUserInfo + btnUserEdit + btnUserDel;
                    },
                    searchable: false,
                    orderable: false
                }
            ]
        });
    });
</script>

<!-- Error/Modal Opener -->
@if (count($errors->user) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalUser').modal('show');
    });
</script>
@endif

@endpush