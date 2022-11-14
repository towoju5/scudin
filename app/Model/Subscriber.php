<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Authenticatable
{
    use Notifiable;
    protected $table = 'subscribers';
    protected $guarded = [];

    public function shop()
    {
        return $this->hasOne(Shop::class, 'seller_id');
    }
    
    public function user($id)
    {
        return $this->belongsTo(User::class)->where(['id' => $id]);
    }

    //public function shop($id)
    //{
    //    return $this->belongsTo(Shop::class)->where(['seller_id' => $id]);
    //}

    public function plan($id)
    {
        return $this->belongsTo(Subscription::class)->where(['id' => $id]);
    }
}