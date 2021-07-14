<?php

namespace App\Models;

use App\Models\Lesson;
use App\Scopes\OrdinalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    public function lesson(){

        $this->belongsTo(Lesson::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrdinalScope());
    }

    public function hasDownload()
    {
        return in_array($this->id, [8, 9]);
    }
}
