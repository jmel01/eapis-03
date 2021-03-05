@extends('layouts.adminlte.template')
@section('title', 'Application Form')

@push('style')

@endpush
@section('content')
<div class="row">
    <div class="col-4 mt-3">
        <img src="/images/app/NCIP_logo150x150.png" style="width:100px; height:100px; float:right;" />
    </div>
    <div class="col-4 mt-3">
        <p class="text-center">Republic of the Philippines<br>Office of the President<br>
            <strong>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</strong><br>
            6th and 7th Floor, Sunnymede IT Center, 1614 Quezon Ave., Diliman 1103 Quezon City, Philippines. (02) 572-1200<br><br>
            <strong>EDUCATIONAL ASSISTANCE/SCHOLARSHIP PROGRAM</strong><br>APPLICATION FORM
        </p>
    </div>
    <div class="col-4">

    </div>
</div>

<div class="row">
    <div class="col-12">
        <p class="lead">
            <strong>Portion to be filled by EAP Focal Person</strong> (Affix your initial)
        </p>
    </div>
    <div class="col-9 table-responsive">
        <table class="table table-bordered" style="white-space:nowrap;">
            <tbody>
                <tr>
                    <td style="width:30%;">Application No.:</td>
                    <td style="width:70%;"></td>
                </tr>
                <tr>
                    <td>Date of Filing:</td>
                    <td>{{ $data->created_at }}</td>
                </tr>
                <tr>
                    <td>Action Taken by CSC/PO:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Action Taken by RO:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>CADT of Applicant:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Congresional District:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Additional Remarks:</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-3 text-center">
        <img class="img-bordered-sm cover" style="height: 2in; width: 2in; margin: 0; padding: 0;" alt="user image" src="/storage/users-avatar/{{ App\Models\User::find($data->user_id)->avatar ?? 'avatar.png' }}">
    </div>
</div>

