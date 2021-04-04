<?php

namespace App\ChartArray;

use App\Models\AdminCost;
use App\Models\Application;
use App\Models\Psgc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChartOrganization
{

    static function regionChartOne($regionId, $dateFrom = '', $dateTo = '')
    {
        $provinces = Psgc::where([[DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();

        $chartDataAll = Regional::provincesApplicant($provinces, $userProfile);

        $userProfileNew = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'New')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataNew = Regional::provincesApplicant($provinces, $userProfileNew);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataApproved = Regional::provincesApplicant($provinces, $userProfileApproved);

        $userProfileOnProcess = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'On Process')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();

        $chartDataOnProcess = Regional::provincesApplicant($provinces, $userProfileOnProcess);

        $userProfileGraduated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Graduated')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataGraduated = Regional::provincesApplicant($provinces, $userProfileGraduated);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where(function ($query) {
                $query->where('status', 'Terminated-FSD')
                    ->orWhere('status', 'Terminated-FG')
                    ->orWhere('status', 'Terminated-DS')
                    ->orWhere('status', 'Terminated-NE')
                    ->orWhere('status', 'Terminated-FPD')
                    ->orWhere('status', 'Terminated-EOGS')
                    ->orWhere('status', 'Terminated-Others');
            })
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();

        $chartDataTerminated = Regional::provincesApplicant($provinces, $userProfileTerminated);

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'Regular')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'Merit-Based')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('type', 'PDAF')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Post Study')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'College')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Vocational')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'High School')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('level', 'Elementary')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfMales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('gender', 'Male')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('gender', 'Female')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFSD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-FSD')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFG = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-FG')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedDS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-DS')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedNE = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-NE')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFPD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-FPD')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedEOGS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-EOGS')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedOthers = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[\DB::raw('substr(profiles.psgCode, 1, 2)'), '=', $regionId]])
            ->where('status', 'Terminated-Others')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 2)'), '=', $regionId]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('dateRcvd', [$dateFrom, $dateTo]);
                }
            })
            ->sum('amount');

        $totalGrantDisburse = AdminCost::whereNotNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 2)'), '=', $regionId]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('dateRcvd', [$dateFrom, $dateTo]);
                }
            })
            ->sum('amount');

        return [
            'type' => 'region',
            'zone' => $provinces,
            'chartDataAll' => $chartDataAll,
            'chartDataNew' => $chartDataNew,
            'chartDataApproved' => $chartDataApproved,
            'chartDataOnProcess' => $chartDataOnProcess,
            'chartDataGraduated' => $chartDataGraduated,
            'chartDataTerminated' => $chartDataTerminated,
            'numberOfEAP' => $numberOfEAP,
            'numberOfMerit' => $numberOfMerit,
            'numberOfPAMANA' => $numberOfPAMANA,
            'numberOfPostStudy' => $numberOfPostStudy,
            'numberOfCollege' => $numberOfCollege,
            'numberOfVocational' => $numberOfVocational,
            'numberOfHighSchool' => $numberOfHighSchool,
            'numberOfElementary' => $numberOfElementary,
            'numberOfMales' => $numberOfMales,
            'numberOfFemales' => $numberOfFemales,
            'terminatedFSD' => $terminatedFSD,
            'terminatedFG' => $terminatedFG,
            'terminatedDS' => $terminatedDS,
            'terminatedNE' => $terminatedNE,
            'terminatedFPD' => $terminatedFPD,
            'terminatedEOGS' => $terminatedEOGS,
            'terminatedOthers' => $terminatedOthers,
            'totalAdminCost' => $totalAdminCost,
            'totalGrantDisburse' => $totalGrantDisburse,
        ];
    }

    static function provinceChartOne($provinceId, $dateFrom = '', $dateTo = '')
    {
        $cities = Psgc::where([[DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'City']])
            ->orwhere([[DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'Mun']])
            ->orwhere([[DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'SubMun']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataAll = Regional::citiesApplicant($cities, $userProfile);

        $userProfileNew = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'New')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataNew = Regional::citiesApplicant($cities, $userProfileNew);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataApproved = Regional::citiesApplicant($cities, $userProfileApproved);

        $userProfileOnProcess = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'On Process')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();

        $chartDataOnProcess = Regional::citiesApplicant($cities, $userProfileOnProcess);

        $userProfileGraduated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Graduated')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataGraduated = Regional::citiesApplicant($cities, $userProfileGraduated);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where(function ($query) {
                $query->where('status', 'Terminated-FSD')
                    ->orWhere('status', 'Terminated-FG')
                    ->orWhere('status', 'Terminated-DS')
                    ->orWhere('status', 'Terminated-NE')
                    ->orWhere('status', 'Terminated-FPD')
                    ->orWhere('status', 'Terminated-EOGS')
                    ->orWhere('status', 'Terminated-Others');
            })
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataTerminated = Regional::citiesApplicant($cities, $userProfileTerminated);

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Regular')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'Merit-Based')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('type', 'PDAF')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Post Study')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'College')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Vocational')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'High School')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('level', 'Elementary')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfMales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('gender', 'Male')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('gender', 'Female')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFSD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FSD')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFG = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FG')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedDS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-DS')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedNE = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-NE')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFPD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FPD')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedEOGS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-EOGS')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedOthers = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-Others')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('dateRcvd', [$dateFrom, $dateTo]);
                }
            })
            ->sum('amount');

        $totalGrantDisburse = AdminCost::whereNotNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', $provinceId]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('dateRcvd', [$dateFrom, $dateTo]);
                }
            })
            ->sum('amount');

        return [
            'type' => 'province',
            'zone' => $cities,
            'chartDataAll' => $chartDataAll,
            'chartDataNew' => $chartDataNew,
            'chartDataApproved' => $chartDataApproved,
            'chartDataOnProcess' => $chartDataOnProcess,
            'chartDataGraduated' => $chartDataGraduated,
            'chartDataTerminated' => $chartDataTerminated,
            'numberOfEAP' => $numberOfEAP,
            'numberOfMerit' => $numberOfMerit,
            'numberOfPAMANA' => $numberOfPAMANA,
            'numberOfPostStudy' => $numberOfPostStudy,
            'numberOfCollege' => $numberOfCollege,
            'numberOfVocational' => $numberOfVocational,
            'numberOfHighSchool' => $numberOfHighSchool,
            'numberOfElementary' => $numberOfElementary,
            'numberOfMales' => $numberOfMales,
            'numberOfFemales' => $numberOfFemales,
            'terminatedFSD' => $terminatedFSD,
            'terminatedFG' => $terminatedFG,
            'terminatedDS' => $terminatedDS,
            'terminatedNE' => $terminatedNE,
            'terminatedFPD' => $terminatedFPD,
            'terminatedEOGS' => $terminatedEOGS,
            'terminatedOthers' => $terminatedOthers,
            'totalAdminCost' => $totalAdminCost,
            'totalGrantDisburse' => $totalGrantDisburse,
        ];
    }

    static function cityChartOne($cityId, $dateFrom = '', $dateTo = '')
    {
        $barangays = Psgc::where([[DB::raw('substr(code, 1, 6)'), '=', $cityId], ['level', 'Bgy']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();

        $chartDataAll = Regional::barangaysApplicant($barangays, $userProfile);

        $userProfileNew = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'New')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataNew = Regional::barangaysApplicant($barangays, $userProfileNew);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataApproved = Regional::barangaysApplicant($barangays, $userProfileApproved);

        $userProfileOnProcess = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'On Process')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();

        $chartDataOnProcess = Regional::barangaysApplicant($barangays, $userProfileOnProcess);

        $userProfileGraduated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Graduated')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();
        $chartDataGraduated = Regional::barangaysApplicant($barangays, $userProfileGraduated);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where(function ($query) {
                $query->where('status', 'Terminated-FSD')
                    ->orWhere('status', 'Terminated-FG')
                    ->orWhere('status', 'Terminated-DS')
                    ->orWhere('status', 'Terminated-NE')
                    ->orWhere('status', 'Terminated-FPD')
                    ->orWhere('status', 'Terminated-EOGS')
                    ->orWhere('status', 'Terminated-Others');
            })
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->get();

        $chartDataTerminated = Regional::barangaysApplicant($barangays, $userProfileTerminated);

        $numberOfEAP = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('type', 'Regular')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfMerit = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('type', 'Merit-Based')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfPAMANA = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('type', 'PDAF')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfPostStudy = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('level', 'Post Study')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfCollege = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('level', 'College')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfVocational = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('level', 'Vocational')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfHighSchool = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('level', 'High School')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfElementary = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('level', 'Elementary')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfMales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('gender', 'Male')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $numberOfFemales = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('gender', 'Female')
            ->where('status', 'Approved')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFSD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Terminated-FSD')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFG = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Terminated-FG')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedDS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Terminated-DS')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedNE = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Terminated-NE')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedFPD = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Terminated-FPD')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedEOGS = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Terminated-EOGS')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $terminatedOthers = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 6)'), '=', $cityId]])
            ->where('status', 'Terminated-Others')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('applications.created_at', [$dateFrom, $dateTo]);
                }
            })
            ->count();

        $totalAdminCost = AdminCost::whereNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', substr($cityId, 0, 4)]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('dateRcvd', [$dateFrom, $dateTo]);
                }
            })
            ->sum('amount');
        $totalGrantDisburse = AdminCost::whereNotNull('user_id')
            ->where([[\DB::raw('substr(province, 1, 4)'), '=', substr($cityId, 0, 4)]])
            ->where(function ($query) use ($dateFrom, $dateTo) {
                if (isset($dateFrom) && isset($dateTo)) {
                    $query->whereBetween('dateRcvd', [$dateFrom, $dateTo]);
                }
            })
            ->sum('amount');

        return [
            'type' => 'city',
            'zone' => $barangays,
            'chartDataAll' => $chartDataAll,
            'chartDataNew' => $chartDataNew,
            'chartDataApproved' => $chartDataApproved,
            'chartDataOnProcess' => $chartDataOnProcess,
            'chartDataGraduated' => $chartDataGraduated,
            'chartDataTerminated' => $chartDataTerminated,
            'numberOfEAP' => $numberOfEAP,
            'numberOfMerit' => $numberOfMerit,
            'numberOfPAMANA' => $numberOfPAMANA,
            'numberOfPostStudy' => $numberOfPostStudy,
            'numberOfCollege' => $numberOfCollege,
            'numberOfVocational' => $numberOfVocational,
            'numberOfHighSchool' => $numberOfHighSchool,
            'numberOfElementary' => $numberOfElementary,
            'numberOfMales' => $numberOfMales,
            'numberOfFemales' => $numberOfFemales,
            'terminatedFSD' => $terminatedFSD,
            'terminatedFG' => $terminatedFG,
            'terminatedDS' => $terminatedDS,
            'terminatedNE' => $terminatedNE,
            'terminatedFPD' => $terminatedFPD,
            'terminatedEOGS' => $terminatedEOGS,
            'terminatedOthers' => $terminatedOthers,
            'totalAdminCost' => $totalAdminCost,
            'totalGrantDisburse' => $totalGrantDisburse,
        ];
    }
}
