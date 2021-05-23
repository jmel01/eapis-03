<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AdminCost extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'Expenses';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    protected $table = 'admin_costs';

    protected $fillable = [
        'application_id',
        'grant_id',
        'user_id',
        'dateRcvd',
        'schoolYear',
        'semester',
        'payee',
        'particulars',
        'amount',
        'checkNo',
        'province',
    ];
    
    public function provname()
    {
        return $this->hasOne('App\Models\Psgc','code','province');
    }
}
