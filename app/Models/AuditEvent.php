<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditEvent extends Model
{
    use HasFactory;

    protected $table = 'audit_event';

    protected $fillable = [
        'audit_trail_id',
        'event_type'
    ];

    public function auditTrail(){
        return $this->hasOne(AuditTrail::class,'id','audit_trail_id');
    }

    static function insert($event){
        AuditEvent::create([
            'audit_trail_id' => session('audit_trail_id'),
            'event_type' => $event,
        ]);
    }
}
