<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    public function wasAlreadyUsed(User $user = null){
        
        if(!$user){
            return false;
        }
        return Order::where('user_id', $user->id)
            ->where('coupon_id', $this->id)->exists();
    }

    public function price(Product $product){

        return $this->apply($product->price);
    }

    public function priceInCents(Product $product){

        return $this->apply($product->priceInCents());
    }

    public function apply($amount){
        
        return $amount * ((100 - $this->percent_off) / 100);
    }

    public function orders(){

        return $this->hasMany(Order::class);
    }
}
