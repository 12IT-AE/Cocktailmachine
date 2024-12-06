<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultIngredient extends Model
{
    use HasFactory;

    public $displayName = "Zutat";

    protected $fillable = [
        'recipe_id',
        'liquid_id',
        'amount',
        'step'
    ];
    public function liquid(){
        return $this->belongsTo(Liquid::class);
    }
    public function recipe(){
        return $this->belongsTo(DefaultRecipe::class);
    }
}
