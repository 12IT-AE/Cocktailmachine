<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Liquid;

class LiquidController extends Controller
{
    public function index(){
        $liquids = Liquid::all();
        return view('liquid.index', ['liquids' => $liquids]);
    }

    public function create(){
        return view('liquid.create');
    }

    public function show($id){
        $liquid = Liquid::find($id);
        return view('liquid.show', ['liquid' => $liquid]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'alternative_name' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'color' => 'required|string|max:255',
            'alcoholic' => 'required|boolean',
            'volume_percent' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        if(!$validatedData){
            return redirect()->route('liquid.create')->withErrors($validatedData)->withInput();
        }


        $validatedData['alcoholic'] = (bool) $validatedData['alcoholic'];
        
        $liquid = Liquid::create($validatedData);



        return redirect()->route('liquid.show', ['liquid' => $liquid->id]);
    }
    public function destroy($id){
        $liquid = Liquid::find($id);
        $liquid->delete();
        return redirect()->route('liquid.index');
    }
    public function edit($id){
        $liquid = Liquid::find($id);
        return view('liquid/edit', ['liquid' => $liquid]);
    }
    public function update(Request $request, $id){
        $liquid = Liquid::find($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'alternative_name' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'color' => 'required|string|max:255',
            'alcoholic' => 'required|boolean',
            'volume_percent' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        if(!$validatedData){
            return redirect()->route('liquid.edit', ['liquid' => $liquid->id])->withErrors($validatedData)->withInput();
        }

        $validatedData['alcoholic'] = (bool) $validatedData['alcoholic'];
        
        $liquid->update($validatedData);

        return redirect()->route('liquid.show', ['liquid' => $liquid->id]);
    }
}
