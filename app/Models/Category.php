<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topics;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'description'
    ];

    public function topics()
    {
        return $this->hasMany(Topics::class, 'category_id', 'category_id');
    }
}
