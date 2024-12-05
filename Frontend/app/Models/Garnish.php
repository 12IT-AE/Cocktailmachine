<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garnish extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description"
    ];

    public function recipes()
    {
        return $this->belongsToMany(DefaultRecipe::class, 'recipe_garnish');
    }
}
