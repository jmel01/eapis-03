@extends('layouts.adminlte.template')

@section('title', 'Roles Management')

@push('style')

@endpush

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Update Role</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" method="POST" action="{{ route('roles.update', $role->id) }}">
        @method('PATCH')
        @csrf
        <div class="card-body">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="form-group">
                <label>Role name</label>
                <input name="name" type="text" class="form-control" value="{{ $role->name }}">
            </div>
            <div class="form-group">
                <label>Select Permission</label>
                @foreach($permission as $value)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{$value->id}}" {{ in_array($value->id,$rolePermissions) ? 'checked' : '' }}>
                        {{$value->name}}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')

@endpush