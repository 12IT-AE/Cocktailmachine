<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;    
use App\Models\Container;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredient.index', ['ingredients' => $ingredients]);
    }

    public function create()
    {
        $containers = Container::all();
        return view('ingredient.create', ['containers' => $containers]);
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'container_id' => 'required',
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
        ]);

        if(!$validData){
            return back()->withErrors($validData)->withInput();
        }

        $ingredient = Ingredient::create($validData);
        return redirect()->route('ingredient.index');
    }

    public function show($id)
    {
        // Code to display a specific ingredient
    }

    public function edit($id)
    {
        // Code to show form to edit an ingredient
    }

    public function update(Request $request, $id)
    {
        // Code to update a specific ingredient
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::find($id);
        $ingredient->delete();
        return redirect()->route('ingredient.index');
    }
}
