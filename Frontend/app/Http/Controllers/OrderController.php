<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Order,Garnish, Recipe, Glass, Liquid, Ingredient};

class OrderController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();

        return view('order.index', ['recipes' => $recipes]);
    }

    public function modal($id){
        $recipe = Recipe::find($id);
        return view('order.modal', ['recipe' => $recipe]);
    }
}