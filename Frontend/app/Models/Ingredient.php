<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    public $displayName = "Zutat";

    protected $fillable = [
        'order_id',
        'liquid_id',
        'amount',
        'step'
    ];
    public function liquid(){
        return $this->belongsTo(Liquid::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
