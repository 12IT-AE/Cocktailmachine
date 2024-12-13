<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Garnish, DefaultRecipe, Glass, Liquid, Ingredient};
class RecipeController extends Controller
{

    public function index()
    {
        $recipes = DefaultRecipe::all();
        

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
        $recipe = new DefaultRecipe();
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ]);
    if (!$validatedRecipe) {
        return redirect()->route('recipe.create')->withErrors($validatedRecipe)->withInput();
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/recipes'), $imageName);
        $validatedRecipe['image'] = 'images/recipes/' . $imageName;
    } else {
        $validatedRecipe['image'] = ""; // Default value if no image is uploaded
    }

    if (!isset($request->liquids, $request->amounts, $request->orders)) {
        return redirect()->route('recipe.create')->withErrors('Bitte wählen Sie eine Flüssigkeit, Menge und Reihenfolge für das Rezept aus')->withInput();
    }
    $liquids = $request->liquids;
    $amounts = $request->amounts;
    $orders = $request->orders;

    $recipe = DefaultRecipe::create($validatedRecipe);
    $liquidAmountOrder = array_map(null, $liquids, $amounts, $orders);

    foreach ($liquidAmountOrder as [$liquid, $amount, $order]) {
        if ($liquid == 0 || $amount == 0) {
            $recipe->delete();
            return redirect()->route('recipe.create')->withErrors('Bitte wählen Sie eine Flüssigkeit und Menge für das Rezept aus')->withInput();
        }
        Ingredient::create([
            'recipe_id' => $recipe->id,
            'liquid_id' => $liquid,
            'amount' => $amount,
            'step' => $order - 1 // Convert 1-indexed to 0-indexed
        ]);
    }

    if (isset($request->garnishes)) {
        foreach ($request->garnishes as $garnish) {
            $recipe->garnishes()->attach($garnish);
        }
    }

    return redirect()->route('recipe.index')->with('success', 'Rezept erfolgreich erstellt');
}

public function edit($id)
{
    $recipe = DefaultRecipe::findOrFail($id);
    $glasses = Glass::all();
    $liquids = Liquid::all();
    $garnishes = Garnish::all();

    return view('recipe.edit', compact('recipe', 'glasses', 'liquids', 'garnishes'));
}
    public function update(Request $request, $id)
    {
        $validatedRecipe = $request->validate([
            'glass_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'ice' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
    
        $recipe = DefaultRecipe::findOrFail($id);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image
            if ($recipe->image && file_exists(public_path($recipe->image))) {
                unlink(public_path($recipe->image));
            }
    
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/recipes'), $imageName);
            $validatedRecipe['image'] = 'images/recipes/' . $imageName;
        }
    
        $recipe->update($validatedRecipe);
    
        // Update ingredients
        $recipe->ingredients()->delete();
        if (isset($request->liquids, $request->amounts, $request->orders)) {
            $liquids = $request->liquids;
            $amounts = $request->amounts;
            $orders = $request->orders;
    
            $liquidAmountOrder = array_map(null, $liquids, $amounts, $orders);
    
            foreach ($liquidAmountOrder as [$liquid, $amount, $order]) {
                if ($liquid != 0 && $amount != 0) {
                    Ingredient::create([
                        'recipe_id' => $recipe->id,
                        'liquid_id' => $liquid,
                        'amount' => $amount,
                        'step' => $order - 1 // Convert 1-indexed to 0-indexed
                    ]);
                }
            }
        }
    
        // Update garnishes
        $recipe->garnishes()->detach();
        if (isset($request->garnishes)) {
            foreach ($request->garnishes as $garnish) {
                $recipe->garnishes()->attach($garnish);
            }
        }
    
        return redirect()->route('recipe.index')->with('success', 'DefaultRecipe successfully updated.');
    }
    public function destroy($id)
    {
        $recipe = DefaultRecipe::find($id);
        $recipe->delete();
        return redirect()->route('recipe.index');
    }


}
