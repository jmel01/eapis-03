<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AdminCost extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'admin_costs';

    protected $fillable = [
        'application_id',
        'grant_id',
        'user_id',
        'dateRcvd',
        'payee',
        'particulars',
        'amount',
        'checkNo',
        'province',
    ];

    protected static $logFillable = true;

    protected static $logOnlyDirty = true;

    protected static $logName = 'Expenses';
    
    public function provname()
    {
        return $this->hasOne('App\Models\Psgc','code','province');
    }
}
