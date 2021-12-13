<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['images', 'likes', 'reviews', 'user', 'categories'];

     protected $withCount = ['likes', 'reviews'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function likes() {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function reviews() {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function categories() {
        return $this->morphMany(Category::class, 'categoryable');
    }

    public function usertickets() {
        return $this->hasMany(UserTicket::class);
    }
}
