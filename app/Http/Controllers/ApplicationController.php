<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables as GlobalClassDatatables;
use App\Models\Application;
use App\Models\Grant;
use App\Models\Psgc;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function applicationForm($id)
    {
        $data = Application::with('applicant')
            ->with('education')
            ->with('sibling')
            ->where('id', $id)
            ->first();
        return view('applications.applicationForm', compact('data'));
    }

    public function showAllApplication()
    {
        $regions = Psgc::where('code', Auth::user()->region)->get();
        $data = Application::with('applicant.psgcBrgy')
            ->with('grant')
            ->where('status', '')
            ->orWhere('status', 'New')
            ->orWhere('status', 'On Process')
            ->orderBy('id', 'DESC')
            ->get();

        return view('applications.showAllApplication', compact('data', 'regions'));
    }

    public function showAllApproved()
    {
        $data = Application::with('applicant.psgcBrgy')
            ->where('status', 'Approved')
            ->orderBy('id', 'DESC')
            ->get();

        return view('applications.showAllApproved', compact('data'));
    }

    public function showApproved($id)
    {
        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', 'Approved')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();

        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces'));
    }

    public function showDenied($id)
    {
        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', 'Denied')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();

        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces'));
    }

    public function showTerminated($id)
    {
        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', '!=', 'New')
            ->where('status', '!=', 'Denied')
            ->where('status', '!=', 'Approved')
            ->where('status', '!=', 'On Process')
            ->where('status', '!=', 'Graduated')
            ->whereNotNull('status')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces'));
    }

    public function showOnProcess($id)
    {
        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', 'On Process')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces'));
    }

    public function showAllNew($id)
    {
        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', 'New')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces'));
    }

    public function showGraduated($id)
    {
        $data = Application::with('applicant.psgcBrgy')->with('employment')
            ->where('grant_id', $id)
            ->where('status', 'Graduated')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces'));
    }

    public function alumni()
    {
        $graduated = Application::with('applicant.psgcBrgy')
            ->where('status', 'Graduated')

            ->orderBy('id', 'DESC')
            ->get();

        $data =  $graduated->unique('user_id');

        return view('applications.alumni', compact('data'));
    }

    public function approved()
    {
        $this->cscProvProfileSet();
        $countOfTable = Application::where('status', 'Approved')->count();

        return view('applications.approved', compact('countOfTable'));
    }

    public function denied()
    {
        $this->cscProvProfileSet();
        $countOfTable = Application::where('status', 'Denied')->count();

        return view('applications.denied', compact('countOfTable'));
    }

    public function graduated()
    {
        $this->cscProvProfileSet();
        $countOfTable = Application::where('status', 'Graduated')->count();

        return view('applications.graduated', compact('countOfTable'));
    }


    public function newOnProcess()
    {
        $this->cscProvProfileSet();
        $countOfTable = Application::where('status', '')
            ->orWhere('status', 'New')
            ->orWhere('status', 'On Process')
            ->count();

        return view('applications.newOnProcess', compact('countOfTable'));
    }

    public function terminated()
    {
        $this->cscProvProfileSet();
        $countOfTable = Application::whereNotIn('status', ['New', 'Denied', 'Approved', 'On Process', 'Graduated'])
            ->whereNotNull('status')
            ->count();

        return view('applications.terminated', compact('countOfTable'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->cscProvProfileSet();
        $countOfTable = Application::count();

        return view('applications.index', compact('countOfTable'));
    }

    public function cscProvProfileSet()
    {
        if (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $ProfileSet = Profile::firstWhere('user_id', Auth::id());
            if ($ProfileSet == '') {
                $notification = array(
                    'message' => 'Update your profile first.',
                    'alert-type' => 'warning'
                );
                return redirect('profiles/' . Auth::id())->with($notification);
            }
        }
    }

    public function indexDT(Request $request)
    {
        $query = "SELECT applications.*, profiles.firstName, profiles.middleName, profiles.lastName, profiles.psgCode ,grants.acadYr, 
        employments.yearEmployed, employments.employerType, employments.position, employments.employerName, employments.employerAddress,
        users.avatar, cityCode.name AS city_name, provinceCode.name AS province_name, regionCode.name AS region_name

        FROM applications
       
        INNER JOIN profiles ON applications.user_id  = profiles.user_id
        INNER JOIN  grants  ON  applications . grant_id  =  grants.id
        LEFT JOIN  employments  ON  applications . user_id  =  employments . user_id 
        LEFT JOIN  users  ON  applications . user_id  =  users . id 
        
        INNER JOIN (
            SELECT * FROM psgc WHERE LEVEL IN ('Mun', 'City', 'SubMun')
        ) AS cityCode ON CONCAT(SUBSTRING(profiles .psgCode,1,6),'000') = cityCode.code

        INNER JOIN (
            SELECT * FROM psgc WHERE LEVEL IN ('Prov', 'Dist')
        ) AS provinceCode ON CONCAT(SUBSTRING(profiles.psgCode,1,4),'00000') = provinceCode.code

        INNER JOIN (
            SELECT * FROM psgc WHERE LEVEL IN ('Reg')
        ) AS regionCode ON CONCAT(SUBSTRING(profiles.psgCode,1,2),'0000000') = regionCode.code
        
        WHERE applications.deleted_at IS NULL";

        switch ($request->statusFilter) {
            case 'newOnProcess':
                $query = $query . " AND applications.status IN ('New','On Process','')";
                break;
            case 'approved':
                $query = $query . " AND applications.status = 'Approved'";
                break;
            case 'denied':
                $query = $query . " AND applications.status = 'Denied'";
                break;
            case 'graduated':
                $query = $query . " AND applications.status = 'Graduated'";
                break;
            case 'terminated':
                $query = $query . " AND applications.status NOT IN ('New','On Process','Denied','Approved','Graduated','')";
                break;
            default:
        }

        if (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $query = $query . " AND SUBSTRING(profiles.psgCode,1,2) = " . substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $query = $query . " AND SUBSTRING(profiles.psgCode,1,4) = " . substr(Auth::user()->profile->psgCode, 0, 4);
        }

        return GlobalClassDatatables::of($query)
            ->addAction('avatar', function ($data) {
                return '<div class="user-block icon-container"><img src="/storage/users-avatar/' . $data->avatar . '" class="img-circle img-bordered-sm cover" alt="' . $data->firstName . ' Avatar" loading="lazy"></div>';
            })
            ->addAction('fullname', function ($data) {
                return '<a href="' .  route("users.show", $data->user_id)  . '" title="Student Info">' . $data->firstName . ' ' . substr($data->middleName, 0, 1) . '. ' . $data->lastName . '</a>';
            })
            ->addAction('batch', function ($data) {
                return $data->acadYr . '-' . ($data->acadYr + 1);
            })
            ->addAction('date', function ($data) {
                if ($data->status == "New" || $data->status == "") {
                    return $data->created_at;
                } elseif ($data->status == "On Process") {
                    return $data->date_process;
                } elseif ($data->status == "Denied") {
                    return $data->date_denied;
                } elseif ($data->status == "Approved") {
                    return $data->date_approved;
                } elseif ($data->status == "Graduated") {
                    return $data->date_graduated;
                } else {
                    return $data->date_terminated;
                }
            })
            ->addAction('action', function ($data) {

                if (Auth::user()->can('application-read')) {
                    $btnViewApplication = '<a href="' . url("/applications/applicationForm/" . $data->id) . '" class="btn btn-info btn-sm mr-1 mb-1">Application Form</a>';
                } else {
                    $btnViewApplication = '';
                }

                if (Auth::user()->can('document-browse')) {
                    $btnViewDocs = '<a href="' . url("showAttachment/" . $data->grant_id . '/' . $data->user_id) . '" class="btn btn-info btn-sm mr-1 mb-1">View Files</a>';
                } else {
                    $btnViewDocs = '';
                }

                if (Auth::user()->can('application-edit')) {
                    $btnAppEdit = '<button onclick="appEdit(this)" data-url="' .  route("applications.edit", $data->id) . '" class="btn btn-primary btn-sm mr-1 mb-1">Edit Application</button>';
                } else {
                    $btnAppEdit = '';
                }

                if (Auth::user()->can('application-delete')) {
                    $btnAppDel = '<button onclick="appDel(this)" data-url="' .  route("applications.destroy", $data->id) . '" class="btn btn-danger btn-sm mr-1 mb-1">Delete</button>';
                } else {
                    $btnAppDel = '';
                }

                if (Auth::user()->hasAnyRole(['Admin|Regional Officer'])) {
                    if (Auth::user()->can('expenses-add')) {
                        ($data->status == "Approved") ? $btnPayment = '<button onclick="appPayment(this)" data-payee="' . $data->firstName . ' ' . substr($data->middleName, 0, 1) . '. ' . $data->lastName . '" data-particular="Grant Payment" data-province="' . substr($data->psgCode, 0, 4) . '00000" data-userId="' . $data->user_id . '" data-applicationId="' . $data->id . '" data-grantId="' . $data->grant_id . '" class="btn btn-success btn-sm mr-1 mb-1">Payment</button>' : $btnPayment = '';
                    } else {
                        $btnPayment = '';
                    }
                } else {
                    $btnPayment = '';
                }

                if ($data->status == "Graduated" && $data->level == "College") {
                    if ($data->employerName != '') {
                        $btnEmployment = '<button onclick="Employment(this)" data-userID="' . $data->user_id . '" data-yearEmployed="' . $data->yearEmployed . '" data-employerType="' . $data->employerType . '" data-position="' . $data->position . '" data-employerName="' . $data->employerName . '" data-employerAddress="' . $data->employerAddress . '" class="btn btn-primary btn-sm mr-1 mb-1">Employed</button>';
                    } else {
                        $btnEmployment = '<button onclick="Employment(this)" data-userID="' . $data->user_id . '" class="btn btn-warning btn-sm mr-1 mb-1 btn-add-employment">Not Employed</button>';
                    }
                } else {
                    $btnEmployment = '';
                }

                return $btnViewApplication . $btnViewDocs . $btnAppEdit . $btnAppDel . $btnPayment . $btnEmployment;
            })
            ->request($request)
            ->searchable(['firstName', 'middleName', 'lastName', 'acadYr', 'type', 'applications.level', 'status', 'remarks', 'cityCode.name', 'provinceCode.name', 'regionCode.name'])
            ->make();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validateWithBag('application', [
            'id',
            'grant_id' => 'required',
            'user_id' => 'required',
            'type' => 'required',
            'level' => 'required',
            'school' => 'required',
            'course' => 'required',
            'contribution' => 'required',
            'plans' => 'required',
            'status' => 'nullable',
            'remarks' => 'nullable',
        ]);

        $grantid = [
            "id" => $request->id,
        ];

        $current_date = now();
        if ($request->status == 'On Process') {
            $request->request->add(['date_process' => $current_date]);
        } elseif ($request->status == 'Approved') {
            $request->request->add(['date_approved' => $current_date]);
        } elseif ($request->status == 'Graduated') {
            $request->request->add(['date_graduated' => $current_date]);
        } elseif ($request->status == 'Terminated-FSD' || $request->status == 'Terminated-FG' || $request->status == 'Terminated-DS' || $request->status == 'Terminated-NE' || $request->status == 'Terminated-FPD' || $request->status == 'Terminated-EOGS' || $request->status == 'Terminated-Others') {
            $request->request->add(['date_terminated' => $current_date]);
        } elseif ($request->status == 'Denied') {
            $request->request->add(['date_denied' => $current_date]);
        }

        $grantInformation = $request->all();

        Application::updateOrCreate($grantid, $grantInformation);

        $notification = array(
            'message' => 'Application updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::find($id);

        return response()->json(['application' => $application]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Application::find($id)->delete();

        $notification = array(
            'message' => 'Record deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
