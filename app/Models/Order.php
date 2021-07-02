<?php

namespace App\Models;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'product_id', 
        'stripe_id', 
        'total'
    ];

    protected $hidden = [
        'stripe_id'
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function coupon(){

        return $this->belongsTo(Coupon::class);
    }

    public function product(){
        
        return $this->belongsTo(Product::class);
    }

    public function totalInCents()
    {
        return (int)($this->total * 100);
    }

    public function applyCoupon(\App\Coupon $coupon)
    {
        $this->total -= $this->total * ($coupon->percent_off / 100);

        $this->coupon()->associate($coupon);
    }
}

