<?php

use App\Models\Recipe;
use Illuminate\Support\Facades\Route;




Route::resource('recipes', App\Http\Controllers\RecipeController::class);