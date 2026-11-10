<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $primaryKey = 'module_id';

    protected $fillable = [
        'module_code',
        'module_name',
        'programme',
    ];

    public function sessions()
    {
        return $this->hasMany(Session::class, 'module_id', 'module_id');
    }
}
