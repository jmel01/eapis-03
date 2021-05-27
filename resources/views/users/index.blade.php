@extends('layouts.adminlte.template')

@section('title', 'Users Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
<link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/select2/css/select2.min.css') }}">
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
        <table id="userList" class="table table-sm table-hover table-responsive-sm">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Profile Name</th>
                    <th>Email</th>
                    <th>Region</th>
                    <th>Province</th>
                    <th>Role</th>
                    <th>Date Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                <tr>
                    <td>
                        <div class="user-block icon-container">
                            <img src="/storage/users-avatar/{{$user->avatar}}" class="img-circle img-bordered-sm cover" alt="User Image">
                            @if($user->active_status)
                                <div class='status-circle'>
                            @endif
                        </div>
                    </td>
                    <td> {{ $user->name }}</td>
                    <td>
                        @if(!empty($user->profile))
                        {{ ucwords($user->profile->lastName ?? '') }}, {{ ucwords($user->profile->firstName ?? '') }} {{ ucwords(substr($user->profile->middleName ?? '',1,'1')) }}.
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ App\Models\Psgc::getRegion($user->region) }}</td>
                    <td>
                        @if(!empty($user->profile))
                        {{ App\Models\Psgc::getProvince($user->profile->psgCode) }}
                        @endif
                    </td>
                    <td>
                        @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $userRole)
                        <span class="badge badge-info">{{ $userRole }}</span><br>
                        @endforeach
                        @endif
                    </td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <a href="{{ route('users.show',$user->id) }}" class="btn btn-info btn-sm mr-1 mb-1">View User Info</a>
                        @can('user-edit')
                        <button data-url="{{ route('users.edit',$user->id) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-user">Update</button>
                        @endcan

                        @can('user-delete')
                        <button data-url="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm mr-1 mb-1 btn-delete-user">Delete</button>
                        @endcan

                    </td>
                </tr>
                @endforeach
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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('/bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {

        //Initialize Select2 Elements
        $('.select2').select2();

        $('.btn-add-user').click(function() {
            document.getElementById("formUser").reset();
            $('[name="id"]').val('')
            $('#modalUser').modal('show')
        });

        $('.btn-edit-user').click(function() {
            var url_id = $(this).attr('data-url');
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
        });

        $('.btn-delete-user').click(function() {
            var url_id = $(this).attr('data-url');
            document.getElementById("formDelete").action = url_id;
            $('#modalDelete').modal('show')

        });

        // Create DataTable
        var table = $('#userList').DataTable({
            stateSave: true,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [],
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