<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;
    protected $fillable = [
        "liquid_id",
        "volume",
        "current_volume"
    ];

    public function liquid(){
        return $this->belongsTo(Liquid::class);
    }
}
