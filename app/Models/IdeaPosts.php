<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topics;
use App\Models\Comments;

class IdeaPosts extends Model
{
    use HasFactory;

    protected $table = 'idea_posts';
    protected $primaryKey = 'post_id';

    protected $fillable = [
        'title',
        'content',
        'topic_id',
        'user_id',
        'status',
    ];

    public function topic()
    {
        return $this->belongsTo(Topics::class, 'topic_id', 'topic_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id', 'post_id');
    }
}
