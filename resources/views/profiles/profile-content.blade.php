<!-- Basic Information -->
<div class="tab">
    <div class="row">
        <h4>Basic Information</h4>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Last Name</label>
                <input name="lastName" type="text" value="{{old('lastName') ?? ($userProfile->lastName ?? '')}}" class="form-control {!! $errors->profile->first('lastName', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>First Name</label>
                <input name="firstName" type="text" value="{{old('firstName') ?? ($userProfile->firstName ?? '')}}" class="form-control {!! $errors->profile->first('firstName', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Middle Name</label>
                <input name="middleName" type="text" value="{{old('middleName') ?? ($userProfile->middleName ?? '')}}" class="form-control {!! $errors->profile->first('middleName', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Date of Birth</label>
                <input name="birthdate" type="date" value="{{old('birthdate') ?? ($userProfile->birthdate ?? '')}}" class="form-control {!! $errors->profile->first('birthdate', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Place of Birth</label>
                <input name="placeOfBirth" type="text" value="{{old('placeOfBirth') ?? ($userProfile->placeOfBirth ?? '')}}" class="form-control {!! $errors->profile->first('placeOfBirth', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control {!! $errors->profile->first('gender', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Female" {{ old('gender') ?? ($userProfile->gender ?? '') == 'Female' ? 'selected' : ''}}>Female</option>
                    <option value="Male" {{ old('gender') ?? ($userProfile->gender ?? '') =='Male' ? 'selected' : ''}}>Male</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <label>Civil Status</label>
            <select name="civilStatus" class="form-control {!! $errors->profile->first('civilStatus', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
                <option value="" disabled selected>Select Status</option>
                <option value="Single" {{ old('civilStatus') ?? ($userProfile->civilStatus ?? '') =='Single' ? 'selected' : ''}}>Single</option>
                <option value="Married" {{ old('civilStatus') ?? ($userProfile->civilStatus ?? '')=='Married' ? 'selected' : ''}}>Married</option>
                <option value="Divorced" {{ old('civilStatus') ?? ($userProfile->civilStatus ?? '')=='Divorced' ? 'selected' : ''}}>Divorced</option>
                <option value="Separated" {{ old('civilStatus') ?? ($userProfile->civilStatus ?? '')=='Separated' ? 'selected' : ''}}>Separated</option>
                <option value="Widowed" {{ old('civilStatus') ?? ($userProfile->civilStatus ?? '')=='Widowed' ? 'selected' : ''}}>Widowed</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Region</label>
                <input type="hidden" id="regionCode" value="{{$region->code ?? ''}}">
                <select name="region" id="region" class="form-control {!! $errors->profile->first('region', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
                    <option value="">Select Region</option>
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
                <select name="province" id="province" class="form-control {!! $errors->profile->first('province', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required></select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="hidden" id="cityCode" value="{{$city->code ?? ''}}">
                <label>City/Municipality/Sub-Municipality</label>
                <select name="city" id="city" class="form-control {!! $errors->profile->first('city', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required></select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Barangay</label>
                <input type="hidden" id="barangayCode" value="{{$barangay->code ?? ''}}">
                <select name="barangay" id="barangay" class="form-control {!! $errors->profile->first('barangay', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required></select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>House No. and Street/Sitio</label>
                <input name="address" type="text" value="{{old('address') ?? ($userProfile->address ?? '')}}" class="form-control {!! $errors->profile->first('address', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Ethnolinguistic Group</label>
                <input type="hidden" id="ethnoGroupID" value="{{$userProfile->ethnoGroup ?? ''}}">
                <select name="ethnoGroup" id="ethnoGroup" class="form-control {!! $errors->profile->first('ethnoGroup', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required></select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Contact Number</label>
                <input name="contactNumber" type="text" value="{{old('contactNumber') ?? ($userProfile->contactNumber ?? '')}}" class="form-control {!! $errors->profile->first('contactNumber', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>E-mail Address</label>
                <input name="email" type="email" value="{{old('email') ?? ($userProfile->email ?? '')}}" class="form-control {!! $errors->profile->first('email', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>

