<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';
    protected $primaryKey = 'dept_id';

    protected $fillable = [
        'dept_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
