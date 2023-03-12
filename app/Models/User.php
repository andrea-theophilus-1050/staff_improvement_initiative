<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Department;
use App\Models\Role;
use App\Models\PostsLikeDislike;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'fullName',
        'email',
        'password',
        'dept_id',
        'role_id',
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
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function like_dislike()
    {
        return $this->hasMany(PostsLikeDislike::class, 'user_id');
    }



    // protected  function role(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) => [
    //             1 => 'Admin',
    //             2 => 'QA Leaders',
    //             3 => 'QA Coordinator',
    //             4 => 'Staff',
    //         ][$value],
    //     );
    // }
}
