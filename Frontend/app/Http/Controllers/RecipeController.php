<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Garnish, Recipe, Glass, Liquid, Ingredient};
class RecipeController extends Controller
{

    public function index()
    {
        $recipes = Recipe::all();

        return view('recipe.index', ['recipes' => $recipes]);
    }

    public function create()
    {
        $glasses = Glass::all();
        $liquids = Liquid::all();
        $garnishes = Garnish::all();
        return view('recipe.create', ['glasses' => $glasses, 'liquids'=> $liquids, 'garnishes' => $garnishes]);
    }

    public function show($id)
    {
        $recipe = new Recipe();
        $recipe = $recipe->find($id);
        return view('recipe/show', ['recipe' => $recipe]);
    }

    public function store(Request $request)
    {
        $validatedRecipe = $request->validate([
            'glass_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'ice' => 'required|boolean',
            'image' => 'nullable|string|max:255',
        ]);
        if (!$validatedRecipe) {
            return redirect()->route('recipe.create')->withErrors($validatedRecipe)->withInput();
        }

        $validatedRecipe['image'] = ""; //Temporary fix for image upload
        if(!isset(request()->liquids, request()->amounts)){
            return redirect()->route('recipe.create')->withErrors('Bitte wählen Sie eine Flüssigkeit und Menge für das Rezept aus')->withInput();
        }
        $liquids = $request->liquids;
        $amounts = $request->amounts;
        
        $recipe = Recipe::create($validatedRecipe);
        $liquidAmount = array_combine($liquids, $amounts);

        foreach($liquidAmount as $liquid => $amount) {
            if ($liquid == 0 || $amount == 0) {
                $recipe->delete();
                return redirect()->route('recipe.create')->withErrors('Bitte wählen Sie eine Flüssigkeit und Menge für das Rezept aus')->withInput();
            }
            Ingredient::create([
                'recipe_id' => $recipe->id,
                'liquid_id' => $liquid,
                'amount' => $amount,
                'step' => 0
            ]);
        }
        if (isset($request->garnishes)) {
            $garnishes = $request->garnishes;
            foreach ($garnishes as $garnish) {
                $recipe->garnishes()->attach($garnish);
            }
        }

        return redirect()->route('recipe.show', ['recipe' => $recipe->id]);
    }
    public function edit($id)
    {
        $recipe = new Recipe();
        $allIngredients = Liquid::all();
        $glasses = Glass::all();
        $recipe = $recipe->find($id);
        return view('recipe.edit', ['recipe' => $recipe, 'allIngredients'=> $allIngredients, 'glasses'=> $glasses]);
    }
    public function update(Request $request, $id) {
        $recipe = Recipe::find($id);
        $validatedRecipe = $request->validate([
            'glass_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'ice' => 'required|boolean',
            'image' => 'nullable|string|max:255',
        ]);
        if (!$validatedRecipe) {
            return redirect()->route('recipe.edit', ['recipe' => $recipe->id])->withErrors($validatedRecipe)->withInput();
        }

        

        $recipe->update($validatedRecipe);
        return redirect()->route('recipe.show', ['recipe' => $recipe->id]);
    }
    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();
        return redirect()->route('recipe.index');
    }


}