</div>

<!-- Educational Attainment -->
<div class="tab">
    <div class="row">
        <h4>Educational Attainment</h4>
    </div>
    <div id="dynamicSchool">

        @if(isset($userProfile->user->educations))
        @foreach($userProfile->user->educations as $education)
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>School</label>
                            <input name="schName[]" type="text" class="form-control" value="{{$education->school_name}}" oninput="removeInvalidClass(this)" required>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>Address</label>
                            <input name="schAddress[]" type="text" class="form-control" value="{{$education->address}}" oninput="removeInvalidClass(this)" required>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Level</label>
                            <select name="schLevel[]" class="form-control" oninput="removeInvalidClass(this)" required>
                                <option value="" disabled selected>Please select one</option>
                                <option {{$education->level == 'Elementary' ? 'selected' : ''}} value="Elementary">Elementary</option>
                                <option {{$education->level == 'High School' ? 'selected' : ''}} value="High School">High School</option>
                                <option {{$education->level == 'Vocational' ? 'selected' : ''}} value="Vocational">Vocational</option>
                                <option {{$education->level == 'College' ? 'selected' : ''}} value="College">College</option>
                                <option {{$education->level == 'Masteral' ? 'selected' : ''}} value="Masteral">Masteral</option>
                                <option {{$education->level == 'Doctorate' ? 'selected' : ''}} value="Doctorate">Doctorate</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="schType[]" class="form-control" oninput="removeInvalidClass(this)" required>
                                <option value="" disabled selected>Please select one</option>
                                <option {{$education->school_type == 'Private' ? 'selected' : ''}} value="Private">Private</option>
                                <option {{$education->school_type == 'Public' ? 'selected' : ''}} value="Public">Public</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Year Graduated</label>
                            <input name="schYear[]" type="text" class="form-control" value="{{$education->year_graduated}}" oninput="removeInvalidClass(this)" required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Average</label>
                            <input name="schAve[]" type="text" class="form-control" value="{{$education->average_grade}}" oninput="removeInvalidClass(this)" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Rank</label>
                            <input name="schRank[]" type="text" class="form-control" value="{{$education->rank}}" oninput="removeInvalidClass(this)" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-danger btn-sm float-right remove-school">Remove</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <button type="button" id="addSchool" class="btn btn-success float-right btn-sm">Add More</button>
        </div>
    </div>
</div>


