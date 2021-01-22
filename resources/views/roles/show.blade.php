@extends('layouts.adminlte.template')

@section('title', 'Roles Management')

@push('style')

@endpush

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Role Details</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group">
            <label>Role name</label>
            <input name="name" type="text" class="form-control" value="{{ $role->name }}">
        </div>

        <div class="form-group">
            <label>Permissions</label>
            @foreach ($rolePermissions as $value)
            <div class="form-check">
                <input name="permission[]" value="{{ $value->id }}" class="form-check-input" type="checkbox" checked>
                <label class="form-check-label">{{ $value->name }}</label>
            </div>
            @endforeach
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
    </div>
</div>
@endsection

@push('scripts')

@endpush