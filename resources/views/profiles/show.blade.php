@extends('layouts.adminlte.template')

@section('title', 'User Profile')

@push('style')

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">User's Profile</h3>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <button data-id="{{ Auth::id() }}" data-url="{{ route('profiles.edit',Auth::id()) }}" class="btn btn-primary btn-sm mr-1 float-right btn-edit-profile">UPDATE PROFILE</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle cover" alt="User profile picture" src="/storage/users-avatar/{{ Auth::user()->avatar ?? 'avatar.png' }}">
                        </div>

                        <h3 class="profile-username text-center">{{ $userProfile->firstName ?? '' }} {{ $userProfile->middleName ?? '' }} {{ $userProfile->lastName ?? '' }}</h3>

                        <p class="text-muted text-center">
                            username: {{ Auth::user()->name ?? '' }}<br>
                            email: {{ Auth::user()->email ?? '' }}
                        </p>
                        <div class="row">
                            <div class="col-6 text-left">
                                <button class="btn btn-success btn-sm mr-1 mb-1 btn-change-profile">change profile picture</button>
                            </div>
                            <div class="col-6 text-right">
                            <button data-url="{{ route('users.edit',Auth::id()) }}" class="btn btn-primary btn-sm mr-1 mb-1 btn-edit-user">Update Login Credential</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-9">
                <nav>
                    <div class="nav nav-tabs" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#profiletab1" role="tab">
                            Basic Information
                        </a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#profiletab2" role="tab">
                            Educational Attainment
                        </a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#profiletab3" role="tab">
                            Family Background
                        </a>
                    </div>
                </nav>

                <div class="tab-content p-3" id="nav-tabContent">
                    <!-- Basic Information -->
                    <div class="tab-pane fade show active" id="profiletab1" role="tabpanel">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" value="{{ $userProfile->lastName ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" value="{{ $userProfile->firstName ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" value="{{ $userProfile->middleName ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="text" value="{{ $userProfile->birthdate ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Place of Birth</label>
                                    <input type="text" value="{{ $userProfile->placeOfBirth ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <input type="text" value="{{ $userProfile->gender ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>Civil Status</label>
                                <input type="text" value="{{ $userProfile->civilStatus ?? '' }}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ethnolinguistic Group</label>
                                    <input type="text" value="{{ $ethnoGroup->ipgroup ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" value="{{ $userProfile->contactNumber ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>E-mail Address</label>
                                    <input type="text" value="{{ $userProfile->email ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>House No. and Street/Sitio</label>
                                    <input type="text" value="{{ $userProfile->address ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Barangay</label>
                                    <input type="text" value="{{ $barangay->name ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City/Municipality/Sub-Municipality</label>
                                    <input type="text" value="{{ $city->name ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Province/District</label>
                                    <input type="text" value="{{ $province->name ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Region</label>
                                    <input type="text" value="{{ $region->name ?? '' }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Educational Attainment -->
                    <div class="tab-pane fade" id="profiletab2" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-hover table-responsive-md">
                                    <tr>
                                        <th>Name of Schoolss</th>
                                        <th>Address</th>
                                        <th>Level</th>
                                        <th>School Type</th>
                                        <th>Year Graduated</th>
                                        <th>Average Grade</th>
                                        <th>Rank</th>
                                    </tr>
                                    @if (isset($userProfile->user->educations))
                                    @foreach($userProfile->user->educations as $education)
                                    <tr>
                                        <td>{{ $education->school_name }}</td>
                                        <td>{{ $education->address }}</td>
                                        <td>{{ $education->level }}</td>
                                        <td>{{ $education->school_type }}</td>
                                        <td>{{ $education->year_graduated }}</td>
                                        <td>{{ $education->average_grade }}</td>
                                        <td>{{ $education->rank }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </table>

                            </div>

                        </div>
                    </div>


                    <!-- Family Background -->
                    <div class="tab-pane fade" id="profiletab3" role="tabpanel">

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-responsive-md">
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="form-group form-inline">
                                                <label class="mr-2">FATHER:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Living" @if("Living"==($userProfile->fatherLiving ?? '')) checked @endif>
                                                    <label class="form-check-label mr-1">Living</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Deceased" @if("Deceased"==($userProfile->fatherLiving ?? '')) checked @endif >
                                                    <label class="form-check-label mr-1">Deceased</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group form-inline">
                                                <label class="mr-2">MOTHER:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Living" @if("Living"==($userProfile->motherLiving ?? '')) checked @endif>
                                                    <label class="form-check-label mr-1">Living</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Deceased" @if("Deceased"==($userProfile->motherLiving ?? '')) checked @endif>
                                                    <label class="form-check-label mr-1">Deceased</label>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Name</td>
                                        <td><input type="text" value="{{ $userProfile->fatherName ?? '' }}" class="form-control" readonly> </td>
                                        <td><input type="text" value="{{ $userProfile->motherName ?? '' }}" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Address</td>
                                        <td><input type="text" value="{{ $userProfile->fatherAddress ?? '' }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $userProfile->motherAddress ?? '' }}" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Occupation</td>
                                        <td><input type="text" value="{{ $userProfile->fatherOccupation ?? '' }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $userProfile->motherOccupation ?? '' }}" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Office Address</td>
                                        <td><input type="text" value="{{ $userProfile->fatherOffice ?? '' }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $userProfile->motherOffice ?? '' }}" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Educational Attainment</td>
                                        <td><input type="text" value="{{ $userProfile->fatherEducation ?? '' }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $userProfile->motherEducation ?? '' }}" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Ethnolinguistic Group</td>
                                        <td><input type="text" value="{{ $userProfile->fatherEthnoGroup ?? '' }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $userProfile->motherEthnoGroup ?? '' }}" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Parent Annual Income</td>
                                        <td><input type="text" value="{{ $userProfile->fatherIncome ?? '' }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $userProfile->motherIncome ?? '' }}" class="form-control" readonly></td>
                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label>Brother/Sister in the family (from oldest to youngest)</label>
                                <table class="table table-sm table-hover">
                                    <tr>
                                        <th>Name</th>
                                        <th>Birthdate</th>
                                        <th>Civil Status</th>
                                        <th>Scholarship (if any)</th>
                                        <th>Course and/or Year Level</th>
                                        <th>Present Status</th>
                                    </tr>
                                    @if (isset($userProfile->user->siblings))
                                    @foreach($userProfile->user->siblings as $siblings)
                                    <tr>
                                        <td>{{ $siblings->name }}</td>
                                        <td>{{ $siblings->birthdate }}</td>
                                        <td>{{ $siblings->civilStatus }}</td>
                                        <td>{{ $siblings->scholarship }}</td>
                                        <td>{{ $siblings->course_year_level }}</td>
                                        <td>{{ $siblings->present_status }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer">

    </div>
</div>
@include('profiles.modalProfile')
@include('profiles.modalProfilePicture')
@include('users.modalAuthUser')
@endsection

@push('scripts')
@include('psgc.scriptPsgc')
@include('ethnogroups.scriptEthno')

<script>
    $(document).ready(function() {
        $('.btn-edit-profile').click(function() {
            var id = $(this).attr('data-id');
            var url_id = $(this).attr('data-url');
            $('[name="id"]').val(id)

            $.get(url_id, function(data) {
                console.log(data)
                $('[name="lastName"]').val(data.lastName)
                $('[name="firstName"]').val(data.firstName)
                $('[name="middleName"]').val(data.middleName)
                $('[name="birthdate"]').val(data.birthdate)
                $('[name="placeOfBirth"]').val(data.placeOfBirth)
                $('[name="gender"]').val(data.gender)
                $('[name="civilStatus"]').val(data.civilStatus)
                $('[name="ethnoGroup"]').val(data.ethnoGroup)
                $('[name="contactNumber"]').val(data.contactNumber)
                $('[name="email"]').val(data.email)
                $('[name="address"]').val(data.address)
                $('[name="fatherName"]').val(data.fatherName)
                $('[name="fatherAddress"]').val(data.fatherAddress)
                $('[name="fatherOccupation"]').val(data.fatherOccupation)
                $('[name="fatherOffice"]').val(data.fatherOffice)
                $('[name="fatherEducation"]').val(data.fatherEducation)
                $('[name="fatherEthnoGroup"]').val(data.fatherEthnoGroup)
                $('[name="fatherIncome"]').val(data.fatherIncome)
                $('[name="motherName"]').val(data.motherName)
                $('[name="motherAddress"]').val(data.motherAddress)
                $('[name="motherOccupation"]').val(data.motherOccupation)
                $('[name="motherOffice"]').val(data.motherOffice)
                $('[name="motherEducation"]').val(data.motherEducation)
                $('[name="motherEthnoGroup"]').val(data.motherEthnoGroup)
                $('[name="motherIncome"]').val(data.motherIncome)

                $('#modalProfile').modal('show')
                $('#region').trigger("change")
            })
        })

        $('.btn-edit-user').click(function() {
            var url_id = $(this).attr('data-url');
            $.get(url_id, function(data) {
                console.log(data)
                $('[name="name"]').val(data.user.name)
                $('[name="email"]').val(data.user.email)

                $('#modalAuthUser').modal('show')
            })
        });

        $('.btn-change-profile').click(function() {
            $('#modalProfilePicture').modal('show');
            return false
        })
    });
</script>

@if (count($errors->profile) > 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#modalProfile').modal('show');
    });
</script>
@endif

@include('profiles.scriptAddSchool')
@include('profiles.scriptAddSibling')
@endpush