<div class="row">
    <div class="col-12">
        <p class="lead">
            <strong>Portion to be filled by the applicant</strong>
        </p>

        <div class="form-group form-inline">
            <label class="font-weight-normal">Type of Assistance applied for. Please check one (1): </label>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" @if ($data->type=='Regular') checked @endif>
                <label class="form-check-label">Regular</label>
            </div>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" @if ($data->type=='Merit-Based') checked @endif>
                <label class="form-check-label">Merit-Based</label>
            </div>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" @if ($data->type=='PDAF') checked @endif>
                <label class="form-check-label">PDAF</label>
            </div>
        </div>

        <div class="form-group form-inline">
            <label class="font-weight-normal">Assistance applied for. Please check one (1): </label>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" @if ($data->level=='Post-Study') checked @endif>
                <label class="form-check-label">Post-Study</label>
            </div>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" @if ($data->level=='College') checked @endif>
                <label class="form-check-label">College</label>
            </div>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" @if ($data->level=='High School') checked @endif>
                <label class="form-check-label">High School</label>
            </div>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" @if ($data->level=='Elementary') checked @endif>
                <label class="form-check-label">Elementary</label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
        <p class="lead">
            <strong>Basic Information</strong> (Supply needed information for those applicable ones)
        </p>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="2">Last Name: <strong>{{ $data->applicant->lastName }}</strong></td>
                    <td colspan="2">First Name: <strong>{{ $data->applicant->firstName }}</strong></td>
                    <td colspan="2">Middle Name: <strong>{{ $data->applicant->middleName }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Date of Birth: <strong>{{ $data->applicant->birthdate }}</strong></td>
                    <td colspan="2">Place of Birth: <strong>{{ $data->applicant->placeOfBirth }}</strong></td>
                    <td>Gender: <strong>{{ $data->applicant->gender }}</strong></td>
                    <td>Civil Status: <strong>{{ $data->applicant->civilStatus }}</strong></td>

                </tr>
                <tr>
                    <td colspan="2">Ethnolinguistic Group: <strong>{{ App\Models\Ethnogroup::getEthno($data->applicant->ethnoGroup) }}</strong></td>
                    <td colspan="2">Contact Number: <strong>{{ $data->applicant->contactNumber }}</strong></td>
                    <td colspan="2">E-mail Address: <strong>{{ $data->applicant->email }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
        <p class="lead">
            <strong>Address/Origin</strong>
        </p>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="2">House No. and Street/Sitio: <strong>{{ $data->applicant->address }}</strong></td>
                    <td>Barangay: <strong>{{ App\Models\Psgc::getBarangay($data->applicant->psgCode) }}</strong></td>
                </tr>
                <tr>
                    <td>Municipality: <strong>{{ App\Models\Psgc::getCity($data->applicant->psgCode) }}</strong></td>
                    <td>Province: <strong>{{ App\Models\Psgc::getProvince($data->applicant->psgCode) }}</strong></td>
                    <td>Region: <strong>{{ App\Models\Psgc::getRegion($data->applicant->psgCode) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
        <p class="lead">
            <strong>Educational Attainment</strong>
        </p>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="text-center">Level</td>
                    <td class="text-center">Name of School and Address</td>
                    <td class="text-center">School Type<br>(Private or Public)</td>
                    <td class="text-center">Year<br>Graduated</td>
                    <td class="text-center">Average<br>Grade</td>
                    <td class="text-center">Rank</td>
                </tr>
                @if(!empty($data->education))
                @foreach($data->education as $education)
                @if($education->level == "Elementary")
                <tr>
                    <td class="text-center">Elementary</td>
                    <td><strong>{{ $education->school_name }}</strong><br>{{ $education->address }}</td>
                    <td class="text-center"><strong>{{ $education->school_type }}</strong></td>
                    <td class="text-center"><strong>{{ $education->year_graduated }}</strong></td>
                    <td class="text-center"><strong>{{ $education->average_grade }}</strong></td>
                    <td class="text-center"><strong>{{ $education->rank }}</strong></td>
                </tr>
                @endif
                @endforeach
                @endif

                @if(!empty($data->education))
                @foreach($data->education as $education)
                @if($education->level == "High School")
                <tr>
                    <td class="text-center">High School</td>
                    <td><strong>{{ $education->school_name }}</strong><br>{{ $education->address }}</td>
                    <td class="text-center"><strong>{{ $education->school_type }}</strong></td>
                    <td class="text-center"><strong>{{ $education->year_graduated }}</strong></td>
                    <td class="text-center"><strong>{{ $education->average_grade }}</strong></td>
                    <td class="text-center"><strong>{{ $education->rank }}</strong></td>
                </tr>
                @endif
                @endforeach
                @endif

                @if(!empty($data->education))
                @foreach($data->education as $education)
                @if($education->level == "Vocational")
                <tr>
                    <td class="text-center">Vocational</td>
                    <td><strong>{{ $education->school_name }}</strong><br>{{ $education->address }}</td>
                    <td class="text-center"><strong>{{ $education->school_type }}</strong></td>
                    <td class="text-center"><strong>{{ $education->year_graduated }}</strong></td>
                    <td class="text-center"><strong>{{ $education->average_grade }}</strong></td>
                    <td class="text-center"><strong>{{ $education->rank }}</strong></td>
                </tr>
                @endif
                @endforeach
                @endif

                @if(!empty($data->education))
                @foreach($data->education as $education)
                @if($education->level == "College")
                <tr>
                    <td class="text-center">College/<br>Undergraduate</td>
                    <td><strong>{{ $education->school_name }}</strong><br>{{ $education->address }}</td>
                    <td class="text-center"><strong>{{ $education->school_type }}</strong></td>
                    <td class="text-center"><strong>{{ $education->year_graduated }}</strong></td>
                    <td class="text-center"><strong>{{ $education->average_grade }}</strong></td>
                    <td class="text-center"><strong>{{ $education->rank }}</strong></td>
                </tr>
                @endif
                @endforeach
                @endif

                @if(!empty($data->education))
                @foreach($data->education as $education)
                @if($education->level == "Post Graduate")
                <tr>
                    <td class="text-center">Post Graduate</td>
                    <td><strong>{{ $education->school_name }}</strong><br>{{ $education->address }}</td>
                    <td class="text-center"><strong>{{ $education->school_type }}</strong></td>
                    <td class="text-center"><strong>{{ $education->year_graduated }}</strong></td>
                    <td class="text-center"><strong>{{ $education->average_grade }}</strong></td>
                    <td class="text-center"><strong>{{ $education->rank }}</strong></td>
                </tr>
                @endif
                @endforeach
                @endif

                @if(!empty($data->education))
                @foreach($data->education as $education)
                @if($education->level == "Masteral")
                <tr>
                    <td class="text-center">Masteral</td>
                    <td><strong>{{ $education->school_name }}</strong><br>{{ $education->address }}</td>
                    <td class="text-center"><strong>{{ $education->school_type }}</strong></td>
                    <td class="text-center"><strong>{{ $education->year_graduated }}</strong></td>
                    <td class="text-center"><strong>{{ $education->average_grade }}</strong></td>
                    <td class="text-center"><strong>{{ $education->rank }}</strong></td>
                </tr>
                @endif
                @endforeach
                @endif

                @if(!empty($data->education))
                @foreach($data->education as $education)
                @if($education->level == "Doctorate")
                <tr>
                    <td class="text-center">Doctorate</td>
                    <td><strong>{{ $education->school_name }}</strong><br>{{ $education->address }}</td>
                    <td class="text-center"><strong>{{ $education->school_type }}</strong></td>
                    <td class="text-center"><strong>{{ $education->year_graduated }}</strong></td>
                    <td class="text-center"><strong>{{ $education->average_grade }}</strong></td>
                    <td class="text-center"><strong>{{ $education->rank }}</strong></td>
                </tr>
                @endif
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<div style="break-after:page"></div>

<div class="row">
    <div class="col-12 table-responsive">
        <p class="lead">
            <strong>Family Background</strong>
        </p>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        <div class="form-group form-inline">
                            <label>Father</label>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" @if ($data->applicant->fatherLiving=='Living') checked @endif>
                                <label class="form-check-label">Living</label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" @if ($data->applicant->fatherLiving=='Deceased') checked @endif>
                                <label class="form-check-label">Deceased</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group form-inline">
                            <label>Mother</label>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" @if ($data->applicant->motherLiving=='Living') checked @endif>
                                <label class="form-check-label">Living</label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="checkbox" @if ($data->applicant->motherLiving=='Deceased') checked @endif>
                                <label class="form-check-label">Deceased</label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td class="font-weight-bold">{{ $data->applicant->fatherName }}</td>
                    <td class="font-weight-bold">{{ $data->applicant->motherName }}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td class="font-weight-bold">{{ $data->applicant->fatherAddress }}</td>
                    <td class="font-weight-bold">{{ $data->applicant->motherAddress }}</td>
                </tr>
                <tr>
                    <td>Occupation:</td>
                    <td class="font-weight-bold">{{ $data->applicant->fatherOccupation }}</td>
                    <td class="font-weight-bold">{{ $data->applicant->motherOccupation }}</td>
                </tr>
                <tr>
                    <td>Office Address:</td>
                    <td class="font-weight-bold">{{ $data->applicant->fatherOffice }}</td>
                    <td class="font-weight-bold">{{ $data->applicant->motherOffice }}</td>
                </tr>
                <tr>
                    <td>Educational Attainment:</td>
                    <td class="font-weight-bold">{{ $data->applicant->fatherEducation }}</td>
                    <td class="font-weight-bold">{{ $data->applicant->motherEducation }}</td>
                </tr>
                <tr>
                    <td>Ethnolinguistic Group:</td>
                    <td class="font-weight-bold">{{ $data->applicant->fatherEthnoGroup }}</td>
                    <td class="font-weight-bold">{{ $data->applicant->motherEthnoGroup }}</td>
                </tr>
                <tr>
                    <td>Parent's Annual Income:<br>(Year of ITR attached)</td>
                    <td class="font-weight-bold">{{ $data->applicant->fatherIncome }}</td>
                    <td class="font-weight-bold">{{ $data->applicant->motherIncome }}</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
        <p class="lead">
            <strong>Brother/Sister in the Family</strong> (from oldest to youngest)
        </p>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="text-center">Name</td>
                    <td class="text-center">Age</td>
                    <td class="text-center">Civil Status</td>
                    <td class="text-center">Scholarship (if any)</td>
                    <td class="text-center">Course and/or Year Level</td>
                    <td class="text-center">*Present Status</td>
                </tr>
                @foreach($data->sibling as $sibling)
                <tr>
                    <td class="text-center font-weight-bold">{{ $sibling->name }}</td>
                    <td class="text-center font-weight-bold">{{ $sibling->birthdate }}</td>
                    <td class="text-center font-weight-bold">{{ $sibling->civilStatus }}</td>
                    <td class="text-center font-weight-bold">{{ $sibling->scholarship }}</td>
                    <td class="text-center font-weight-bold">{{ $sibling->course_year_level }}</td>
                    <td class="text-center font-weight-bold">{{ $sibling->present_status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>*Present status may classify into the following: Stopped; Undergraduate; Graduated;</p>
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
        <p class="lead">
            <strong>Indicate intended school and course preference</strong>
        </p>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="text-center">School</td>
                    <td class="text-center">Degree Program/Course</td>
                    <td class="text-center">School Type</td>
                    <td class="text-center">No. of Years</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>{{ $data->school }}<strong></td>
                    <td class="text-center"><strong>{{ $data->course }}<strong></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
        <p class="lead">
            <strong>In brief stattement answer the following:</strong>
        </p>
        <p>What possible contribution/s that you may extend to your community or fellow ICCs/IPs while studying</p>
    </div>
</div>

@endsection

@push('scripts')

@endpush