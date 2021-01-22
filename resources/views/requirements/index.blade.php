@extends('layouts.adminlte.template')

@section('title', 'Requirement Management')

@push('style')

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Requirement</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="form-group col-md-12">
                <button type="button" class="btn btn-primary btn-add-requirement float-right">
                    Add Requirement
                </button>
            </div>
        </div>

        <table id="reqList" class="table table-hover table-responsive-lg">
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
                       
                        <button data-description="{{ $requirement->description }}" data-id="{{ $requirement->id }}" class="btn btn-primary btn-sm mr-1 btn-edit-requirement">Edit</button>
                       

                        <button data-url="{{ route('requirements.destroy', $requirement->id) }}" class="btn btn-danger btn-sm mr-1 btn-delete-requirement">Delete</button>

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
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
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