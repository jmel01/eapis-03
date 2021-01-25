<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lastName',
        'firstName',
        'middleName',
        'birthdate',
        'placeOfBirth',
        'gender',
        'civilStatus',
        'ethnoGroup',
        'contactNumber',
        'email',
        'address',
        'psgCode',
        'fatherLiving',
        'fatherName',
        'fatherAddress',
        'fatherOccupation',
        'fatherOffice',
        'fatherEducation',
        'fatherEthnoGroup',
        'fatherIncome',
        'motherLiving',
        'motherName',
        'motherAddress',
        'motherOccupation',
        'motherOffice',
        'motherEducation',
        'motherEthnoGroup',
        'motherIncome',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function psgcBrgy(){
        return $this->hasOne(Psgc::class, 'code' ,'psgCode');
    }

    public function psgcCities(){
        return $this->hasOne(Psgc::class, 'code' ,'psgCode')->where([[\DB::raw('substr(code, 1, 4)'), '=' , ],['level', 'City']]);
    }

    public function application(){
        return $this->hasOne(Profile::class, 'user_id' , 'user_id');
    }
    
}
