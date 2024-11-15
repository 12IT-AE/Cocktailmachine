<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\Pin;

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
        $containers = Container::all();
        $pins = Pin::cases();
        return view('pump.create', compact('containers', 'pins'));
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'container_id' => 'required|exists:containers,id',
            'pin' => ['required', function ($attribute, $value, $fail) {
                if (!Pin::tryFrom($value)) {
                    $fail('The selected pin is invalid.');
                }
            }],
        ]);

        $pump = Pump::create([
            'container_id' => $validData['container_id'],
            'pin' => $validData['pin'],
        ]);

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
