<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'notify_content',
        'status',
        'url',
        'type_notification',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
