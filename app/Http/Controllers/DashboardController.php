<?php

namespace App\Http\Controllers;

use App\ChartArray\Regional;
use App\Models\AdminCost;
use App\Models\Application;
use App\Models\AuditEvent;
use App\Models\Calendar;
use App\Models\Dashboard;
use App\Models\Document;
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
        $regions = Psgc::where('level', 'Reg')->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')->get();
        $chartDataAll = Regional::regionsApplicant($regions, $userProfile);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::regionsApplicant($regions, $userProfileApproved);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-FSD')
            ->orWhere('status', 'Terminated-FG')
            ->orWhere('status', 'Terminated-DS')
            ->orWhere('status', 'Terminated-NE')
            ->orWhere('status', 'Terminated-FPD')
            ->orWhere('status', 'Terminated-EOGS')
            ->orWhere('status', 'Terminated-Others')
            ->get();
        $chartDataTerminated = Regional::regionsApplicant($regions, $userProfileTerminated);

        $terminatedFSD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-FSD')
            ->count();

        $terminatedFG = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-FG')
            ->count();

        $terminatedDS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-DS')
            ->count();

        $terminatedNE = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-NE')
            ->count();

        $terminatedFPD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-FPD')
            ->count();

        $terminatedEOGS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-EOGS')
            ->count();

        $terminatedOthers = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-Others')
            ->count();

        $numberOfMales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('gender', 'Male')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('gender', 'Female')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'Regular')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'Merit-Based')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'PDAF')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Post Study')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'College')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Vocational')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'High School')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Elementary')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')->sum('amount');

        return view(
            'dashboards.admin',
            compact(
                'data',
                'regions',
                'chartDataAll',
                'chartDataApproved',
                'chartDataTerminated',
                'terminatedFSD',
                'terminatedFG',
                'terminatedDS',
                'terminatedNE',
                'terminatedFPD',
                'terminatedEOGS',
                'terminatedOthers',
                'numberOfMales',
                'numberOfFemales',
                'numberOfEAP',
                'numberOfMerit',
                'numberOfPAMANA',
                'numberOfPostStudy',
                'numberOfCollege',
                'numberOfVocational',
                'numberOfHighSchool',
                'numberOfElementary',
                'totalAdminCost',
                'totalGrantDisburse'
            )
        );
    }

    public function executiveOfficer()
    {
        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        $regions = Psgc::where('level', 'Reg')->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')->get();
        $chartDataAll = Regional::regionsApplicant($regions, $userProfile);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::regionsApplicant($regions, $userProfileApproved);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-FSD')
            ->orWhere('status', 'Terminated-FG')
            ->orWhere('status', 'Terminated-DS')
            ->orWhere('status', 'Terminated-NE')
            ->orWhere('status', 'Terminated-FPD')
            ->orWhere('status', 'Terminated-EOGS')
            ->orWhere('status', 'Terminated-Others')
            ->get();
        $chartDataTerminated = Regional::regionsApplicant($regions, $userProfileTerminated);

        $terminatedFSD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-FSD')
            ->count();

        $terminatedFG = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-FG')
            ->count();

        $terminatedDS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-DS')
            ->count();

        $terminatedNE = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-NE')
            ->count();

        $terminatedFPD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-FPD')
            ->count();

        $terminatedEOGS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-EOGS')
            ->count();

        $terminatedOthers = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Terminated-Others')
            ->count();

        $numberOfMales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('gender', 'Male')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('gender', 'Female')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'Regular')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'Merit-Based')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'PDAF')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Post Study')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'College')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Vocational')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'High School')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Elementary')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')->sum('amount');

        return view(
            'dashboards.executive',
            compact(
                'data',
                'regions',
                'chartDataAll',
                'chartDataApproved',
                'chartDataTerminated',
                'terminatedFSD',
                'terminatedFG',
                'terminatedDS',
                'terminatedNE',
                'terminatedFPD',
                'terminatedEOGS',
                'terminatedOthers',
                'numberOfMales',
                'numberOfFemales',
                'numberOfEAP',
                'numberOfMerit',
                'numberOfPAMANA',
                'numberOfPostStudy',
                'numberOfCollege',
                'numberOfVocational',
                'numberOfHighSchool',
                'numberOfElementary',
                'totalAdminCost',
                'totalGrantDisburse'
            )
        );
    }

    public function regionalOfficer()
    {
        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();

        $regionId = Str::substr(Auth::user()->region, 0, 2);

        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])->get();
        $chartDataAll = Regional::provincesApplicant($provinces, $userProfile);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::provincesApplicant($provinces, $userProfileApproved);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-FSD')
            ->orWhere('status', 'Terminated-FG')
            ->orWhere('status', 'Terminated-DS')
            ->orWhere('status', 'Terminated-NE')
            ->orWhere('status', 'Terminated-FPD')
            ->orWhere('status', 'Terminated-EOGS')
            ->orWhere('status', 'Terminated-Others')
            ->get();
        $chartDataTerminated = Regional::provincesApplicant($provinces, $userProfileTerminated);

        $terminatedFSD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-FSD')
            ->count();

        $terminatedFG = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-FG')
            ->count();

        $terminatedDS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-DS')
            ->count();

        $terminatedNE = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-NE')
            ->count();

        $terminatedFPD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-FPD')
            ->count();

        $terminatedEOGS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-EOGS')
            ->count();

        $terminatedOthers = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-Others')
            ->count();

        $numberOfMales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('gender', 'Male')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('gender', 'Female')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'Regular')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'Merit-Based')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'PDAF')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Post Study')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'College')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Vocational')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'High School')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Elementary')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 2)'), '=', $regionId]])
            ->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 2)'), '=', $regionId]])
            ->sum('amount');

        return view(
            'dashboards.regional',
            compact(
                'data',
                'provinces',
                'chartDataAll',
                'chartDataApproved',
                'chartDataTerminated',
                'terminatedFSD',
                'terminatedFG',
                'terminatedDS',
                'terminatedNE',
                'terminatedFPD',
                'terminatedEOGS',
                'terminatedOthers',
                'numberOfMales',
                'numberOfFemales',
                'numberOfEAP',
                'numberOfMerit',
                'numberOfPAMANA',
                'numberOfPostStudy',
                'numberOfCollege',
                'numberOfVocational',
                'numberOfHighSchool',
                'numberOfElementary',
                'totalAdminCost',
                'totalGrantDisburse'
            )
        );
    }

    public function provincialOfficer()
    {
        /* Check if user updated profile else redirect */
        $ProfileSet = Profile::firstWhere('user_id', Auth::id());
        if ($ProfileSet == '') {
            $notification = array(
                'message' => 'Update your profile first.',
                'alert-type' => 'info'
            );
            return redirect('profiles/'.Auth::id())->with($notification);
        }

        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        $provinceId = Str::substr(Auth::user()->profile->psgCode, 0, 4);

        $cities = Psgc::where([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'City']])
            ->orwhere([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'Mun']])
            ->orwhere([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'SubMun']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])->get();
        $chartDataAll = Regional::citiesApplicant($cities, $userProfile);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::citiesApplicant($cities, $userProfileApproved);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FSD')
            ->orWhere('status', 'Terminated-FG')
            ->orWhere('status', 'Terminated-DS')
            ->orWhere('status', 'Terminated-NE')
            ->orWhere('status', 'Terminated-FPD')
            ->orWhere('status', 'Terminated-EOGS')
            ->orWhere('status', 'Terminated-Others')
            ->get();
        $chartDataTerminated = Regional::citiesApplicant($cities, $userProfileTerminated);

        $terminatedFSD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FSD')
            ->count();

        $terminatedFG = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FG')
            ->count();

        $terminatedDS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-DS')
            ->count();

        $terminatedNE = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-NE')
            ->count();

        $terminatedFPD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FPD')
            ->count();

        $terminatedEOGS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-EOGS')
            ->count();

        $terminatedOthers = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-Others')
            ->count();

        $numberOfMales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('gender', 'Male')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('gender', 'Female')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Regular')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Merit-Based')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'PDAF')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Post Study')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'College')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Vocational')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'High School')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Elementary')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->sum('amount');

        return view('dashboards.provincial', compact(
            'data',
            'cities',
            'chartDataAll',
            'chartDataApproved',
            'chartDataTerminated',
            'terminatedFSD',
            'terminatedFG',
            'terminatedDS',
            'terminatedNE',
            'terminatedFPD',
            'terminatedEOGS',
            'terminatedOthers',
            'numberOfMales',
            'numberOfFemales',
            'numberOfEAP',
            'numberOfMerit',
            'numberOfPAMANA',
            'numberOfPostStudy',
            'numberOfCollege',
            'numberOfVocational',
            'numberOfHighSchool',
            'numberOfElementary',
            'totalAdminCost',
            'totalGrantDisburse'
        ));
    }

    public function communityOfficer()
    {
        /* Check if user updated profile else redirect */
        $ProfileSet = Profile::firstWhere('user_id', Auth::id());
        if ($ProfileSet == '') {
            $notification = array(
                'message' => 'Update your profile first.',
                'alert-type' => 'info'
            );
            return redirect('profiles/'.Auth::id())->with($notification);
        }

        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        $provinceId = Str::substr(Auth::user()->profile->psgCode, 0, 4);

        $cities = Psgc::where([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'City']])
            ->orwhere([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'Mun']])
            ->orwhere([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'SubMun']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])->get();
        $chartDataAll = Regional::citiesApplicant($cities, $userProfile);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::citiesApplicant($cities, $userProfileApproved);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FSD')
            ->orWhere('status', 'Terminated-FG')
            ->orWhere('status', 'Terminated-DS')
            ->orWhere('status', 'Terminated-NE')
            ->orWhere('status', 'Terminated-FPD')
            ->orWhere('status', 'Terminated-EOGS')
            ->orWhere('status', 'Terminated-Others')
            ->get();
        $chartDataTerminated = Regional::citiesApplicant($cities, $userProfileTerminated);

        $terminatedFSD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FSD')
            ->count();

        $terminatedFG = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FG')
            ->count();

        $terminatedDS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-DS')
            ->count();

        $terminatedNE = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-NE')
            ->count();

        $terminatedFPD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FPD')
            ->count();

        $terminatedEOGS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-EOGS')
            ->count();

        $terminatedOthers = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-Others')
            ->count();

        $numberOfMales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('gender', 'Male')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('gender', 'Female')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Regular')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Merit-Based')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'PDAF')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Post Study')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'College')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Vocational')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'High School')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Elementary')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->sum('amount');

        return view('dashboards.provincial', compact(
            'data',
            'cities',
            'chartDataAll',
            'chartDataApproved',
            'chartDataTerminated',
            'terminatedFSD',
            'terminatedFG',
            'terminatedDS',
            'terminatedNE',
            'terminatedFPD',
            'terminatedEOGS',
            'terminatedOthers',
            'numberOfMales',
            'numberOfFemales',
            'numberOfEAP',
            'numberOfMerit',
            'numberOfPAMANA',
            'numberOfPostStudy',
            'numberOfCollege',
            'numberOfVocational',
            'numberOfHighSchool',
            'numberOfElementary',
            'totalAdminCost',
            'totalGrantDisburse'
        ));
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

        $payments = AdminCost::where('user_id', Auth::id())->get();

        return view('dashboards.applicant', compact('grants', 'applications', 'psgCode', 'regions', 'userProfile', 'userRegion', 'data', 'region', 'province', 'city', 'barangay', 'payments'));
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

    public function getImage(Request $request)
    {
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

    public function userLogs(){
        $auditEvents = AuditEvent::all();

        return view('userlogs.index', compact('auditEvents'));
    }
}
