<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Requirement extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'Requirement';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'id',
        'description',
    ];
   
}
