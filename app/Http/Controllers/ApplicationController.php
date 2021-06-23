<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Grant;
use App\Models\Psgc;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $userBrgy = DB::table('profiles')
        //     ->leftJoin('psgc', 'profiles.psgCode', '=', 'psgc.code')
        //     ->select('profiles.user_id', 'psgc.name')
        //     ->get();

        // $userCity = DB::table('profiles')
        //     ->leftJoin('psgc', DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,6),'000')"), '=', 'psgc.code')
        //     ->select('profiles.user_id', 'psgc.name as userCity')
        //     ->get();
        // $userProv = DB::table('profiles')
        //     ->leftJoin('psgc', DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,4),'00000')"), '=', 'psgc.code')
        //     ->select('profiles.user_id', 'psgc.name')
        //     ->get();
        // $userRegion = DB::table('profiles')
        //     ->leftJoin('psgc', DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,2),'0000000')"), '=', 'psgc.code')
        //     ->select('profiles.user_id', 'psgc.name')
        //     ->get();
        // dd($userRegion);

        // $location = DB::table('profiles')
        //     ->select(
        //         'profiles.user_id',
        //         'profiles.psgCode as brgy',
        //         DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,6),'000') as city"),
        //         DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,4),'00000') as province"),
        //         DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,2),'0000000') as region")
        //     )

        //     ->get();

        $data = DB::table('applications')
            ->join('profiles', 'applications.user_id', '=', 'profiles.user_id')
            ->join('grants', 'applications.grant_id', '=', 'grants.id')
            ->leftJoin('employments', 'applications.user_id', '=', 'employments.user_id')
            ->leftJoin('users', 'applications.user_id', '=', 'users.id')
          
            // ->leftJoin('psgc as city', DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,6),'000')"), '=', 'city.code')
            // ->leftJoin('psgc as prov', DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,4),'00000')"), '=', 'prov.code')
            // ->leftJoin('psgc as reg', DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,2),'0000000')"), '=', 'reg.code')
            ->whereNull('applications.deleted_at')
            ->select(
                'applications.*',
                'profiles.firstName',
                'profiles.middleName',
                'profiles.lastName',
                'profiles.psgCode as brgy',
                DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,6),'000') as city"),
                DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,4),'00000') as province"),
                DB::raw("CONCAT( SUBSTRING(profiles.psgCode,1,2),'0000000') as region"),
                'grants.acadYr',
                'employments.yearEmployed',
                'employments.employerType',
                'employments.position',
                'employments.employerName',
                'employments.employerAddress',
                'users.avatar',
                // 'city.name as cityName',
                // 'prov.name as provName',
                // 'reg.name as regName'
            )

            ->orderBy('profiles.lastName', 'ASC')
            ->get();


        if ($request->ajax()) {
            return Datatables::of($data)
                ->addColumn('fullname', function ($data) {
                    return $data->firstName . ' ' . substr($data->middleName, 0, 1) . '. ' . $data->lastName;
                })
                ->addColumn('batch', function ($data) {
                    return $data->acadYr . '-' . ($data->acadYr + 1);
                })
                // Works but slow
                // ->addColumn('region', function ($data) {
                //     return Psgc::where('code', $data->region)->first()->name;
                // })
                // ->addColumn('province', function ($data) {
                //     return Psgc::where('code', $data->province)->first()->name;
                // })
                // ->addColumn('city', function ($data) {
                //     return Psgc::where('code', $data->city)->first()->name;
                // })
                // ->addColumn('province', function ($data) {
                //     $provinceCode = Str::substr($data->psgCode, 0, 4).'00000';
                //     $getProvince = Psgc::where('code', $provinceCode)->first();
                //     return $getProvince['name'];
                // })
                ->make(true);
        }

        return view('applications.index');
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
