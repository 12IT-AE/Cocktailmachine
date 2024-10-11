<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pump;    
use App\Models\Container;
class PumpController extends Controller
{
    public function index()
    {
        $pumps = Pump::all();
        return view('pump.index', ['pumps' => $pumps]);
    }

    public function create()
    {
        $container = Container::all();
        return view('pump.create', ['containers'=> $container]);
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'container_id' => 'required',
        ]);
        if(!$validData){
            return back()->withErrors($validData)->withInput();
        }
        $pump = Pump::create($validData);
        return redirect()->route('pump.index');
        
    }

    public function show($id)
    {
        // Code to display a specific pump
    }

    public function edit($id)
    {
        // Code to show form to edit a pump
    }

    public function update(Request $request, $id)
    {
        // Code to update a specific pump
    }

    public function destroy($id)
    {
        $pump = Pump::find($id);
        $pump->delete();
        return redirect()->route('pump.index');
    }
}
