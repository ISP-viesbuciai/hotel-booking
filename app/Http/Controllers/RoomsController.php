<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kambarys; // Ensure this model exists and is correctly set up

class RoomsController extends Controller
{
    public function index(Request $request)
    {
        $query = Kambarys::query();
        // Add any additional filtering if necessary

        $kambariai = $query->orderBy('aukstas')->orderBy('kambario_nr')->get();

        return view('room', ['kambariai' => $kambariai]);
    }

    public function showFreeRooms(Request $request)
    {
        $kambariai = Kambarys::where('available', 1)
            ->orderBy('aukstas')
            ->orderBy('kambario_nr')
            ->get();

        return view('room', ['kambariai' => $kambariai]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kambario_nr' => 'required|numeric|unique:kambarys,kambario_nr',
            'tipas' => 'required|string',
            'capacity' => 'required|numeric',
            'kaina_nakciai' => 'required|numeric',
            'available' => 'required|boolean',
            'aukstas' => 'required|numeric',
            'vaizdas_i_jura' => 'required|boolean'
        ]);

        Kambarys::create([
            'kambario_nr' => $request->kambario_nr,
            'tipas' => $request->tipas,
            'capacity' => $request->capacity,
            'kaina_nakciai' => $request->kaina_nakciai,
            'available' => $request->available,
            'aukstas' => $request->aukstas,
            'vaizdas_i_jura' => $request->vaizdas_i_jura,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Kambarys pridėtas sėkmingai!');
    }

    public function update(Request $request, $id)
    {
        $kambarys = Kambarys::findOrFail($id);

        $request->validate([
            'tipas' => 'required|string',
            'capacity' => 'required|numeric',
            'kaina_nakciai' => 'required|numeric',
            'available' => 'required|boolean',
            'aukstas' => 'required|numeric',
            'vaizdas_i_jura' => 'required|boolean'
        ]);

        $kambarys->update([
            'tipas' => $request->tipas,
            'capacity' => $request->capacity,
            'kaina_nakciai' => $request->kaina_nakciai,
            'available' => $request->available,
            'aukstas' => $request->aukstas,
            'vaizdas_i_jura' => $request->vaizdas_i_jura,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Kambarys atnaujintas sėkmingai!');
    }

    public function destroy($id)
    {
        $kambarys = Kambarys::findOrFail($id);
        if ($kambarys->available == 1) {
            $kambarys->delete();
            return redirect()->route('rooms.index')->with('success', 'Kambarys ištrintas sėkmingai!');
        } else {
            return redirect()->route('rooms.index')->with('error', 'Negalite ištrinti rezervuoto kambario.');
        }
    }

    public function autoAllocateForGroup(Request $request)
    {
        $request->validate([
            'total_people' => 'required|integer|min:1',
            'rooms_count' => 'required|integer|min:1',
        ]);

        $total_people = $request->input('total_people');
        $rooms_count = $request->input('rooms_count');
        $desired_type = $request->input('desired_type', null);

        // Query available kambariai
        $query = Kambarys::where('available', 1);

        if (!empty($desired_type)) {
            $query->where('tipas', $desired_type);
        }

        $available_kambariai = $query->orderBy('aukstas')->orderBy('kambario_nr')->get();

        if ($available_kambariai->count() < $rooms_count) {
            return redirect()->route('rooms.index')->with('error', 'Nepakanka laisvų kambarių.');
        }

        // Find suitable set
        $kambariai_array = $available_kambariai->all();
        $length = count($kambariai_array);
        $best_set = null;
        $best_range = PHP_INT_MAX;

        for ($start = 0; $start <= $length - $rooms_count; $start++) {
            $subset = array_slice($kambariai_array, $start, $rooms_count);

            // Calculate total capacity
            $sum_capacity = array_sum(array_map(fn($r) => $r->capacity, $subset));

            if ($sum_capacity >= $total_people) {
                // Measure by range of kambario_nr
                $room_numbers = array_map(fn($r) => $r->kambario_nr, $subset);
                $min_room = min($room_numbers);
                $max_room = max($room_numbers);
                $range = $max_room - $min_room;

                if ($range < $best_range) {
                    $best_range = $range;
                    $best_set = $subset;
                }
            }
        }

        if (!$best_set) {
            return redirect()->route('rooms.index')->with('error', 'Nepavyko rasti kambarių atitinkančių poreikius.');
        }

        // Update allocated kambariai to no longer be available
        foreach ($best_set as $r) {
            $model = Kambarys::find($r->kambario_id);
            $model->update(['available' => 0]);
        }

        $allocated_kambariai_numbers = array_map(fn($r) => $r->kambario_nr, $best_set);

        return redirect()->route('rooms.index')
            ->with('success', 'Grupės kambariai sėkmingai paskirstyti ir rezervuoti!')
            ->with('allocated_rooms', $allocated_kambariai_numbers);
    }
}
