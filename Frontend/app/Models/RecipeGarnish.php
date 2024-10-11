<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeGarnish extends Model
{
    use HasFactory;
    protected $fillable = [
        "recipe_id",
        "garnish_id"
    ];
    
    public function recipe(){
        return $this->belongsTo(Recipe::class);
    }
    public function garnish(){
        return $this->belongsTo(Garnish::class);
    }
}
