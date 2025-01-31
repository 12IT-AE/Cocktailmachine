<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Container;
use App\Models\Liquid;

class ContainerController extends Controller
{
    public function index()
    {
        $containers = Container::all();
        return view("container.index", compact("containers"));
    }

    public function create()
    {
        $liquids = Liquid::all();

        return view("container.create", compact("liquids"));
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            "liquid_id" => "required",
            "volume" => "required|numeric",
        ]);
        if (!$validData) {
            return back()->withErrors($validData)->withInput();
        }
        $validData["current_volume"] = $validData["volume"];
        $container = Container::create($validData);
        return redirect()->route('container.show', ['container' => $container->id]);
    }

    public function show($id)
    {
        $container = Container::find($id);
        return view('container.show', compact('container'));
    }

    public function edit($id)
    {
        // Code to show form for editing a container
    }

    public function update(Request $request, $id)
    {
        $container = Container::findOrFail($id);

        // If "volume" is provided, update it
        if ($request->has('volume')) {
            $volume = $request->input('volume');

            if ($volume == 0) {
                $volume = $container->volume;
            }

            $container->current_volume += $volume;
        } else {
            $validData = $request->validate([
                "liquid_id" => "required",
                "volume" => "required|numeric",
            ]);
            $container->update($validData);
        }

        $container->save();
        return redirect()->route('container.show', $container->id)->with('success', 'Container updated successfully!');
    }

    public function destroy($id)
    {
        $container = Container::find($id);
        $container->delete();
        return redirect()->route('container.index');
    }
}
