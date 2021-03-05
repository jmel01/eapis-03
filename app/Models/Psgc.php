<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Psgc extends Model
{
    use HasFactory;

    protected $table = 'psgc';

    static function getRegion($code)
    {
        $subtrOfRegion = Str::substr($code, 0, 2) . '0000000';
        $region = Psgc::where([['level', 'Reg'], ['code', $subtrOfRegion]])->first();

        if (isset($region)) {
            return $region->name;
        }
    }

    static function getProvince($code)
    {
        $subtrOfProvince = Str::substr($code, 0, 4) . '00000';
        $province = Psgc::where([['level', 'Prov'], ['code', $subtrOfProvince]])
            ->orWhere([['level', 'Dist'], ['code', $subtrOfProvince]])
            ->orWhere([['level', ''], ['code', $subtrOfProvince]])
            ->first();

        if (isset($province)) {
            return $province->name;
        }
    }

    static function getCity($code)
    {
        $subtrOfCity = Str::substr($code, 0, 6) . '000';
        $city = Psgc::where([['level', 'City'], ['code', $subtrOfCity]])
            ->orWhere([['level', 'Mun'], ['code', $subtrOfCity]])
            ->orWhere([['level', 'SubMun'], ['code', $subtrOfCity]])
            ->first();

        if (isset($city)) {
            return $city->name;
        }
    }

    static function getBarangay($code)
    {
        $barangay = Psgc::where([['level', 'Bgy'], ['code', $code]])->first();

        if (isset($barangay)) {
            return $barangay->name;
        }
    }

    public function profile()
    {
        return $this->hasMany(Profile::class, 'psgCode', 'code');
    }
}
