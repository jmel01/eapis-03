@extends('layouts.adminlte.template')

@section('title', 'Roles Management')

@push('style')

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Roles</h3>
        @can('role-add')
        <div class="card-tools">
            <a class="btn btn-outline-primary btn-sm" href="{{ route('roles.create') }}">CREATE NEW ROLE</a>
        </div>
        @endcan
    </div>
    <div class="card-body">
<<<<<<< HEAD

        <table id="roleList" class="table table-striped table-hover table-responsive-lg">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            @can('role-read')
                            <a href="{{ route('roles.show',$role->id) }}" class="btn btn-info btn-sm">View</a>
                            @endcan
                            @can('role-edit')
                            <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-primary  btn-sm">Edit</a>
                            @endcan
                            @can('role-delete')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
                @endforeach
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
=======
        <div class="row">
            <div class="col-12">
                <table id="roleList" class="table table-striped table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @can('role-read')
                                    <a href="{{ route('roles.show',$role->id) }}" class="btn btn-info btn-sm">View</a>
                                    @endcan
                                    @can('role-edit')
                                    <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-primary  btn-sm">Edit</a>
                                    @endcan
                                    @can('role-delete')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer">

    </div>

</div>

>>>>>>> f201596 (fixed table and buttons css)
@endsection

@push('scripts')
<script>
    $(function() {
        $('#roleList').DataTable({
<<<<<<< HEAD
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
=======
            "fixedHeader": {
                header: true,
                footer: true
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [],
>>>>>>> f201596 (fixed table and buttons css)
        });
    });
</script>

@endpush