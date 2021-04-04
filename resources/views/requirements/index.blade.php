@extends('layouts.adminlte.template')

@section('title', 'Requirement Management')

@push('style')

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Requirement</h3>

        <div class="card-tools">
        
        @can('requirements-add')
        
                <button type="button" class="btn btn-sm btn-primary btn-add-requirement float-right">
                    Add Requirement
                </button>
            
        @endcan</div>
    </div>
    <div class="card-body">
        
        <table id="reqList" class="table table-sm table-striped table-hover">
            <thead>
                <tr>
                    <th>Requirements</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requirements as $key => $requirement)
                <tr>
                    <td>{{ $requirement->description }}</td>
                    <td>
                       @can('requirements-edit')
                        <button data-description="{{ $requirement->description }}" data-id="{{ $requirement->id }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-requirement">Edit</button>
                       @endcan

                       @can('requirements-delete')
                        <button data-url="{{ route('requirements.destroy', $requirement->id) }}" class="btn btn-danger btn-sm mr-1 mb-1 btn-delete-requirement">Delete</button>
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

<div class="modal fade" id="modalRequirement">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Requirement Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('requirements.store') }}" id="formRequirement">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Requirement Description</label>
                        <input name="description" type="text" value="{{old('description')}}" class="form-control {{$errors->requirement->first('description') == null ? '' : 'is-invalid'}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" value="{{old('id')}}" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('layouts.adminlte.modalDelete')
@endsection

@push('scripts')
<script>
    $(function() {
        $('#reqList').DataTable({
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

    $('.btn-add-requirement').click(function() {
        document.getElementById("formRequirement").reset();
        $('[name="id"]').val('')
        $('#modalRequirement').modal('show')
    });

    $('.btn-edit-requirement').click(function() {
    var id = $(this).attr('data-id');
    var description = $(this).attr('data-description');

    $('[name="id"]').val(id)
    $('[name="description"]').val(description)
    $('#modalRequirement').modal('show')
    })

    $('.btn-delete-requirement').click(function() {
        var url_id = $(this).attr('data-url');
        document.getElementById("formDelete").action = url_id;
        $('#modalDelete').modal('show')

    });
</script>

@if (count($errors->requirement) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalRequirement').modal('show');
    });
</script>
@endif
@endpush