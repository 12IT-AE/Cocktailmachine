<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquid extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alternative_name',
        'image',
        'color',
        'alcoholic',
        'volume_percent',
    ];
    protected $casts = [
        'alcoholic' => 'boolean',
        'volume_percent' => 'float',
    ];
    public $displayName = "Flüssigkeit";

}
