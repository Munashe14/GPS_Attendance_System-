<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionalCentre extends Model
{
    use HasFactory;

    protected $primaryKey = 'centre_id';

    protected $fillable = [
        'centre_name',
        'province',
        'latitude',
        'longitude',
        'radius_m',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'centre_id', 'centre_id');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'centre_id', 'centre_id');
    }
}
