<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Document extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'Document';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'grantID',
        'requirementID',
        'user_id',
        'filename',
        'filepath',
        'schoolYear',
    ];

    public function grantDetails()
    {
        return $this->hasOne('App\Models\Grant','id','grantID');
    }

    public function requirementDetails()
    {
        return $this->hasOne('App\Models\Requirement','id','requirementID');
    }
}
