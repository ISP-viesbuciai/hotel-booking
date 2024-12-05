<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Carbon\Carbon;

class RoomsController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        // Optional date filtering placeholder
        if ($request->has('start_date') && $request->has('end_date')) {
            // Just filtering by is_available for now (no real reservation logic).
            $query->where('is_available', 1);
        }

        $rooms = $query->orderBy('floor')->orderBy('room_number')->get();

        return view('room', compact('rooms'));
    }

    public function showFreeRooms(Request $request)
    {
        // Just show available rooms
        $rooms = Room::where('is_available', 1)
            ->orderBy('floor')
            ->orderBy('room_number')
            ->get();

        return view('room', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|numeric|unique:rooms,room_number',
            'type' => 'required|string',
            'capacity' => 'required|numeric',
            'price_per_night' => 'required|numeric',
            'is_available' => 'required|boolean',
            'floor' => 'required|numeric',
            'sea_view' => 'required|boolean'
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'type' => $request->type,
            'capacity' => $request->capacity,
            'price_per_night' => $request->price_per_night,
            'is_available' => $request->is_available,
            'floor' => $request->floor,
            'sea_view' => $request->sea_view,
            'last_cleaned' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('rooms.index')->with('success', 'Kambarys pridėtas sėkmingai!');
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'type' => 'required|string',
            'capacity' => 'required|numeric',
            'price_per_night' => 'required|numeric',
            'is_available' => 'required|boolean',
            'floor' => 'required|numeric',
            'sea_view' => 'required|boolean'
        ]);

        $room->update([
            'type' => $request->type,
            'capacity' => $request->capacity,
            'price_per_night' => $request->price_per_night,
            'is_available' => $request->is_available,
            'floor' => $request->floor,
            'sea_view' => $request->sea_view,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Kambarys atnaujintas sėkmingai!');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        if ($room->is_available == 1) {
            $room->delete();
            return redirect()->route('rooms.index')->with('success', 'Kambarys ištrintas sėkmingai!');
        } else {
            return redirect()->route('rooms.index')->with('error', 'Negalite ištrinti rezervuoto kambario.');
        }
    }

    /**
     * Automatic room allocation for a group.
     * Parameters (from request):
     * - total_people: int - How many people in the group
     * - rooms_count: int - How many rooms they want to split across
     * - desired_type: string (optional) - Filter by room type ("Single", "Double", "Suite", etc.)
     */
    public function autoAllocateForGroup(Request $request)
    {
        $request->validate([
            'total_people' => 'required|integer|min:1',
            'rooms_count' => 'required|integer|min:1',
        ]);

        $total_people = $request->input('total_people');
        $rooms_count = $request->input('rooms_count');
        $desired_type = $request->input('desired_type', null);

        // Query available rooms
        $query = Room::where('is_available', 1);

        if (!empty($desired_type)) {
            $query->where('type', $desired_type);
        }

        // Order by floor then by room_number
        $available_rooms = $query->orderBy('floor')->orderBy('room_number')->get();

        if ($available_rooms->count() < $rooms_count) {
            return redirect()->route('rooms.index')->with('error', 'Nepakanka laisvų kambarių.');
        }

        // We need to find `rooms_count` consecutive rooms that fit `total_people`.
        $best_set = null;
        $best_range = PHP_INT_MAX; // minimal difference between max and min room_number

        $rooms_array = $available_rooms->all();
        $length = count($rooms_array);

        for ($start = 0; $start <= $length - $rooms_count; $start++) {
            $subset = array_slice($rooms_array, $start, $rooms_count);

            // Calculate total capacity
            $sum_capacity = array_sum(array_map(fn($r) => $r->capacity, $subset));

            if ($sum_capacity >= $total_people) {
                // Check how close they are: measure by the range of their room_numbers
                $room_numbers = array_map(fn($r) => $r->room_number, $subset);
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
            // No suitable allocation found
            return redirect()->route('rooms.index')->with('error', 'Nepavyko rasti kambarių atitinkančių poreikius.');
        }

        // Update the allocated rooms to no longer be available
        foreach ($best_set as $r) {
            $roomModel = Room::find($r->id);
            $roomModel->update(['is_available' => 0]);
        }

        $allocated_rooms_numbers = array_map(fn($r) => $r->room_number, $best_set);

        return redirect()->route('rooms.index')
            ->with('success', 'Grupės kambariai sėkmingai paskirstyti ir rezervuoti!')
            ->with('allocated_rooms', $allocated_rooms_numbers);
    }
}
