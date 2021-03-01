<?php

namespace App\ChartArray;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Registered
{
    static function whereNotApplied($data)
    {
        $array = array();

        foreach ($data as $key => $value) {
            if (!isset($value->application)) {
                if (Auth::user()->hasAnyRole(['Admin', 'Executive Officer'])) {
                    array_push($array, $value);
                } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
                    if ($value->region == Auth::user()->region) {
                        array_push($array, $value);
                    }
                } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
                    if (isset($value->profile->psgCode) && substr($value->profile->psgCode, 0, 4) == substr(Auth::user()->profile->psgCode, 0, 4)) {
                        array_push($array, $value);
                    }
                }
            }
        }

        return $array;
    }

    static function whereProvince($data)
    {
        $array = array();

        foreach ($data as $key => $value) {
            if (isset($value->profile->psgCode) && substr($value->profile->psgCode, 0, 4) == substr(Auth::user()->profile->psgCode, 0, 4) || !isset($value->profile->psgCode)) {
                array_push($array, $value);
            }
        }

        return $array;
    }
}
