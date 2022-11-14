<?php

namespace App\Model;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    protected $casts = [
        'parent_id'  => 'integer',
        'position'   => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function childes()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(){
        return $this->hasMany(Category::class, 'parent_id');
    }
}
