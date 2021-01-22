<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Calendar;
use App\Models\Dashboard;
use App\Models\Grant;
use App\Models\Psgc;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class DashboardController extends Controller
{
    public function admin()
    {
        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        return view('dashboards.admin',compact('data'));
    }

    public function executiveOfficer()
    {
        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        return view('dashboards.executive',compact('data'));
    }

    public function regionalOfficer()
    {
        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        return view('dashboards.regional',compact('data'));
    }

    public function provincialOfficer()
    {
        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        return view('dashboards.provincial',compact('data'));
    }

    public function communityOfficer()
    {
        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        return view('dashboards.community',compact('data'));
    }

    public function applicant()
    {
        $userProfile = Profile::where('user_id', Auth::id())->first();

        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $regions = Psgc::where('level', 'Reg')->get();
        } else {
            if (Auth::user()->region) {
                $regions = Psgc::where('code', Auth::user()->region)->get();
            } else {
                $regions = Psgc::where('level', 'Reg')->get();
            }
        }

        $data = Calendar::with('regionname')->orderBy('dateTimeStart', 'DESC')->get();
        $psgCode = $userProfile->psgCode ?? '';
        //$psgCode = Auth::user()->profile->psgCode;
        $grants = array();
        $userRegion = Str::substr($psgCode, 0, 2) . "0000000";

        if ($psgCode != '') {
            $userRegion = Str::substr($psgCode, 0, 2) . "0000000";
            $grants = Grant::where('region', $userRegion)
                ->where('applicationOpen', '<=', date('Y-m-d'))
                ->where('applicationClosed', '>=', date('Y-m-d'))
                ->get();
        }

        $region = Psgc::where('code', Str::substr($psgCode, 0, 2) . "0000000")->first();
        $province = Psgc::where('code', Str::substr($psgCode, 0, 4) . "00000")->first();
        $city = Psgc::where('code', Str::substr($psgCode, 0, 6) . "000")->first();
        $barangay = Psgc::where('code', $psgCode)->first();


        $applications = Application::with('grant.psgCode')->where('user_id', Auth::id())->get();

        return view('dashboards.applicant', compact('grants', 'applications', 'psgCode', 'regions', 'userProfile', 'userRegion', 'data', 'region', 'province', 'city', 'barangay'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }

    public function getImage(Request $request){
        $userAvatar = $request->userAvatar ?? (Auth::user()->avatar ?? 'avatar.png');

        $path = storage_path('app/public/users-avatar/' . $userAvatar);

        if (!File::exists($path)) {
            return $path;
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
