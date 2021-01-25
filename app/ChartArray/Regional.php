<?php

namespace App\ChartArray;

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
}
