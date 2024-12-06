<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultRecipe extends Model
{
    use HasFactory;
    protected $fillable = [
        'glass_id',
        'name',
        'description',
        'ice',
        'image',
    ];
    public $displayName = "Rezept";
    
    public function glass()
    {
        return $this->belongsTo(Glass::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function garnishes()
    {
        return $this->belongsToMany(Garnish::class, 'recipe_garnish', 'recipe_id', 'garnish_id');
    }
    public function ingredients()
    {
        return $this->hasMany(DefaultIngredient::class, 'recipe_id');
    }

   
}
