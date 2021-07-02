<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    const STARTER = 1;
    const FULL = 2;

    public static function paid()
    {
        return self::whereIn('id', [self::STARTER, self::FULL])
            ->orderBy('ordinal', 'asc')
            ->get();
    }

    public function priceInCents()
    {
        return $this->price * 100;
    }

    public function lessons(){

        return $this->hasMany(Lesson::class);
    }

    public function orders(){

        return $this->hasMany(Order::class);
    }
}
