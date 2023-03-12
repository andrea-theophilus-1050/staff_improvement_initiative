<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topics;
use App\Models\Comments;
use App\Models\PostsLikeDislike;
use App\Models\User;
use App\Models\Documents;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id', 'post_id');
    }

    public function like_dislike()
    {
        return $this->hasMany(PostsLikeDislike::class, 'post_id', 'post_id');
    }

    public function documents()
    {
        return $this->hasMany(Documents::class, 'post_id', 'post_id');
    }
}
