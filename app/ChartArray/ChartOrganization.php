<?php

namespace App\ChartArray;

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

        return [
            'type' => 'region',
            'provinces' => $provinces,
            'chartDataAll' => $chartDataAll,
            'chartDataNew' => $chartDataNew,
            'chartDataApproved' => $chartDataApproved,
            'chartDataOnProcess' => $chartDataOnProcess,
            'chartDataGraduated' => $chartDataGraduated,
            'chartDataTerminated' => $chartDataTerminated,
        ];
    }

    static function provinceChartOne($provinceId, $dateFrom = '', $dateTo = '')
    {
        $cities = Psgc::where([[DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'City']])
            ->orwhere([[DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'Mun']])
            ->orwhere([[DB::raw('substr(code, 1, 4)'), '=', $provinceId], ['level', 'SubMun']])
            ->get();

        $userProfile = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])->get();
        $chartDataAll = Regional::citiesApplicant($cities, $userProfile);

        $userProfileNew = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'New')
            ->get();
        $chartDataNew = Regional::citiesApplicant($cities, $userProfileNew);

        $userProfileApproved = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Approved')
            ->get();
        $chartDataApproved = Regional::citiesApplicant($cities, $userProfileApproved);

        $userProfileOnProcess = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'On Process')
            ->get();

        $chartDataOnProcess = Regional::citiesApplicant($cities, $userProfileOnProcess);

        $userProfileGraduated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Graduated')
            ->get();
        $chartDataGraduated = Regional::citiesApplicant($cities, $userProfileGraduated);

        $userProfileTerminated = Application::join('profiles', 'profiles.user_id', '=', 'applications.user_id')
            ->where([[DB::raw('substr(profiles.psgCode, 1, 4)'), '=', $provinceId]])
            ->where('status', 'Terminated-FSD')
            ->orWhere('status', 'Terminated-FG')
            ->orWhere('status', 'Terminated-DS')
            ->orWhere('status', 'Terminated-NE')
            ->orWhere('status', 'Terminated-FPD')
            ->orWhere('status', 'Terminated-EOGS')
            ->orWhere('status', 'Terminated-Others')
            ->get();
        $chartDataTerminated = Regional::citiesApplicant($cities, $userProfileTerminated);

        return [
            'type' => 'province',
            'cities' => $cities,
            'chartDataAll' => $chartDataAll,
            'chartDataNew' => $chartDataNew,
            'chartDataApproved' => $chartDataApproved,
            'chartDataOnProcess' => $chartDataOnProcess,
            'chartDataGraduated' => $chartDataGraduated,
            'chartDataTerminated' => $chartDataTerminated,
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

        return [
            'type' => 'city',
            'barangays' => $barangays,
            'chartDataAll' => $chartDataAll,
            'chartDataNew' => $chartDataNew,
            'chartDataApproved' => $chartDataApproved,
            'chartDataOnProcess' => $chartDataOnProcess,
            'chartDataGraduated' => $chartDataGraduated,
            'chartDataTerminated' => $chartDataTerminated,
        ];
    }
}
