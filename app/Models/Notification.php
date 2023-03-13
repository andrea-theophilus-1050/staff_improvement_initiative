<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
