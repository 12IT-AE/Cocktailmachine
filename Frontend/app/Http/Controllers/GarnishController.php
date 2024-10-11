<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garnish;

class GarnishController extends Controller
{
    public function index(){
        $garnishes = Garnish::all();
        return view('garnish.index', ['garnishes' => $garnishes]);
    }

    public function create(){
        return view('garnish.create');
    }

    public function show($id){
        $garnish = Garnish::find($id);
        return view('garnish.show', ['garnish' => $garnish]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        if(!$validatedData){
            return redirect()->route('garnish.create')->withErrors($validatedData)->withInput();
        }
        
        $garnish = Garnish::create($validatedData);

        return redirect()->route('garnish.show', ['garnish' => $garnish->id]);
    }

    public function destroy($id){
        $garnish = Garnish::find($id);
        $garnish->delete();
        return redirect()->route('garnish.index');
    }

    public function edit($id){
        $garnish = Garnish::find($id);
        return view('garnish.edit', ['garnish' => $garnish]);
    }

    public function update(Request $request, $id){
        $garnish = Garnish::find($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        if(!$validatedData){
            return redirect()->route('garnish.edit', ['garnish' => $garnish->id])->withErrors($validatedData)->withInput();
        }
        
        $garnish->update($validatedData);

        return redirect()->route('garnish.show', ['garnish' => $garnish->id]);
    }
}
