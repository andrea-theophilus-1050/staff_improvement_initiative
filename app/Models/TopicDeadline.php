<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topics;

class TopicDeadline extends Model
{
    use HasFactory;

    protected $table = 'topic_deadline';
    protected $primaryKey = 'deadline_id';

    protected $fillable = [
        'firstClosureDate',
        'finalClosureDate',
    ];

    public function topics()
    {
        return $this->hasMany(Topics::class, 'deadline_id', 'deadline_id');
    }
}
