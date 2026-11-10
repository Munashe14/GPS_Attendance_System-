<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'password',
        'role',
        'linked_id',
        'status',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_login' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'linked_id', 'student_id');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'lecturer_id', 'user_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'user_id', 'user_id');
    }

    public function isLecturer()
    {
        return $this->role === 'Lecturer';
    }

    public function isStudent()
    {
        return $this->role === 'Student';
    }

    public function isRegionalAdmin()
    {
        return $this->role === 'RegionalAdmin';
    }

    public function isSysAdmin()
    {
        return $this->role === 'SysAdmin';
    }

    public function dashboardRoute()
    {
        switch ($this->role) {
            case 'Lecturer':
                return 'lecturer.dashboard';
            case 'RegionalAdmin':
                return 'regional-admin.dashboard';
            case 'SysAdmin':
                return 'sys-admin.dashboard';
            case 'Student':
            case 'Other':
            default:
                return 'student.dashboard';
        }
    }
}