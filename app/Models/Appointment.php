<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'appointment_id',
        'user_id',
        'service_id',
        'schedule_id',
        'status',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function service() {
        return $this->belongsTo(Service::class);
    }
    public function scheduleDate() {
        return $this->belongsTo(ScheduleDate::class, 'schedule_id');
    }
}
