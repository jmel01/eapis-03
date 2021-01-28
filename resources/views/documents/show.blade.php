@extends('layouts.adminlte.template')

@section('title', 'Document Management')

@push('style')

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Documents</h3>
        @can('document-add')
        <div class="card-tools">
            <a class="btn btn-outline-primary btn-sm" href="{{ url()->previous() }}">BACK</a>
        </div>
        @endcan
    </div>
    <div class="card-body">

        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p></p>
        </div>
        @endif

        <table id="documentList" class="table table-striped table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Grant Name/Year</th>
                    <th>Requirement Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $document)
                <tr>
                    <td>{{ App\Models\Psgc::getRegion($document->grantDetails->region) }} ({{ $document->grantDetails->acadYr }}-{{ $document->grantDetails->acadYr + 1}})</td>
                    <td>{{ $document->requirementDetails->description }}</td>
                    <td>
                        <a href="/uploads/{{ $document->filepath }}" target="_blank" class="btn btn-info btn-sm">View</a>
                        @can('document-delete')
                        <button data-url="{{ route('documents.destroy', $document->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-document">Delete</button>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No Document Uploaded.</td>
                </tr>
                @endforelse
            </tbody>
        </table>


    </div>

    <div class="card-footer">
        Footer
    </div>

</div>

@include('layouts.adminlte.modalDelete')
@endsection

@push('scripts')
<script>
    $(function() {
        $('#documentList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    $('.btn-delete-document').click(function() {
        var url_id = $(this).attr('data-url');
        document.getElementById("formDelete").action = url_id;
        $('#modalDelete').modal('show')
    });
</script>

@endpush