@extends('layouts.adminlte.template')

@section('title', 'Document Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><strong>{{ ucwords(Auth::user()->profile->lastName) }}, {{ ucwords(Auth::user()->profile->firstName) }}</strong> (Documents)</h3>
    </div>
    <div class="card-body">

        <div class="row">
            <!-- <div class="col-md-12">
                <button class="btn btn-primary btn-sm mb-3 float-right btn-add-document">ADD DOCUMENT</button>
            </div> -->
            <table id="documentList" class="table table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Grant ID</th>
                        <th>Requirement ID</th>
                        <th>Filename</th>
                        <th>School Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                    <tr>
                        <td>{{ $document->id }}</td>
                        <td>{{ $document->grantID }}</td>
                        <td>{{ $document->requirementID }}</td>
                        <td>{{ $document->filename }}</td>
                        <td>{{ $document->schoolYear }}-{{ $document->schoolYear +1 }}</td>
                        <td></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Document Uploaded.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    <div class="card-footer">

    </div>
</div>


@include('documents.modalDocument')

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
       
        var table = $('#documentList').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        $('.btn-add-document').click(function() {
            document.getElementById("formDocument").reset();
            $('[name="id"]').val('')
            $('#modalDocument').modal('show')

        });

        $('.btn-edit-document').click(function() {
            var url_id = $(this).attr('data-url');
            $.get(url_id, function(data) {
                console.log(data)
                $('[name="id"]').val(data.user.id)
                $('[name="name"]').val(data.user.name)
                $('[name="email"]').val(data.user.email)

                $('#modalDocument').modal('show')
            })
        })

        $('.btn-delete-document').click(function() {
            var url_id = $(this).attr('data-url');
            document.getElementById("formDelete").action = url_id;
            $('#modalDelete').modal('show')

        });
    });
</script>

@endpush