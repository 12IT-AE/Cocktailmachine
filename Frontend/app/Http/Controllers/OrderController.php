<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Order, Garnish, DefaultRecipe, Glass, Liquid, Ingredient};

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index', compact('recipes'));
    }

    public function paginatedIndex(Request $request)
    {
        $recipes = DefaultRecipe::paginate(3);
        
        if ($request->ajax()) {
            return view('order.partials.recipes', compact('recipes'))->render();
        }

        return view('order.paginatedindex', compact('recipes'));
    }

    public function orderPi()
    {
        $recipes = DefaultRecipe::all();

        return view('order.orderPi', ['recipes' => $recipes]);
    }

    public function modal($id){
        $recipe = DefaultRecipe::find($id);
        return view('order.modal', ['recipe' => $recipe]);
    }

    public function createOrder(Request $request)
    {
        
    }
}