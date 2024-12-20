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
        $pumps = Pump::all();
        $pins = array_filter($pins, function ($pin) use ($pumps) {
            foreach ($pumps as $pump) {
                if ($pump->pin === $pin->value) {
                    return false;
                }
            }
            return true;
        });
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
            'flowrate' => 'required|numeric|min:1',
        ]);

        $pump = Pump::create([
            'container_id' => $validData['container_id'],
            'pin' => $validData['pin'],
            'flowrate' => $validData['flowrate'],
        ]);

        return redirect()->route('pump.index');
    }

    public function show($id)
    {
        $pump = Pump::find($id);
        return view('pump.show', ['pump' => $pump]);
    }

    public function edit($id)
    {
        $pump = Pump::find($id);
        $containers = Container::all();
        $pins = Pin::cases();
        $pumps = Pump::all();
        $pins = array_filter($pins, function ($pin) use ($pumps, $pump) {
            foreach ($pumps as $p) {
                if ($p->pin === $pin->value && $p->id !== $pump->id) {
                    return false;
                }
            }
            return true;
        });
        return view('pump.edit', compact('pump', 'containers', 'pins'));
    }

    public function update(Request $request, $id)
    {
        $validData = $request->validate([
            'container_id' => 'required|exists:containers,id',
            'pin' => ['required', function ($attribute, $value, $fail) {
                if (!Pin::tryFrom($value)) {
                    $fail('The selected pin is invalid.');
                }
            }],
        ]);

        $pump = Pump::find($id);
        $pump->update([
            'container_id' => $validData['container_id'],
            'pin' => $validData['pin'],
        ]);

        return redirect()->route('pump.index');
    }

    public function destroy($id)
    {
        $pump = Pump::find($id);
        $pump->delete();
        return redirect()->route('pump.index');
    }
}
