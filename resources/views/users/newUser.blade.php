@extends('layouts.adminlte.template')

@section('title', 'New Registered Users')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
<link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of New Users</h3>
    </div>
    <div class="card-body">
       
        <table id="userList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Profile Name</th>
                    <th>Email</th>
                    <th>Region</th>
                    <th>Role</th>
                    <th>Date Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                @if( empty($user->application))
                <tr>
                    <td>
                        <div class="user-block">
                            <img src="/storage/users-avatar/{{$user->avatar}}" class="img-circle img-bordered-sm cover" alt="User Image">
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
                        @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $userRole)
                        <span class="badge badge-info">{{ $userRole }}</span><br>
                        @endforeach
                        @endif
                    </td>
                    <td>{{$user->created_at->format('M. d, Y | h:i:s a')}}</td>
                    <td>

                        @can('profile-edit')
                        @if(!empty($user->profile))
                        <button data-id="{{ $user->id }}" data-url="{{ route('profiles.edit',$user->id) }}" class="btn btn-warning btn-sm mr-1 btn-edit-profile">Update Profile</button>
                        @else
                        <button data-id="{{ $user->id }}" data-url="{{ route('profiles.edit',$user->id) }}" class="btn btn-success btn-sm mr-1 btn-edit-profile">Create Profile</button>
                        @endif
                        @endcan

                        @can('application-add')
                        @if($user->hasRole('Applicant'))
                        @if($user->profile!='')
                        <button data-id="{{ $user->id }}" class="btn btn-success btn-sm mr-1 btn-add-application">Apply</button>
                        @endif
                        @endif
                        @endcan

                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="card-footer">

    </div>
</div>

@include('layouts.adminlte.modalDelete')
@include('applications.modalApplication')
@include('applications.modalApplicationNotAvailable')
@include('users.modalUser')
@include('profiles.modalProfile')

@endsection

@push('scripts')
@include('psgc.scriptPsgc')
@include('ethnogroups.scriptEthno')
@include('profiles.scriptAddSibling')
@include('profiles.scriptAddSchool')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {

        $('.btn-add-application').click(function() {
            document.getElementById("formApplication").reset();
            var id = $(this).attr('data-id');

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

        });

        $('.btn-edit-profile').click(function() {
            var id = $(this).attr('data-id');
            var url_id = $(this).attr('data-url');
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

        });

        // Create DataTable
        var table = $('#userList').DataTable({
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