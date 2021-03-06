<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'grant_id',
        'user_id',
        'type',
        'level',
        'school',
        'course',
        'contribution',
        'plans',
        'status',
        'remarks',
    ];

    public function applicant()
    {
        return $this->hasOne('App\Models\Profile','user_id','user_id');
    }

    public function grant()
    {
        return $this->hasOne('App\Models\Grant','id','grant_id');
    }
}
