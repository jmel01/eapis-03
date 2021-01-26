<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Psgc extends Model
{
    use HasFactory;

    protected $table = 'psgc';

    static function getRegion($code){
        $subtrOfRegion = Str::substr($code, 0, 2).'0000000';
        $region = Psgc::where([['level','Reg'],['code', $subtrOfRegion]])->first();

        if(isset($region)){
            return $region->name;
        }
    }

    static function getProvince($code){
        $subtrOfProvince = Str::substr($code, 0, 4).'00000';
        $province = Psgc::where([['level','Prov'],['code', $subtrOfProvince]])->first();

        if(isset($province)){
            return $province->name;
        }
    }

    public function profile(){
        return $this->hasMany(Profile::class, 'psgCode' , 'code');
    }
    
}
