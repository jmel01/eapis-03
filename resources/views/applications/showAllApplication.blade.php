@extends('layouts.adminlte.template')

@section('title', 'All Applications Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of All Applications</h3>
    </div>
    <div class="card-body">
        <table id="applicationList" class="table table-sm table-hover table-responsive">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Batch</th>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Region</th>
                    <th>Province</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $application)
                @hasanyrole('Admin|Executive Officer')
                <tr>
                    <td>{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }}
                        {{ ucwords(substr($application->applicant->middleName,1,'1')) }}.
                    </td>
                    <td>{{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1 }}</td>
                    <td>{{ $application->type }}</td>
                    <td>{{ $application->level }}</td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->remarks }}</td>
                    <td>{{ App\Models\Psgc::getRegion($application->applicant->psgcBrgy->code) }}</td>
                    <td>{{ App\Models\Psgc::getProvince($application->applicant->psgcBrgy->code) }}</td>

                    <td>
                        @can('application-edit')
                        <button data-url="{{ route('applications.edit',$application->id) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-application">Update Application</button>
                        @endcan
                        @can('profile-edit')
                        <button data-id="{{ $application->user_id }}" data-url="{{ route('profiles.edit',$application->user_id) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-profile">Update Profile</button>
                        @endcan
                        <a href="{{ url('/applications/applicationForm/' . $application->id)}}" target="_blank" class="btn btn-info btn-sm mr-1 mb-1">View Application</a>
                        <a href="{{ url('showAttachment/' . $application->grant_id . '/' . $application->user_id)}}" class="btn btn-info btn-sm mr-1 mb-1">View Files</a>
                    </td>
                </tr>
                @endhasanyrole

                @hasanyrole('Regional Officer')
                @if(substr($application->applicant->psgcBrgy->code, 0, 2) == $locationId)
                <tr>
                    <td>{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }}
                        {{ ucwords(substr($application->applicant->middleName,1,'1')) }}.
                    </td>
                    <td>{{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1 }}</td>
                    <td>{{ $application->type }}</td>
                    <td>{{ $application->level }}</td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->remarks }}</td>
                    <td>{{ App\Models\Psgc::getRegion($application->applicant->psgcBrgy->code) }}</td>
                    <td>{{ App\Models\Psgc::getProvince($application->applicant->psgcBrgy->code) }}</td>

                    <td>
                        @can('application-edit')
                        <button data-url="{{ route('applications.edit',$application->id) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-application">Update Application</button>
                        @endcan
                        @can('profile-edit')
                        <button data-id="{{ $application->user_id }}" data-url="{{ route('profiles.edit',$application->user_id) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-profile">Update Profile</button>
                        @endcan
                        <a href="{{ url('/applications/applicationForm/' . $application->id)}}" target="_blank" class="btn btn-info btn-sm mr-1 mb-1">View Application</a>
                        <a href="{{ url('showAttachment/' . $application->grant_id . '/' . $application->user_id)}}" class="btn btn-info btn-sm mr-1 mb-1">View Files</a>
                    </td>
                </tr>
                @endif
                @endhasanyrole

                @hasanyrole('Provincial Officer|Community Service Officer')
                @if(substr($application->applicant->psgcBrgy->code, 0, 4) == $locationId)
                <tr>
                    <td>{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }}
                        {{ ucwords(substr($application->applicant->middleName,1,'1')) }}.
                    </td>
                    <td>{{ $application->grant->acadYr }}-{{ $application->grant->acadYr + 1 }}</td>
                    <td>{{ $application->type }}</td>
                    <td>{{ $application->level }}</td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->remarks }}</td>
                    <td>{{ App\Models\Psgc::getRegion($application->applicant->psgcBrgy->code) }}</td>
                    <td>{{ App\Models\Psgc::getProvince($application->applicant->psgcBrgy->code) }}</td>

                    <td>
                        @can('application-edit')
                        <button data-url="{{ route('applications.edit',$application->id) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-application">Update Application</button>
                        @endcan
                        @can('profile-edit')
                        <button data-id="{{ $application->user_id }}" data-url="{{ route('profiles.edit',$application->user_id) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-profile">Update Profile</button>
                        @endcan
                        <a href="{{ url('/applications/applicationForm/' . $application->id)}}" target="_blank" class="btn btn-info btn-sm mr-1 mb-1">View Application</a>
                        <a href="{{ url('showAttachment/' . $application->grant_id . '/' . $application->user_id)}}" class="btn btn-info btn-sm mr-1 mb-1">View Files</a>
                    </td>
                </tr>
                @endif
                @endhasanyrole

                @endforeach
            </tbody>
        </table>

    </div>
    <div class="card-footer">

    </div>
</div>

@include('profiles.modalProfile')
@include('applications.modalApplicationEdit')
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {

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
            })
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
@if (count($errors->application) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalApplicationEdit').modal('show');
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