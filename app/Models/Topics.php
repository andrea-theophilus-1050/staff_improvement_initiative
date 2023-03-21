<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IdeaPosts;
use App\Models\TopicDeadline;

class Topics extends Model
{
    use HasFactory;

    protected $table = 'topics';
    protected $primaryKey = 'topic_id';

    protected $fillable = [
        'topic_name',
        'topic_description',
        'deadline_id',
    ];

    public function ideaPosts()
    {
        return $this->hasMany(IdeaPosts::class, 'topic_id', 'topic_id');
    }

    public function topicDeadline()
    {
        return $this->belongsTo(TopicDeadline::class, 'deadline_id', 'deadline_id');
    }
}
