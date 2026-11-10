<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $primaryKey = 'session_id';

    protected $fillable = [
        'module_id',
        'centre_id',
        'lecturer_id',
        'session_date',
        'start_time',
        'qr_token',
        'qr_expires_at',
        'status',
    ];

    protected $casts = [
        'qr_expires_at' => 'datetime',
        'session_date' => 'date',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'module_id');
    }

    public function centre()
    {
        return $this->belongsTo(RegionalCentre::class, 'centre_id', 'centre_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id', 'user_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'session_id', 'session_id');
    }
}
