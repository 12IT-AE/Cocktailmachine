<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Models\{Order, Garnish, DefaultRecipe, Recipe, Glass, Liquid, Ingredient};

class OrderController extends Controller
{
    public function index()
    {
        $recipes = DefaultRecipe::all();
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

    public function store(Request $request)
    {
        $defaultRecipe = DefaultRecipe::find($request->input('recipe_id'));
        
        // Create a new recipe based on the default recipe
        $recipe = new Recipe();
        $recipe->name = $defaultRecipe->name;
        $recipe->description = $defaultRecipe->description;
        $recipe->glass_id = $defaultRecipe->glass_id;
        $recipe->ice = $defaultRecipe->ice;
        $recipe->image = $defaultRecipe->image;
        $recipe->save();

        // Create custom ingredients for the recipe
        $ingredients = json_decode($request->input('ingredients'), true);
        foreach ($ingredients as $ingredientData) {
            $ingredient = new Ingredient();
            $ingredient->recipe_id = $recipe->id;
            $ingredient->liquid_id = $ingredientData['liquid_id'];
            $ingredient->step = $ingredientData['step'];
            $ingredient->amount = intval($ingredientData['amount']);
            $ingredient->save();
        }

        $order = new Order();
        $order->recipe_id = $recipe->id;
        $order->status = OrderStatus::PENDING;
        $order->save();

        return redirect()->route('order.index')->with('success', 'Order created successfully.');
    }
}