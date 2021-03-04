<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Siblings extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'Sibling';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    protected $table = 'siblings';

    protected $fillable = [
        'user_id',
        'name',
        'birthdate',
        'civilStatus',
        'scholarship',
        'course_year_level',
        'present_status',
    ];

    static function insert($request)
    {
        Siblings::where('user_id', $request->id)->delete();

        if (isset($request->siblingName) &&  $request->siblingName[0] != null) {
            foreach ($request->siblingName as $key => $value) {
                Siblings::create([
                    'user_id' => $request->id,
                    'name' => $request->siblingName[$key] ?? '',
                    'birthdate' => $request->siblingBirthdate[$key] ?? '',
                    'civilStatus' => $request->siblingCivilStatus[$key] ?? '',
                    'scholarship' => $request->siblingScholarship[$key] ?? '',
                    'course_year_level' => $request->siblingCourse[$key] ?? '',
                    'present_status' => $request->siblingStatus[$key] ?? '',
                ]);
            }
        }
    }
}
