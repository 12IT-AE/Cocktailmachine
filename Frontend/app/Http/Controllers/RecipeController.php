<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{

    public function index()
    {
        $recipes = Recipe::all();

        return view('recipe.index', ['recipes' => $recipes]);
    }

    public function create()
    {
        $glasses = [];
        return view('recipe.create', ['glasses' => $glasses]);
    }

    public function show($id)
    {
        $recipe = new Recipe();
        $recipe = $recipe->find($id);
        return view('recipe/show', ['recipe' => $recipe]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'glass_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'ice' => 'required|boolean',
            'image' => 'nullable|string|max:255',
        ]);
        if (!$validatedData) {
            return redirect()->route('recipe.create')->withErrors($validatedData)->withInput();
        }


        $validatedData['image'] = "";

        $recipe = Recipe::create($validatedData);

        return redirect()->route('recipe.show', ['id' => $recipe->id]);
    }
    public function edit($id)
    {
        $recipe = new Recipe();
        $recipe = $recipe->find($id);
        return view('recipe.edit', ['recipe' => $recipe]);
    }
    public function update(Request $request, $id) {}
    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();
        return redirect()->route('recipe.index');
    }
}
