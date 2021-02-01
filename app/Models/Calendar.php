<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Calendar extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'dateTimeStart',
        'dateTimeEnd',
        'color',
        'region',
    ];

    protected static $logFillable = true;

    protected static $logOnlyDirty = true;

    protected static $logName = 'Calendar';

    public function regionname(){
        return $this->hasOne(Psgc::class, 'code' ,'region');
    }
}
