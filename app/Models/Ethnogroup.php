<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Ethnogroup extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'region',
        'ipgroup',
    ];

    static function getEthno($code){
        $ethno = Ethnogroup::where('id', $code)->first();

        if(isset($ethno)){
            return $ethno->ipgroup;
        }
    }
    
}
