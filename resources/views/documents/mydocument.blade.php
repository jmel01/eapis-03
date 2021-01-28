@extends('layouts.adminlte.template')

@section('title', 'My Document')

@push('style')

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Documents</h3>

        <div class="card-tools">
            <button class="btn btn-outline-primary btn-sm btn-add-document">ADD FILE</button>
        </div>

    </div>
    <div class="card-body">

        <table id="documentList" class="table table-striped table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Filename</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $document)
                <tr>
                    <td>{{ $document->filename }}</td>
                    <td>
                        <a href="/uploads/{{ $document->filepath }}" target="_blank" class="btn btn-info btn-sm">View</a>
                        <button data-url="{{ route('documents.destroy', $document->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-document">Delete</button>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">No Document Uploaded.</td>
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
@include('documents.modalMyDocument')
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

    $('.btn-add-document').click(function() {
        document.getElementById("formDocument").reset();
        $('#modalDocument').modal('show')

    });

    $('.btn-delete-document').click(function() {
        var url_id = $(this).attr('data-url');
        document.getElementById("formDelete").action = url_id;
        $('#modalDelete').modal('show')
    });
</script>

@endpush