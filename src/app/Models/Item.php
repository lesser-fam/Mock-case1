<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Condition;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Favorite;
use App\Models\Comment;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'brand', 'price', 'detail', 'condition_id', 'seller_id','image' ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
