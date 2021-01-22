<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'region',
        'acadYr',
        'applicationOpen',
        'applicationClosed',
    ];

    public function psgCode()
    {
        return $this->hasOne('App\Models\Psgc','code','region');
    }
}
