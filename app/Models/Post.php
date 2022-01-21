<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // accessor
//    public function getTitleAttribute($value)
//    {
//        return Str::words($value, 10);
//    }

    public function getShortTitleAttribute()
    {
        return Str::words($this->title, 10);
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

    // mutator
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    // event
//    protected static function booted()
//    {
//        static::created(function () {
//            logger("hello hello hi");
//        });
//    }

    // query scope -> local scope
    public function scopeSearch($query)
    {
        if (isset(request()->search)) {
            $search = request()->search;
            return $query->where("title", "LIKE", "%$search%")->orWhere("description", "LIKE", "%$search%");
        }
    }
}
