<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'pin',
        'full_name',
        'programme',
        'zou_email',
        'phone',
        'centre_id',
        'status',
    ];

    public function centre()
    {
        return $this->belongsTo(RegionalCentre::class, 'centre_id', 'centre_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'student_id', 'student_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'linked_id', 'student_id');
    }
}
