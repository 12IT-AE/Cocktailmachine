<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pump extends Model
{
    use HasFactory;
    protected $fillable = [
        'container_id',
    ];
    public $displayName = "Pumpe";

    public function container(){
        return $this->belongsTo(Container::class);
    }
}
