<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
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
        return $this->hasMany(Garnish::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

   
}
