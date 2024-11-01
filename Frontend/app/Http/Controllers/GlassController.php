<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Glass;

class GlassController extends Controller
{
    public function index()
    {
        $glasses = Glass::all();
        return view('glass.index', ['glasses' => $glasses]);
    }

    public function create()
    {
        return view('glass.create');
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'volume' => 'required|numeric'
        ]);
        if(!$validData){
            return back()->withErrors($validData)->withInput();
        }
        $validData['image'] = ""; //Temporary fix for image upload
        $glass = Glass::create($validData);
        return redirect()->route('glass.index');
    }

    public function show($id)
    {
        $glass = Glass::find($id);
        return view('glass.show', ['glass' => $glass]);
    }

    public function edit($id)
    {
        $glass = Glass::find($id);
        return view('glass.edit', ['glass' => $glass]);
    }

    public function update(Request $request, $id)
    {
        $validData = $request->validate([
            'name' => 'required',
        ]);
        if(!$validData){
            return back()->withErrors($validData)->withInput();
        }
        $glass = Glass::find($id);
        $glass->update($validData);
        return redirect()->route('glass.index');
    }

    public function destroy($id)
    {
        try {
            $glass = Glass::findOrFail($id);
            $glass->delete();
            return redirect()->route('glass.index')->with('success', 'Glas erfolgreich gelöscht.');
        } catch (QueryException $exception) {
            if ($exception->getCode() === '23000') {
            return redirect()->route('glass.index')->withErrors( 'Dieses Glas kann nicht gelöscht werden, da es in einem oder mehreren Rezepten verwendet wird.');
            }
            
            // Andere Ausnahmen behandeln
            return redirect()->route('glass.index')->withErrors('Ein unerwarteter Fehler ist aufgetreten.');
        }
    }
}
