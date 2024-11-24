<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Order,Garnish, Recipe, Glass, Liquid, Ingredient};

class OrderController extends Controller
{
    public function index(){
        $recipes = Recipe::all();
        // $recipe = Recipe::skip(1)->first();
        return view('order.index', ['recipes' => $recipes]);
    }

    // public function getData($id)
    // {
    //     $recipe = new Recipe();
    //     $recipe = $recipe->find($id);
    //     return ['recipe' => $recipe];
    // }
}