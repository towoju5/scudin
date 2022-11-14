<?php

namespace App\Model;

use App\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable
{
    use Notifiable;

    public function shop()
    {
        return $this->hasOne(Shop::class, 'seller_id');
    }

    public function shops()
    {
        return $this->hasMany(Shop::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(OrderDetail::class, 'seller_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'user_id')->where(['added_by'=>'seller']);
    }

    public function wallet()
    {
        return $this->hasOne(SellerWallet::class);
    }

    public function plan()
    {
        return $this->belongsTo(Subscription::class, 'plan_id');
    }
}
