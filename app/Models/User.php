<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity, SoftDeletes;

    protected static $logName = 'User';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Set default value
    protected $attributes = [
        'password' => '$2y$10$NxjAqWoKSrUhDhjD7SR3ROrhXgSmslSxgbPOLe1ct/2hNKbqbIkgi'
    ];

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function userRegion()
    {
        return $this->hasOne('App\Models\Psgc', 'code', 'region');
    }
    
    public function educations()
    {
        return $this->hasMany(Education::class, 'user_id', 'id');
    }

    public function siblings()
    {
        return $this->hasMany(Siblings::class, 'user_id', 'id');
    }

    public function application()
    {
        return $this->hasOne(Application::class, 'user_id', 'id');
    }
}
