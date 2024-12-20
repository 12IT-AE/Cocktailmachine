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
            'volume' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/glasses'), $imageName);
            $validData['image'] = 'images/glasses/' . $imageName;
        } else {
            $validData['image'] = "";
        }

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

            if ($glass->image && file_exists(public_path($glass->image))) {
                unlink(public_path($glass->image));
            }

            $glass->delete();
            return redirect()->route('glass.index')->with('success', 'Glass successfully deleted.');
        } catch (QueryException $exception) {
            if ($exception->getCode() === '23000') {
                return redirect()->route('glass.index')->withErrors('This glass cannot be deleted because it is used in one or more recipes.');
            }

            // Handle other exceptions
            return redirect()->route('glass.index')->withErrors('An unexpected error occurred.');
        }
    }
}
