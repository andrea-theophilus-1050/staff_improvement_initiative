<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\IdeaPosts;

class Topics extends Model
{
    use HasFactory;

    protected $table = 'topics';
    protected $primaryKey = 'topic_id';

    protected $fillable = [
        'topic_name',
        'topic_description',
        'category_id',
        'firstClosureDate',
        'finalClosureDate',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function ideaPosts()
    {
        return $this->hasMany(IdeaPosts::class, 'topic_id', 'topic_id');
    }
}
