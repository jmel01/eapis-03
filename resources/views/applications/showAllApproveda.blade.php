@extends('layouts.adminlte.template')

@section('title', 'Approved Applications Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Approved Applications</h3>
    </div>
    <div class="card-body">
        <table id="applicationList" class="table table-sm table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Name</th>
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
                    @if(substr($application->applicant->psgcBrgy->code, 0, 2) == $regionId || Auth::user()->hasAnyRole(["Admin", 'Executive Officer']))
                        <tr>
                            <td>{{ $application->applicant->lastName }}, {{ $application->applicant->firstName }}
                                {{ substr($application->applicant->middleName,1,'1') }}.
                            </td>
                            <td>{{ $application->type }}</td>
                            <td>{{ $application->level }}</td>
                            <td>{{ $application->status }}</td>
                            <td>{{ $application->remarks }}</td>
                            <td>{{ App\Models\Psgc::getRegion($application->applicant->psgcBrgy->code) }}</td>
                            <td>{{ App\Models\Psgc::getProvince($application->applicant->psgcBrgy->code) }}</td>

                            <td>
                                <a href="{{ url('profiles/' . $application->user_id)}}" class="btn btn-info btn-sm">Profile</a>
                                @can('profile-edit')
                                <button data-id="{{ $application->user_id }}" data-url="{{ route('profiles.edit',$application->user_id) }}" class="btn btn-primary btn-sm mr-1 btn-edit-profile">Profile</button>

                                @endcan
                                <a href="{{ url('showAttachment/' . $application->grant_id . '/' . $application->user_id)}}" class="btn btn-info btn-sm">Files</a>
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

@include('profiles.modalProfile')
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

        // Create DataTable
        var table = $('#applicationList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "order": [
                [1, "desc"]
            ],
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

    });
</script>

<!-- Error/Modal Opener -->
@if (count($errors->profile) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalProfile').modal('show');
    });
</script>
@endif

@endpush