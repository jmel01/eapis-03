<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Application extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'Application';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    
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

    // Set default value
    protected $attributes = [ 
        'status' => 'New' 
    ]; 

    public function applicant()
    {
        return $this->hasOne('App\Models\Profile','user_id','user_id');
    }

    public function education()
    {
        return $this->hasMany('App\Models\Education','user_id','user_id')->orderBy('year_graduated','DESC');
    }

    public function sibling()
    {
        return $this->hasMany('App\Models\Siblings','user_id','user_id')->orderBy('birthdate','DESC');
    }

    public function grant()
    {
        return $this->hasOne('App\Models\Grant','id','grant_id');
    }

    public function employment()
    {
        return $this->hasOne('App\Models\Employment','user_id','user_id');
    }
}
