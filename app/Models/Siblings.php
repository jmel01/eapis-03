<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Siblings extends Model
{
    use HasFactory;

    protected $table = 'siblings';

    protected $fillable = [
        'user_id',
        'name',
        'birthdate',
        'scholarship',
        'course_year_level',
        'present_status',
    ];

    static function insert($request){
        // Siblings::where('user_id', Auth::id())->delete();

        // if(isset($request->siblingName) &&  $request->siblingName[0] != null){
        //     foreach($request->siblingName as $key => $value){
        //         Siblings::create([
        //             'user_id' => Auth::id(),
        //             'name' => $request->siblingName[$key] ?? '',
        //             'birthdate' => $request->siblingBirthdate[$key] ?? '',
        //             'scholarship' => $request->siblingScholarship[$key] ?? '',
        //             'course_year_level' => $request->siblingCourse[$key] ?? '',
        //             'present_status' => $request->siblingStatus[$key] ?? '',
        //         ]);
        //     }
        // }
    }
}