<!-- Family Background -->
<div class="tab">
    <div class="row">
        <h4>Family Background</h4>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-inline">
                <label class="mr-2">FATHER:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fatherLiving" value="Living" oninput="removeRadioInvalidClass(this)" @if("Living"==($userProfile->fatherLiving ?? '')) checked @endif required>
                    <label class="form-check-label mr-1">Living</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fatherLiving" value="Deceased" oninput="removeRadioInvalidClass(this)" @if("Deceased"==($userProfile->fatherLiving ?? '')) checked @endif required>
                    <label class="form-check-label mr-1">Deceased</label>
                </div>
                {!! $errors->profile->first('fatherLiving', '<label class="mr-1 text-danger">Required</label>') !!}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-inline">
                <label class="mr-2">MOTHER:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motherLiving" value="Living" oninput="removeRadioInvalidClass(this)" @if("Living"==($userProfile->motherLiving ?? '')) checked @endif required>
                    <label class="form-check-label mr-1">Living</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motherLiving" value="Deceased" oninput="removeRadioInvalidClass(this)" @if("Deceased"==($userProfile->motherLiving ?? '')) checked @endif required>
                    <label class="form-check-label mr-1">Deceased</label>
                </div>
                {!! $errors->profile->first('motherLiving', '<label class="mr-1 text-danger">Required</label>') !!}
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Father's Name</label>
                <input name="fatherName" type="text" value="{{old('fatherName') ?? ($userProfile->fatherName ?? '')}}" class="form-control  {!! $errors->profile->first('fatherName', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Mother's Name</label>
                <input name="motherName" type="text" value="{{old('motherName') ?? ($userProfile->motherName ?? '')}}" class="form-control {!! $errors->profile->first('motherName', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Father's Address</label>
                <input name="fatherAddress" type="text" value="{{old('fatherAddress') ?? ($userProfile->fatherAddress ?? '')}}" class="form-control {!! $errors->profile->first('fatherAddress', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Mothers's Address</label>
                <input name="motherAddress" type="text" value="{{old('motherAddress') ?? ($userProfile->motherAddress ?? '')}}" class="form-control {!! $errors->profile->first('motherAddress', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Father's Occupation</label>
                <input name="fatherOccupation" type="text" value="{{old('fatherOccupation') ?? ($userProfile->fatherOccupation ?? '')}}" class="form-control {!! $errors->profile->first('fatherOccupation', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Mother's Occupation</label>
                <input name="motherOccupation" type="text" value="{{old('motherOccupation') ?? ($userProfile->motherOccupation ?? '')}}" class="form-control {!! $errors->profile->first('motherOccupation', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Father's Office Address</label>
                <input name="fatherOffice" type="text" value="{{old('fatherOffice') ?? ($userProfile->fatherOffice ?? '')}}" class="form-control {!! $errors->profile->first('fatherOffice', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Mother's Office Address</label>
                <input name="motherOffice" type="text" value="{{old('motherOffice') ?? ($userProfile->motherOffice ?? '')}}" class="form-control {!! $errors->profile->first('motherOffice', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Father's Educational Attainment</label>
                <input name="fatherEducation" type="text" value="{{old('fatherEducation') ?? ($userProfile->fatherEducation ?? '')}}" class="form-control {!! $errors->profile->first('fatherEducation', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Mother's Educational Attainment</label>
                <input name="motherEducation" type="text" value="{{old('motherEducation') ?? ($userProfile->motherEducation ?? '')}}" class="form-control {!! $errors->profile->first('motherEducation', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Father's Ethnolinguistic Group</label>
                <input name="fatherEthnoGroup" type="text" value="{{old('fatherEthnoGroup') ?? ($userProfile->fatherEthnoGroup ?? '')}}" class="form-control {!! $errors->profile->first('fatherEthnoGroup', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Mother's Ethnolinguistic Group</label>
                <input name="motherEthnoGroup" type="text" value="{{old('motherEthnoGroup') ?? ($userProfile->motherEthnoGroup ?? '')}}" class="form-control {!! $errors->profile->first('motherEthnoGroup', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Father's Annual Income</label>
                <input name="fatherIncome" type="text" value="{{old('fatherIncome') ?? ($userProfile->fatherIncome ?? '')}}" class="form-control {!! $errors->profile->first('fatherIncome', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Mother's Annual Income</label>
                <input name="motherIncome" type="text" value="{{old('motherIncome') ?? ($userProfile->motherIncome ?? '')}}" class="form-control {!! $errors->profile->first('motherIncome', 'is-invalid') !!}" oninput="removeInvalidClass(this)" required>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <label>Brother/Sister in the family (from oldest to youngest)</label>
        </div>
    </div>
    <div id="dynamicSibling">
        @if (isset($userProfile->user->siblings))
        @foreach($userProfile->user->siblings as $siblings)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="siblingName[]" class="form-control" value="{{$siblings->name}}" oninput="removeInvalidClass(this)" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Birthdate</label>
                            <input type="date" name="siblingBirthdate[]" class="form-control" value="{{$siblings->birthdate}}" oninput="removeInvalidClass(this)">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Civil Status</label>
                            <select name="siblingCivilStatus[]" class="form-control" oninput="removeInvalidClass(this)" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="Single" {{ old('civilStatus')=='Single' ? 'selected' : ''}} {{$siblings->civilStatus == 'Single' ? 'selected' : ''}}>Single</option>
                                <option value="Married" {{ old('civilStatus')=='Married' ? 'selected' : ''}} {{$siblings->civilStatus == 'Married' ? 'selected' : ''}}>Married</option>
                                <option value="Divorced" {{ old('civilStatus')=='Divorced' ? 'selected' : ''}} {{$siblings->civilStatus == 'Divorced' ? 'selected' : ''}}>Divorced</option>
                                <option value="Separated" {{ old('civilStatus')=='Separated' ? 'selected' : ''}} {{$siblings->civilStatus == 'Separated' ? 'selected' : ''}}>Separated</option>
                                <option value="Widowed" {{ old('civilStatus')=='Widowed' ? 'selected' : ''}} {{$siblings->civilStatus == 'Widowed' ? 'selected' : ''}}>Widowed</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Scholarship (if any)</label>
                            <input type="text" name="siblingScholarship[]" class="form-control" value="{{$siblings->scholarship}}" oninput="removeInvalidClass(this)" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Course/Year Level</label>
                            <input type="text" name="siblingCourse[]" class="form-control" value="{{$siblings->course_year_level}}" oninput="removeInvalidClass(this)" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Present Status</label>
                            <select name="siblingStatus[]" class="form-control" oninput="removeInvalidClass(this)" required>
                                <option value="" disabled selected>Please select one</option>
                                <option {{$siblings->present_status == 'Stopped' ? 'selected' : ''}} value="Stopped">Stopped</option>
                                <option {{$siblings->present_status == 'Undergraduate' ? 'selected' : ''}} value="Undergraduate">Undergraduate</option>
                                <option {{$siblings->present_status == 'Graduated' ? 'selected' : ''}} value="Graduated">Graduated</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-danger btn-sm float-right remove-sibling">Remove</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div>
        <button type="button" name="add" id="addSibling" class="btn btn-success float-right btn-sm">Add More</button>
    </div>


