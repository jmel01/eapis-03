<?php

namespace App\Http\Controllers;

use App\ChartArray\ChartOrganization;
use App\ChartArray\Regional;
use App\Models\AdminCost;
use App\Models\Application;
use App\Models\Calendar;
use App\Models\Dashboard;
use App\Models\Grant;
use App\Models\Psgc;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Spatie\Activitylog\Models\Activity;


class DashboardController extends Controller
{
    public function admin()
    {
        $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
        $regions = Psgc::where('level', 'Reg')->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')->get();
        $chartDataAll = Regional::regionsApplicant($regions, $userProfile);

        $userProfileNew = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'New')
            ->get();
        $chartDataNew = Regional::regionsApplicant($regions, $userProfileNew);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::regionsApplicant($regions, $userProfileApproved);

        $userProfileGraduated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Graduated')
            ->get();
        $chartDataGraduated = Regional::regionsApplicant($regions, $userProfileGraduated);

        $userProfileOnProcess = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'On Process')
            ->get();
        $chartDataOnProcess = Regional::regionsApplicant($regions, $userProfileOnProcess);

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
            ->where('status', 'Approved')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('gender', 'Female')
            ->where('status', 'Approved')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'Regular')
            ->where('status', 'Approved')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'Merit-Based')
            ->where('status', 'Approved')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'PDAF')
            ->where('status', 'Approved')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Post Study')
            ->where('status', 'Approved')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'College')
            ->where('status', 'Approved')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Vocational')
            ->where('status', 'Approved')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'High School')
            ->where('status', 'Approved')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Elementary')
            ->where('status', 'Approved')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')->sum('amount');

        return view(
            'dashboards.admin',
            compact(
                'data',
                'regions',
                'chartDataAll',
                'chartDataNew',
                'chartDataApproved',
                'chartDataOnProcess',
                'chartDataTerminated',
                'chartDataGraduated',
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

        $userProfileNew = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'New')
            ->get();
        $chartDataNew = Regional::regionsApplicant($regions, $userProfileNew);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::regionsApplicant($regions, $userProfileApproved);

        $userProfileGraduated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'Graduated')
            ->get();
        $chartDataGraduated = Regional::regionsApplicant($regions, $userProfileGraduated);

        $userProfileOnProcess = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('status', 'On Process')
            ->get();
        $chartDataOnProcess = Regional::regionsApplicant($regions, $userProfileOnProcess);

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
            ->where('status', 'Approved')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('gender', 'Female')
            ->where('status', 'Approved')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'Regular')
            ->where('status', 'Approved')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'Merit-Based')
            ->where('status', 'Approved')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('type', 'PDAF')
            ->where('status', 'Approved')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Post Study')
            ->where('status', 'Approved')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'College')
            ->where('status', 'Approved')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Vocational')
            ->where('status', 'Approved')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'High School')
            ->where('status', 'Approved')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where('level', 'Elementary')
            ->where('status', 'Approved')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')->sum('amount');

        $adminCostsPerRegion = Regional::adminCost();
        $grantsPerRegion = Regional::assistance();

        return view(
            'dashboards.executive',
            compact(
                'data',
                'regions',
                'chartDataAll',
                'chartDataNew',
                'chartDataApproved',
                'chartDataOnProcess',
                'chartDataTerminated',
                'chartDataGraduated',
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
                'totalGrantDisburse',
                'adminCostsPerRegion',
                'grantsPerRegion'
            )
        );
    }

    public function regionalOfficer()
    {
        $data = Calendar::where('region', Auth::user()->region)
            ->orderBy('dateTimeStart', 'DESC')->get();

        $regionId = Str::substr(Auth::user()->region, 0, 2);

        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])->get();
        $chartDataAll = Regional::provincesApplicant($provinces, $userProfile);

        $userProfileNew = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'New')
            ->get();
        $chartDataNew = Regional::provincesApplicant($provinces, $userProfileNew);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::provincesApplicant($provinces, $userProfileApproved);

        $userProfileOnProcess = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'On Process')
            ->get();

        $chartDataOnProcess = Regional::provincesApplicant($provinces, $userProfileOnProcess);

        $userProfileGraduated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Graduated')
            ->get();
        $chartDataGraduated = Regional::provincesApplicant($provinces, $userProfileGraduated);

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
            ->where('status', 'Approved')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('gender', 'Female')
            ->where('status', 'Approved')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'Regular')
            ->where('status', 'Approved')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'Merit-Based')
            ->where('status', 'Approved')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'PDAF')
            ->where('status', 'Approved')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Post Study')
            ->where('status', 'Approved')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'College')
            ->where('status', 'Approved')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Vocational')
            ->where('status', 'Approved')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'High School')
            ->where('status', 'Approved')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Elementary')
            ->where('status', 'Approved')
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
                'chartDataNew',
                'chartDataApproved',
                'chartDataOnProcess',
                'chartDataTerminated',
                'chartDataGraduated',
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
            return redirect('profiles/' . Auth::id())->with($notification);
        }

        $data = Calendar::where('region', Auth::user()->region)
            ->orderBy('dateTimeStart', 'DESC')->get();

        $provinceId = Str::substr(Auth::user()->profile->psgCode, 0, 4);
        $datas = ChartOrganization::provinceChartOne($provinceId);

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
            ->where('status', 'Approved')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('gender', 'Female')
            ->where('status', 'Approved')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Regular')
            ->where('status', 'Approved')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Merit-Based')
            ->where('status', 'Approved')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'PDAF')
            ->where('status', 'Approved')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Post Study')
            ->where('status', 'Approved')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'College')
            ->where('status', 'Approved')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Vocational')
            ->where('status', 'Approved')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'High School')
            ->where('status', 'Approved')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Elementary')
            ->where('status', 'Approved')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->sum('amount');

        return view('dashboards.provincial', compact(
            'data',
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
        ), $datas);
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
            return redirect('profiles/' . Auth::id())->with($notification);
        }

        $data = Calendar::where('region', Auth::user()->region)
            ->orderBy('dateTimeStart', 'DESC')->get();

        $provinceId = Str::substr(Auth::user()->profile->psgCode, 0, 4);

        $cities = Psgc::where([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'City']])
            ->orwhere([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'Mun']])
            ->orwhere([[\DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'SubMun']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])->get();
        $chartDataAll = Regional::citiesApplicant($cities, $userProfile);

        $userProfileNew = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'New')
            ->get();
        $chartDataNew = Regional::citiesApplicant($cities, $userProfileNew);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::citiesApplicant($cities, $userProfileApproved);

        $userProfileOnProcess = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'On Process')
            ->get();

        $chartDataOnProcess = Regional::citiesApplicant($cities, $userProfileOnProcess);

        $userProfileGraduated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Graduated')
            ->get();
        $chartDataGraduated = Regional::citiesApplicant($cities, $userProfileGraduated);

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
            ->where('status', 'Approved')
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('gender', 'Female')
            ->where('status', 'Approved')
            ->count();

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Regular')
            ->where('status', 'Approved')
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Merit-Based')
            ->where('status', 'Approved')
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'PDAF')
            ->where('status', 'Approved')
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Post Study')
            ->where('status', 'Approved')
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'College')
            ->where('status', 'Approved')
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Vocational')
            ->where('status', 'Approved')
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'High School')
            ->where('status', 'Approved')
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Elementary')
            ->where('status', 'Approved')
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->sum('amount');

        return view('dashboards.community', compact(
            'data',
            'cities',
            'chartDataAll',
            'chartDataNew',
            'chartDataOnProcess',
            'chartDataApproved',
            'chartDataGraduated',
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

        $data = Calendar::with('regionname')
            ->where('region', Auth::user()->region)
            ->orderBy('dateTimeStart', 'DESC')->get();

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

    public function activityLogs()
    {
        $activity = Activity::orderBy('created_at', 'Desc')->get();

        return view('activity.index', compact('activity'));
    }

    public function clearActivityLogs()
    {
        Activity::truncate();

        $notification = array(
            'message' => 'Logs cleared successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function filterChart(Request $request)
    {
        switch ($request->type) {
            case 'region':
                $datas = ChartOrganization::regionChartOne(Str::substr($request->regionId, 0, 2), $request->dateFrom, $request->dateTo);
                break;

            case 'province':
                $datas = ChartOrganization::provinceChartOne(Str::substr($request->provinceId, 0, 4), $request->dateFrom, $request->dateTo);
                break;

            case 'city':
                $datas = ChartOrganization::cityChartOne(Str::substr($request->cityId, 0, 6), $request->dateFrom, $request->dateTo);
                break;
        }

        return response()->json([
            'myChartOne' => view('dashboards.charts.my-chart', $datas)->render()
        ]);
    }
}
