@extends('layouts.adminlte.template')
@section('title', 'Recycle Bin')

@push('style')

@endpush
@section('content')
<div class="card">
    <div class="card-header">
        List of Deleted Records
    </div>
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" role="tablist">
                <a class="nav-item nav-link {{old('tab') == 'tab1' || old('tab') == '' ? ' active' : null}}" data-toggle="tab" href="#tab1" role="tab">
                    User
                </a>
                <a class="nav-item nav-link {{old('tab') == 'tab2' ? ' active' : null}}" data-toggle="tab" href="#tab2" role="tab">
                    Grant
                </a>
                <a class="nav-item nav-link {{old('tab') == 'tab3' ? ' active' : null}}" data-toggle="tab" href="#tab3" role="tab">
                    Application
                </a>
            </div>
        </nav>

        <div class="tab-content p-3" id="nav-tabContent">
            <!-- User -->
            <div class="tab-pane fade {{old('tab') == 'tab1' || old('tab') == '' ? ' show active' : null}}" id="tab1" role="tabpanel">
                <table id="userList" class="table table-sm table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Username</th>
                            <th>Profile Name</th>
                            <th>Email</th>
                            <th>Region</th>
                            <th>Province</th>
                            <th>Date Deleted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $key => $user)
                        <tr>
                            <td>
                                <div class="user-block">
                                    <img src="/storage/users-avatar/{{$user->avatar}}" class="img-circle img-bordered-sm cover" alt="User Image">
                                </div>
                            </td>
                            <td> {{ $user->name }}</td>
                            <td>
                                @if(!empty($user->profile))
                                {{ ucwords($user->profile->lastName ?? '') }}, {{ ucwords($user->profile->firstName ?? '') }} {{ ucwords(substr($user->profile->middleName ?? '',1,'1')) }}.
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ App\Models\Psgc::getRegion($user->region) }}</td>
                            <td>
                                @if(!empty($user->profile))
                                {{ App\Models\Psgc::getProvince($user->profile->psgCode) }}
                                @endif
                            </td>

                            <td>{{ $user->deleted_at }}</td>
                            <td>
                                @can('user-delete')
                                <a href="{{ route('restoreUser',$user->id) }}" onclick="return confirm('Are you sure you want to restore this record?')" class="btn btn-success btn-sm mr-1 mb-1 btn-edit-user">Restore</a>
                                <a href="{{ route('destroyUser', $user->id) }}" onclick="return confirm('Are you sure you want to delete this record?')" class="btn btn-danger btn-sm mr-1 mb-1 btn-delete-user">Delete</a>
                                @endcan

                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>

            </div>

            <!-- Grant -->
            <div class="tab-pane fade {{old('tab') == 'tab2' ? ' show active' : null}}" id="tab2" role="tabpanel">
                <table id="grantList" class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Region</th>
                            <th>Academic Year</th>
                            <th>Date Deleted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($grants as $key => $grant)
                        <tr>
                            <td>
                                {{App\Models\Psgc::getRegion($grant->region)}}

                            </td>
                            <td>{{ $grant->acadYr }}-{{ $grant->acadYr + 1 }}</td>
                            <td>
                                {{ $grant->deleted_at }}
                            </td>
                            <td>
                                @can('grant-delete')
                                <a href="{{ route('restoreGrant',$grant->id) }}" onclick="return confirm('Are you sure you want to restore this record?')" class="btn btn-success btn-sm mr-1 mb-1 btn-edit-user">Restore</a>
                                <a href="{{ route('destroyGrant', $grant->id) }}" onclick="return confirm('Are you sure you want to delete this record?')" class="btn btn-danger btn-sm mr-1 mb-1 btn-delete-user">Delete</a>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>


            <!-- Application -->
            <div class="tab-pane fade {{old('tab') == 'tab3' ? ' show active' : null}}" id="tab3" role="tabpanel">
                <table id="applicationList" class="table table-sm table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Batch</th>
                            <th>Type</th>
                            <th>Level</th>
                            <th>Region</th>
                            <th>Province</th>
                            <th>Date Deleted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $key => $application)
                        <tr>
                            <td>{{ ucwords($application->applicant->lastName) }}, {{ ucwords($application->applicant->firstName) }}
                                {{ ucwords(substr($application->applicant->middleName,1,'1')) }}.
                            </td>
                            <td>
                                @if(isset($application->grant->acadYr))
                                {{ $application->grant->acadYr }} - {{ $application->grant->acadYr + 1}}
                                @else
                                <p class="text-danger">Grant Deleted</p>
                                @endif
                            </td>
                            <td>{{ $application->type }}</td>
                            <td>{{ $application->level }}</td>
                            <td>{{ App\Models\Psgc::getRegion($application->applicant->psgcBrgy->code) }}</td>
                            <td>{{ App\Models\Psgc::getProvince($application->applicant->psgcBrgy->code) }}</td>
                            <td>{{ $application->deleted_at }}</td>
                            <td>
                                @can('application-delete')
                                <a href="{{ route('restoreApplication',$application->id) }}" onclick="return confirm('Are you sure you want to restore this record?')" class="btn btn-success btn-sm mr-1 mb-1 btn-edit-user">Restore</a>
                                <a href="{{ route('destroyApplication', $application->id) }}" onclick="return confirm('Are you sure you want to delete this record?')" class="btn btn-danger btn-sm mr-1 mb-1 btn-delete-user">Delete</a>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>
    <div class="card-footer">

    </div>
</div>

@include('layouts.adminlte.modalDelete')

@endsection

@push('scripts')

@endpush