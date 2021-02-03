@extends('layouts.adminlte.template')

@section('title', 'My Document')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Document</h3>

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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
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