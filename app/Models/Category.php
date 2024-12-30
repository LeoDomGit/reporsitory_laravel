<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $fillable = ['name', 'slug', 'status'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            // If the name is set, create a slug from it
            if ($category->name && !$category->slug) {
                $slug = Str::slug($category->name);
                // Ensure the slug is unique
                $count = static::where('slug', 'like', $slug . '%')->count();
                $category->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }
}
