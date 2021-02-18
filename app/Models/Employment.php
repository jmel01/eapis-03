<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    use HasFactory;

    protected static $logName = 'Employment';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'user_id',
        'yearEmployed',
        'employerType',
        'position',
        'employerName',
        'employerAddress',
    ];
}
