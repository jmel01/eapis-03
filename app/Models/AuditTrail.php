<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $table = 'audit_trail';

    protected $fillable = [
        'user_id',
    ];


    public function auditEvent(){
        return $this->hasMany(AuditEvent::class, 'audit_trail_id','id');
    }
}
