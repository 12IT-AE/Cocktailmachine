<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    
    public function index(){
        $recipe = new Recipe();
        $recipe = $recipe->find(3);
        return view('recipe/index', ['recipe' => $recipe]);
    
    }

    public function create(){
        $glasses = [];
        return view('recipe/create', ['glasses' => $glasses]);
    }

    public function show($id){
        $recipe = new Recipe();
        $recipe = $recipe->find($id);
        return view('recipe/show', ['recipe' => $recipe]);
    }

public function store(Request $request){
    $validatedData = $request->validate([
        'glass_id' => 'required|integer',
        'description' => 'required|string|max:255',
        'ice' => 'required|boolean',
        'image' => 'nullable|string|max:255',
    ]);
    if (!$validatedData) {
        return redirect()->route('recipes.create')->withErrors($validatedData)->withInput();
    }
    
    
    $validatedData['image'] = "";

    $recipe = Recipe::create($validatedData);

    return redirect()->route('recipes.show', ['id' => $recipe->id]);
}
}
