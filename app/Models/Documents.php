<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IdeaPosts;

class Documents extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $primaryKey = 'doc_id';

    protected $fillable = [
        'doc_name',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(IdeaPosts::class, 'post_id', 'post_id');
    }
}
