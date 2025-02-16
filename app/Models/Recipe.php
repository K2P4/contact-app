<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /** @use HasFactory<\Database\Factories\RecipeFactory> */
    use HasFactory;


    protected $fillable = ['title', 'description', 'category_id', 'image'];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
