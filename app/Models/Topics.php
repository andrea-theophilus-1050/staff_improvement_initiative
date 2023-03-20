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
        'firstClosureDate',
        'finalClosureDate',
        'status',
    ];

    public function ideaPosts()
    {
        return $this->hasMany(IdeaPosts::class, 'topic_id', 'topic_id');
    }
}
