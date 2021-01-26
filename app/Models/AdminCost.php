<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminCost extends Model
{
    use HasFactory;

    protected $table = 'admin_costs';

    protected $fillable = [
        'grant_id',
        'user_id',
        'dateRcvd',
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
