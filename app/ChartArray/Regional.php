<?php

namespace App\ChartArray;

use App\Models\AdminCost;
use Illuminate\Support\Str;

class Regional
{

    static function regionsApplicant($regions, $userProfiles)
    {
        $array = array();

        foreach ($regions as $region) {
            $count = 0;

            foreach ($userProfiles as $userProfile) {
                if (Str::substr($region->code, 0, 2) == Str::substr($userProfile->psgCode, 0, 2)) {
                    $count++;
                }
            }

            array_push($array, array(
                'code' => $region->code,
                'count' => $count
            ));
        }

        return $array;
    }

    static function provincesApplicant($provinces, $userProfiles)
    {
        $array = array();

        foreach ($provinces as $province) {
            $count = 0;

            foreach ($userProfiles as $userProfile) {
                if (Str::substr($province->code, 0, 4) == Str::substr($userProfile->psgCode, 0, 4)) {
                    $count++;
                }
            }

            array_push($array, array(
                'code' => $province->code,
                'count' => $count
            ));
        }

        return $array;
    }

    static function citiesApplicant($cities, $userProfiles)
    {
        $array = array();

        foreach ($cities as $city) {
            $count = 0;

            foreach ($userProfiles as $userProfile) {
                if (Str::substr($city->code, 0, 6) == Str::substr($userProfile->psgCode, 0, 6)) {
                    $count++;
                }
            }

            array_push($array, array(
                'code' => $city->code,
                'count' => $count
            ));
        }

        return $array;
    }

    static function adminCost()
    {
        $regionAdminCostArray = array();

        for ($start = 1; $start <= 17; $start++) {
            $region = $start <= 9 ?  '0' . $start : $start;

            $totalAdminCost = AdminCost::whereNull('user_id')
                ->where([[\DB::raw('substr(province, 1, 2)'), '=', $region]])
                ->sum('amount');

            array_push($regionAdminCostArray, array(
                'region' => $region,
                'sum' => $totalAdminCost,
            ));
        }

        return $regionAdminCostArray;
    }

    static function assistance()
    {
        $regionAdminCostArray = array();

        for ($start = 1; $start <= 17; $start++) {
            $region = $start <= 9 ?  '0' . $start : $start;

            $totalAdminCost = AdminCost::whereNotNull('user_id')
                ->where([[\DB::raw('substr(province, 1, 2)'), '=', $region]])
                ->sum('amount');

            array_push($regionAdminCostArray, array(
                'region' => $region,
                'sum' => $totalAdminCost,
            ));
        }

        return $regionAdminCostArray;
    }
}
