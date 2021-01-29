<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        if( session('audit_trail_id') == '' ){
            $auditTrail = AuditTrail::create([
                'user_id' => Auth::id()
            ]);

            session(['audit_trail_id' => $auditTrail->id]);
        }

        AuditEvent::create([
            'audit_trail_id' => session('audit_trail_id'),
            'event_type' => $event,
        ]);
    }
}
