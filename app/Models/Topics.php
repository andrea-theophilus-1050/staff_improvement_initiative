<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

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
        'finalClosureDate'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
