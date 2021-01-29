@extends('layouts.adminlte.template')

@section('title', 'Users Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
<link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
        <table id="userList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Region</th>
                    <th>Role</th>
                    <th>Date Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                <tr>
                    <td>
                        <div class="user-block">
                            <img src="/storage/users-avatar/{{$user->avatar}}" class="img-circle img-bordered-sm cover" alt="User Image">
                        </div>
                    </td>
                    <td> {{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ App\Models\Psgc::getRegion($user->region) }}</td>
                    <td>
                        @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $userRole)

                        <span class="badge badge-primary">{{ $userRole }}</span>
                        @endforeach
                        @endif
                    </td>
                    <td>{{$user->created_at->format('M. d, Y | h:i:s a')}}</td>
                    <td>
                        @can('application-add')
                        @if($user->hasRole('Applicant'))
                        @if($user->profile!='')
                        <button data-id="{{ $user->id }}" class="btn btn-success btn-sm mr-1 btn-add-application">Apply</button>
                        @endif
                        @endif
                        @endcan

                        @can('profile-edit')
                        <button data-id="{{ $user->id }}" data-url="{{ route('profiles.edit',$user->id) }}" class="btn btn-primary btn-sm mr-1 btn-edit-profile">Profile</button>
                        @endcan

                        @can('user-edit')
                        <button data-url="{{ route('users.edit',$user->id) }}" class="btn btn-primary btn-sm mr-1 btn-edit-user">Edit</button>
                        @endcan

                        @can('user-delete')
                        <button data-url="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-user">Delete</button>
                        @endcan

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="card-footer">
        Footer
    </div>
</div>

@include('layouts.adminlte.modalDelete')
@include('applications.modalApplication')
@include('users.modalUser')

@endsection

@push('scripts')
@include('psgc.scriptPsgc')
@include('profiles.modalProfile')
@include('profiles.scriptAddSibling')
@include('profiles.scriptAddSchool')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('/bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#userList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        //Initialize Select2 Elements
        $('.select2').select2()

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
                $('[name="name"]').val(data.user.name)
                $('[name="email"]').val(data.user.email)
                $('#modalUser').modal('show')
            })
        })

        $('.btn-delete-user').click(function() {
            var url_id = $(this).attr('data-url');
            document.getElementById("formDelete").action = url_id;
            $('#modalDelete').modal('show')

        });

        $('.btn-add-application').click(function() {
            document.getElementById("formApplication").reset();
            var id = $(this).attr('data-id');
            $('[name="user_id"]').val(id)
            $('#modalApplication').modal('show')

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
                $('#region').trigger("change")
            })

        })
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

@if (count($errors->profile) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalProfile').modal('show');
    });
</script>
@endif

@endpush
