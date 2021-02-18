<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Grant extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'Grant';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

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