</div>

<div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
</div>

<!-- Script needed on modal profile -->
@include('psgc.scriptPsgc')
@include('ethnogroups.scriptEthno')
@include('profiles.scriptAddSchool')
@include('profiles.scriptAddSibling')

<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form ...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Update";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        if (currentTab >= x.length) {
            //...the form gets submitted:
            document.getElementById("formProfile").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, z, valid = true;
        var radioFather = document.querySelector('input[name="fatherLiving"]:checked');
        var radioMother = document.querySelector('input[name="motherLiving"]:checked');
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        z = x[currentTab].getElementsByTagName("select");

        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value === "" && y[i].hasAttribute('required')) { // (y[i].value == "" && y[i].type != "hidden") check if input field is null and not hidden
                // add an "invalid" class to the field:
                y[i].className += " is-invalid";
                // and set the current valid status to false:
                valid = false;
            }
            if ($(y[i]).is(':radio')) { //check radio selected
                if (!$("input[name='fatherLiving']:checked").val()) {
                    $("input[name='fatherLiving']").addClass("is-invalid");
                    valid = false;
                }
                if (!$("input[name='motherLiving']:checked").val()) {
                    $("input[name='motherLiving']").addClass("is-invalid");
                    valid = false;
                }
            }
        }

        // A loop that checks every select field in the current tab:
        for (i = 0; i < z.length; i++) {
            // If a field is empty...
            if (z[i].value === "" && z[i].hasAttribute('required')) { // (z[i].value === "") check if select field is null
                // add an "invalid" class to the field:
                z[i].className += " is-invalid";
                // and set the current valid status to false:
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class to the current step:
        x[n].className += " active";
    }

    function removeInvalidClass(element) {
        element.className = "form-control";
    };

    function removeRadioInvalidClass() {
        if ($("input[name='fatherLiving']:checked").val()) {
            $("input[name='fatherLiving']").removeClass("is-invalid");
        }
        if ($("input[name='motherLiving']:checked").val()) {
            $("input[name='motherLiving']").removeClass("is-invalid");
        }

    };

    $(function() {
        $('#region').trigger("change")
    })
</script>