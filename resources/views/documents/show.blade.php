@extends('layouts.adminlte.template')

@section('title', 'documents Management')

@push('style')

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of documents</h3>
        @can('document-add')
        <div class="card-tools">
            <a class="btn btn-outline-primary btn-sm" href="{{ route('documents.create') }}">CREATE NEW document</a>
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
                    <td>{{ $document->grantDetails->region}}</td>
                    <td>{{ $document->requirementID }}</td>
                    <td>{{ $document->filename }}</td>
                    <td>{{ $document->schoolYear }}-{{ $document->schoolYear +1 }}</td>
                    <td>
                        <form action="{{ route('documents.destroy', $document->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            @can('document-read')
                            <a href="{{ route('documents.show',$document->id) }}" class="btn btn-info btn-sm">View</a>
                            @endcan
                            @can('document-edit')
                            <a href="{{ route('documents.edit',$document->id) }}" class="btn btn-primary  btn-sm">Edit</a>
                            @endcan
                            @can('document-delete')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No Document Uploaded.</td>
                </tr>
                @endforelse
            </tbody>
        </table>


    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        Footer
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
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
</script>

@endpush