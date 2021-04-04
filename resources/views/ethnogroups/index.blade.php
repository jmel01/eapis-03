@extends('layouts.adminlte.template')

@section('title', 'Ethnolinguistic Group Management')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Ethnolinguistic Group</h3>
    </div>
    <div class="card-body">
        @can('ethnogroups-add')
        <button class="btn btn-outline-primary btn-sm btn-add-ethnoGroup float-right">ADD GROUP</button>
        @endcan
        <table id="ethnoGroupList" class="table table-sm table-hover table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Region</th>
                    <th>Ethnolinguistic Group</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $ethnoGroup)
                <tr>
                    <td>{{ $ethnoGroup->id }}</td>
                    <td>
                        @foreach($regions as $region)
                        {{$region->code == $ethnoGroup->region ? $region->name:'' }}
                        @endforeach
                    </td>
                    <td>{{ $ethnoGroup->ipgroup }}</td>
                    <td>
                        @can('ethnogroups-edit')
                        <button class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-ethnoGroup" data-id="{{ $ethnoGroup->id }}" data-region="{{ $ethnoGroup->region }}" data-ipgroup="{{ $ethnoGroup->ipgroup }}">Edit</button>
                        @endcan
                        @can('ethnogroups-delete')
                        <button data-url="{{ route('ethnogroups.destroy', $ethnoGroup->id) }}" class="btn btn-danger btn-sm mr-1 mb-1 btn-delete-ethnoGroup">Delete</button>
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

@include('ethnogroups.modalEthnoGroup')
@include('layouts.adminlte.modalDelete')

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        // Create DataTable
        var table = $('#ethnoGroupList').DataTable({
            fixedHeader: {
                header: true,
                footer: true
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [
                [0, "desc"]
            ],
        });
    })

    $('.btn-add-ethnoGroup').click(function() {
        document.getElementById("formEthnoGroup").reset();
        $('[name="id"]').val('')
        $('#modalEthnoGroup').modal('show')

    });

    $('.btn-edit-ethnoGroup').click(function() {
        var id = $(this).attr('data-id');
        var region = $(this).attr('data-region');
        var ipgroup = $(this).attr('data-ipgroup');

        $('[name="id"]').val(id)
        $('[name="region"]').val(region)
        $('[name="ipgroup"]').val(ipgroup)

        $('#modalEthnoGroup').modal('show')
    });

    $('.btn-delete-ethnoGroup').click(function() {
        var url_id = $(this).attr('data-url');
        document.getElementById("formDelete").action = url_id;
        $('#modalDelete').modal('show')

    });
</script>

<!-- Error/Modal Opener -->
@if (count($errors->ethnoGroup) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalEthnoGroup').modal('show');
    });
</script>
@endif

@endpush