<div class="modal fade" id="modalProfile">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Profile Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ route('profiles.store') }}" id="formProfile">
                @csrf
                <div class="modal-body">
                    <nav>
                        <div class="nav nav-tabs" role="tablist">
                            <a class="nav-item nav-link active" data-toggle="tab" href="#tab1" role="tab">
                                Basic Information
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#tab2" role="tab">
                                Educational Attainment
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#tab3" role="tab">
                                Family Background
                            </a>
                        </div>
                    </nav>

                    <div class="tab-content p-3" id="nav-tabContent">
                        <!-- Basic Information -->
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input name="lastName" type="text" value="{{old('lastName')}}" class="form-control {!! $errors->profile->first('lastName', 'is-invalid') !!}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input name="firstName" type="text" value="{{old('firstName')}}" class="form-control {!! $errors->profile->first('firstName', 'is-invalid') !!}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input name="middleName" type="text" value="{{old('middleName')}}" class="form-control {!! $errors->profile->first('middleName', 'is-invalid') !!}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input name="birthdate" type="date" value="{{old('birthdate')}}" class="form-control {!! $errors->profile->first('birthdate', 'is-invalid') !!}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Place of Birth</label>
                                        <input name="placeOfBirth" type="text" value="{{old('placeOfBirth')}}" class="form-control {!! $errors->profile->first('placeOfBirth', 'is-invalid') !!}" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control {!! $errors->profile->first('gender', 'is-invalid') !!}" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Female" {{ old('gender')=='Female' ? 'selected' : ''}}>Female</option>
                                            <option value="Male" {{ old('gender')=='Male' ? 'selected' : ''}}>Male</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>Civil Status</label>
                                    <select name="civilStatus" class="form-control {!! $errors->profile->first('civilStatus', 'is-invalid') !!}" required>
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="Single" {{ old('civilStatus')=='Single' ? 'selected' : ''}}>Single</option>
                                        <option value="Married" {{ old('civilStatus')=='Married' ? 'selected' : ''}}>Married</option>
                                        <option value="Divorced" {{ old('civilStatus')=='Divorced' ? 'selected' : ''}}>Divorced</option>
                                        <option value="Separated" {{ old('civilStatus')=='Separated' ? 'selected' : ''}}>Separated</option>
                                        <option value="Widowed" {{ old('civilStatus')=='Widowed' ? 'selected' : ''}}>Widowed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Region</label>
                                        <select name="region" id="region" class="form-control {!! $errors->profile->first('region', 'is-invalid') !!}" required>
                                            <option value="" selected>Select Region</option>
                                            @foreach ($regions as $allRegion)
                                            <option {{isset($region->code) ? $region->code == $allRegion->code ? 'selected' : '' : ''}} value="{{ $allRegion->code }}" {{ old('region')==$allRegion->code ? 'selected' : ''}}>
                                                {{ $allRegion->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Province/District</label>
                                        <input type="hidden" id="provinceCode" value="{{$province->code ?? ''}}">
                                        <select name="province" id="province" class="form-control {!! $errors->profile->first('province', 'is-invalid') !!}" required></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="hidden" id="cityCode" value="{{$city->code ?? ''}}">
                                        <label>City/Municipality/Sub-Municipality</label>
                                        <select name="city" id="city" class="form-control {!! $errors->profile->first('city', 'is-invalid') !!}" required></select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Barangay</label>
                                        <input type="hidden" id="barangayCode" value="{{$barangay->code ?? ''}}">
                                        <select name="barangay" id="barangay" class="form-control {!! $errors->profile->first('barangay', 'is-invalid') !!}" required></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>House No. and Street/Sitio</label>
                                        <input name="address" type="text" value="{{old('address')}}" class="form-control {!! $errors->profile->first('address', 'is-invalid') !!}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ethnolinguistic Group</label>
                                        <input type="hidden" id="ethnoGroupID" value="{{$userProfile->ethnoGroup ?? ''}}">
                                        <select name="ethnoGroup" id="ethnoGroup" class="form-control {!! $errors->profile->first('ethnoGroup', 'is-invalid') !!}" required></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input name="contactNumber" type="text" value="{{old('contactNumber')}}" class="form-control {!! $errors->profile->first('contactNumber', 'is-invalid') !!}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>E-mail Address</label>
                                        <input name="email" type="email" value="{{old('email')}}" class="form-control {!! $errors->profile->first('email', 'is-invalid') !!}" required>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Educational Attainment -->
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-sm table-hover table-responsive-md" id="dynamicSchool">
                                        <tr>
                                            <th>Name of School</th>
                                            <th>Address</th>
                                            <th>Level</th>
                                            <th>School Type</th>
                                            <th>Year Graduated</th>
                                            <th>Average Grade</th>
                                            <th>Rank</th>
                                            <th>Action</th>
                                        </tr>
                                        @if(isset($userProfile->user->educations))
                                        @foreach($userProfile->user->educations as $education)
                                        <tr>
                                            <td><input name="schName[]" type="text" class="form-control" value="{{$education->school_name}}" required></td>
                                            <td><input name="schAddress[]" type="text" class="form-control" value="{{$education->address}}" required></td>
                                            <td>
                                                <select name="schLevel[]" class="form-control" required>
                                                    <option value="" disabled selected>Please select one</option>
                                                    <option {{$education->level == 'Elementary' ? 'selected' : ''}} value="Elementary">Elementary</option>
                                                    <option {{$education->level == 'High School' ? 'selected' : ''}} value="High School">High School</option>
                                                    <option {{$education->level == 'Vocational' ? 'selected' : ''}} value="Vocational">Vocational</option>
                                                    <option {{$education->level == 'College/Undergraduate' ? 'selected' : ''}} value="College/Undergraduate">College/Undergraduate</option>
                                                    <option {{$education->level == 'Post Graduate' ? 'selected' : ''}} value="Post Graduate">Post Graduate</option>
                                                    <option {{$education->level == 'Masteral' ? 'selected' : ''}} value="Masteral">Masteral</option>
                                                    <option {{$education->level == 'Doctorate' ? 'selected' : ''}} value="Doctorate">Doctorate</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="schType[]" class="form-control" required>
                                                    <option value="" disabled selected>Please select one</option>
                                                    <option {{$education->school_type == 'Private' ? 'selected' : ''}} value="Private">Private</option>
                                                    <option {{$education->school_type == 'Public' ? 'selected' : ''}} value="Public">Public</option>
                                                </select>
                                            </td>
                                            <td><input name="schYear[]" type="number" step="1" min="1980" max="2030" class="form-control" value="{{$education->year_graduated}}" required></td>
                                            <td><input name="schAve[]" type="number" step=".01" min="0" max="100" class="form-control" value="{{$education->average_grade}}"></td>
                                            <td> <input name="schRank[]" type="text" class="form-control" value="{{$education->rank}}"></td>
                                            <td> <button type="button" class="btn btn-danger btn-sm remove-tr-school">Remove</button></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </table>
                                    <button type="button" id="addSchool" class="btn btn-success btn-sm">Add More</button>
                                </div>
                            </div>
                        </div>


                        <!-- Family Background -->
                        <div class="tab-pane fade" id="tab3" role="tabpanel">

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-sm table-hover table-responsive-md">
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div class="form-group form-inline">
                                                    <label class="mr-2">FATHER:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="fatherLiving" value="Living" @if("Living"==($userProfile->fatherLiving ?? '')) checked @endif required>
                                                        <label class="form-check-label mr-1">Living</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="fatherLiving" value="Deceased" @if("Deceased"==($userProfile->fatherLiving ?? '')) checked @endif required>
                                                        <label class="form-check-label mr-1">Deceased</label>
                                                    </div>
                                                    {!! $errors->profile->first('fatherLiving', '<label class="mr-1 text-danger">Required</label>') !!}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group form-inline">
                                                    <label class="mr-2">MOTHER:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="motherLiving" value="Living" @if("Living"==($userProfile->motherLiving ?? '')) checked @endif required>
                                                        <label class="form-check-label mr-1">Living</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="motherLiving" value="Deceased" @if("Deceased"==($userProfile->motherLiving ?? '')) checked @endif required>
                                                        <label class="form-check-label mr-1">Deceased</label>
                                                    </div>
                                                    {!! $errors->profile->first('motherLiving', '<label class="mr-1 text-danger">Required</label>') !!}
                                                </div>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Name</td>
                                            <td><input name="fatherName" type="text" value="{{old('fatherName')}}" class="form-control  {!! $errors->profile->first('fatherName', 'is-invalid') !!}" required></td>
                                            <td><input name="motherName" type="text" value="{{old('motherName')}}" class="form-control {!! $errors->profile->first('motherName', 'is-invalid') !!}" required></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Address</td>
                                            <td><input name="fatherAddress" type="text" value="{{old('fatherAddress')}}" class="form-control {!! $errors->profile->first('fatherAddress', 'is-invalid') !!}" required></td>
                                            <td><input name="motherAddress" type="text" value="{{old('motherAddress')}}" class="form-control {!! $errors->profile->first('motherAddress', 'is-invalid') !!}" required></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Occupation</td>
                                            <td><input name="fatherOccupation" type="text" value="{{old('fatherOccupation')}}" class="form-control {!! $errors->profile->first('fatherOccupation', 'is-invalid') !!}" required></td>
                                            <td><input name="motherOccupation" type="text" value="{{old('motherOccupation')}}" class="form-control {!! $errors->profile->first('motherOccupation', 'is-invalid') !!}" required></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Office Address</td>
                                            <td><input name="fatherOffice" type="text" value="{{old('fatherOffice')}}" class="form-control {!! $errors->profile->first('fatherOffice', 'is-invalid') !!}" required></td>
                                            <td><input name="motherOffice" type="text" value="{{old('motherOffice')}}" class="form-control {!! $errors->profile->first('motherOffice', 'is-invalid') !!}" required></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Educational Attainment</td>
                                            <td><input name="fatherEducation" type="text" value="{{old('fatherEducation')}}" class="form-control {!! $errors->profile->first('fatherEducation', 'is-invalid') !!}" required></td>
                                            <td><input name="motherEducation" type="text" value="{{old('motherEducation')}}" class="form-control {!! $errors->profile->first('motherEducation', 'is-invalid') !!}" required></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Ethnolinguistic Group</td>
                                            <td><input name="fatherEthnoGroup" type="text" value="{{old('fatherEthnoGroup')}}" class="form-control {!! $errors->profile->first('fatherEthnoGroup', 'is-invalid') !!}" required></td>
                                            <td><input name="motherEthnoGroup" type="text" value="{{old('motherEthnoGroup')}}" class="form-control {!! $errors->profile->first('motherEthnoGroup', 'is-invalid') !!}" required></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Parent Annual Income</td>
                                            <td><input name="fatherIncome" type="text" value="{{old('fatherIncome')}}" class="form-control {!! $errors->profile->first('fatherIncome', 'is-invalid') !!}" required></td>
                                            <td><input name="motherIncome" type="text" value="{{old('motherIncome')}}" class="form-control {!! $errors->profile->first('motherIncome', 'is-invalid') !!}" required></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Brother/Sister in the family (from oldest to youngest)</label>
                                    <table class="table table-sm table-hover" id="dynamicSibling">
                                        <tr>
                                            <th>Name</th>
                                            <th>Birthdate</th>
                                            <th>Civil Status</th>
                                            <th>Scholarship (if any)</th>
                                            <th>Course and/or Year Level</th>
                                            <th>Present Status</th>
                                            <th></th>
                                        </tr>
                                        @if (isset($userProfile->user->siblings))
                                        @foreach($userProfile->user->siblings as $siblings)
                                        <tr>
                                            <td><input type="text" name="siblingName[]" class="form-control" value="{{$siblings->name}}" required></td>
                                            <td><input type="date" name="siblingBirthdate[]" class="form-control" value="{{$siblings->birthdate}}" required></td>
                                            <td>
                                                <select name="siblingCivilStatus[]" class="form-control" required>
                                                    <option value="" disabled selected>Select Status</option>
                                                    <option value="Single" {{ old('civilStatus')=='Single' ? 'selected' : ''}} {{$siblings->civilStatus == 'Single' ? 'selected' : ''}}>Single</option>
                                                    <option value="Married" {{ old('civilStatus')=='Married' ? 'selected' : ''}} {{$siblings->civilStatus == 'Married' ? 'selected' : ''}}>Married</option>
                                                    <option value="Divorced" {{ old('civilStatus')=='Divorced' ? 'selected' : ''}} {{$siblings->civilStatus == 'Divorced' ? 'selected' : ''}}>Divorced</option>
                                                    <option value="Separated" {{ old('civilStatus')=='Separated' ? 'selected' : ''}} {{$siblings->civilStatus == 'Separated' ? 'selected' : ''}}>Separated</option>
                                                    <option value="Widowed" {{ old('civilStatus')=='Widowed' ? 'selected' : ''}} {{$siblings->civilStatus == 'Widowed' ? 'selected' : ''}}>Widowed</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="siblingScholarship[]" class="form-control" value="{{$siblings->scholarship}}" required></td>
                                            <td><input type="text" name="siblingCourse[]" class="form-control" value="{{$siblings->course_year_level}}" required></td>
                                            <td>
                                                <select name="siblingStatus[]" class="form-control" required>
                                                    <option value="" disabled selected>Please select one</option>
                                                    <option {{$siblings->present_status == 'Stopped' ? 'selected' : ''}} value="Stopped">Stopped</option>
                                                    <option {{$siblings->present_status == 'Undergraduate' ? 'selected' : ''}} value="Undergraduate">Undergraduate</option>
                                                    <option {{$siblings->present_status == 'Graduated' ? 'selected' : ''}} value="Graduated">Graduated</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-tr">Remove</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </table>
                                    <button type="button" name="add" id="addSibling" class="btn btn-success btn-sm">Add More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" value="{{old('id')}}" type="hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>