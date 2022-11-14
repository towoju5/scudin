<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plans';
    
    public function user($id)
    {
        return $this->belongsTo(User::class)->where(['id' => $id]);
    }

    public function seller(){
        return $this->belongsTo(Seller::class,'seller_id');
    }
}
