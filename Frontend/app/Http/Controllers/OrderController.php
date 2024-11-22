<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Order,Garnish, Recipe, Glass, Liquid, Ingredient};

class OrderController extends Controller
{
    public function index(){
        $recipes = Recipe::all();
        $recipe = Recipe::first();
        return view('order.index', ['recipes' => $recipes], ['recipe' => $recipe]);
    }
}