<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psgc;
use Illuminate\Support\Str;

class PsgcController extends Controller
{
    public function getBrgy(Request $request)
    {
        $cityId = Str::substr($request->cityID, 0, 6);

        $barangays = Psgc::where([[\DB::raw('substr(code, 1, 6)'), '=' , $cityId],['level', 'Bgy']])
        ->get();
       
        return json_encode($barangays);
    }

    public function getCities(Request $request)
    {
        $provinceId = Str::substr($request->provinceID, 0, 4);
        
        $cities = Psgc::where([[\DB::raw('substr(code, 1, 4)'), '=' , $provinceId],['level', 'City']])
        ->orwhere([[\DB::raw('substr(code, 1, 4)'), '=' , $provinceId],['level', 'Mun']])
        ->orwhere([[\DB::raw('substr(code, 1, 4)'), '=' , $provinceId],['level', 'SubMun']])
        ->get();

        return json_encode($cities);
    }

    public function getProvinces(Request $request)
    {
        $regionId = Str::substr($request->regionID, 0, 2);

        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=' , $regionId],['level', 'Prov']])
        ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=' , $regionId],['level', 'Dist']])
        ->get();

        return json_encode($provinces);
    }
}
