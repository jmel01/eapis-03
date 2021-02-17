<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Education extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'education';

    protected $fillable = [
        'user_id',
        'school_name',
        'address',
        'level',
        'school_type',
        'year_graduated',
        'average_grade',
        'rank'
    ];

    static function insert($request){
        Education::where('user_id', $request->id)->delete();

        if(isset($request->schName)){
            foreach($request->schName as $key => $value){
                Education::create([
                    'user_id' => $request->id,
                    'school_name' => $request->schName[$key] ?? '',
                    'address' => $request->schAddress[$key] ?? '',
                    'level' => $request->schLevel[$key] ?? '',
                    'school_type' => $request->schType[$key] ?? '',
                    'year_graduated' => $request->schYear[$key] ?? '',
                    'average_grade' => $request->schAve[$key] ?? '',
                    'rank' => $request->schRank[$key] ?? ''
                ]);
            }
        }
    }
}
