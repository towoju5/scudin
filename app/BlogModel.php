<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'blog';
    protected $guarded = [];
    
    public function author()
    {
        return $this->belongsTo(Admin::class, 'author');
    }
}
