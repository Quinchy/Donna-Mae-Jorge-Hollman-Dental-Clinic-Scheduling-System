<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDate extends Model
{
    use HasFactory;
    protected $table = 'schedule_dates';
    protected $fillable = ['appointment_date', 'time_slots_id', 'booked'];
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'time_slots_id');
    }
}
