<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Psgc extends Model
{
    use HasFactory;

    protected $table = 'psgc';

    static function getProvince($code){
        $subtrOfProvince = Str::substr($code, 0, 4).'00000';
        $province = Psgc::where([['level','Prov'],['code', $subtrOfProvince]])->first();

        if(isset($province)){
            return $province->name;
        }
    }
}
