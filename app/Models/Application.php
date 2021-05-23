<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

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
        'date_process',
        'date_approved',
        'date_graduated',
        'date_terminated',
        'date_denied',
    ];

    // Set default value
    protected $attributes = [
        'status' => 'New'
    ];

    public function applicant()
    {
        return $this->hasOne('App\Models\Profile', 'user_id', 'user_id');
    }

    public function education()
    {
        return $this->hasMany('App\Models\Education', 'user_id', 'user_id')->orderBy('year_graduated', 'DESC');
    }

    public function sibling()
    {
        return $this->hasMany('App\Models\Siblings', 'user_id', 'user_id')->orderBy('birthdate', 'ASC');
    }

    public function grant()
    {
        return $this->hasOne('App\Models\Grant', 'id', 'grant_id');
    }

    public function employment()
    {
        return $this->hasOne('App\Models\Employment', 'user_id', 'user_id');
    }

    static function getCountGrantApplication($id)
    {
        $countGrantNewApplication = Application::where('grant_id', $id)->count();

        return $countGrantNewApplication;
    }

    static function getCountGrantNewApplication($id)
    {
        $countGrantNewApplication = Application::where('grant_id', $id)
            ->where('status', 'New')
            ->count();

        return $countGrantNewApplication;
    }

    static function getCountGrantOnProcessApplication($id)
    {
        $countGrantOnProcessApplication = Application::where('grant_id', $id)
            ->where('status', 'On Process')
            ->count();

        return $countGrantOnProcessApplication;
    }

    static function getCountGrantApprovedApplication($id)
    {
        $countGrantApprovedApplication = Application::where('grant_id', $id)
            ->where('status', 'Approved')
            ->count();

        return $countGrantApprovedApplication;
    }

    static function getCountGrantDeniedApplication($id)
    {
        $countGrantDeniedApplication = Application::where('grant_id', $id)
            ->where('status', 'Graduated')
            ->count();

        return $countGrantDeniedApplication;
    }

    static function getCountGrantGraduatedApplication($id)
    {
        $countGrantGraduatedApplication = Application::where('grant_id', $id)
            ->where('status', 'Graduated')
            ->count();

        return $countGrantGraduatedApplication;
    }

    static function getCountGrantTerminatedApplication($id)
    {
        $countGrantTerminatedApplication = Application::where('grant_id', $id)
            ->where('status', '!=', 'New')
            ->where('status', '!=', 'Denied')
            ->where('status', '!=', 'Approved')
            ->where('status', '!=', 'On Process')
            ->where('status', '!=', 'Graduated')
            ->whereNotNull('status')
            ->count();

        return $countGrantTerminatedApplication;
    }
}
