<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasManyThrough(Photo::class, Post::class);
    }

    public function getShowTimeAttribute()
    {
        return "<span class='small'>
                    <i class='fas fa-calendar-alt'></i>
                    ".$this->created_at->format('d M Y')."
                </span><br>
                <span class='small'>
                    <i class='fas fa-clock'></i>
                    ".$this->created_at->format('H : i a')."
                </span>";
    }
}
