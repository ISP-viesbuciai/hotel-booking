<?php

namespace App\Http\Controllers;

use App\Models\Kambarys;
use App\Models\Rezervacija;
use Illuminate\Http\Request;

class UserReservationController extends Controller
{
    public function index(Request $request)
    {
        $availableRooms = null;
        $validated = null;

        // Check if start_date and end_date are provided for search
        if ($request->has(['start_date', 'end_date'])) {
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);

            // Get room IDs with conflicting reservations
            $conflictingRoomIds = Rezervacija::where(function ($query) use ($validated) {
                $query->whereBetween('pradzios_data', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('pabaigos_data', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('pradzios_data', '<=', $validated['start_date'])
                            ->where('pabaigos_data', '>=', $validated['end_date']);
                    });
            })->pluck('fk_Kambarys');

            // Get available rooms that are not in the conflicting room IDs
            $availableRooms = Kambarys::whereNotIn('kambario_id', $conflictingRoomIds)
                ->paginate(10)
                ->appends(['start_date' => $validated['start_date'], 'end_date' => $validated['end_date']]);
        }

        // Get the user's completed reservations
        $userReservations = Rezervacija::where('fk_Naudotojas', auth()->id())
            ->orderBy('pradzios_data', 'desc')
            ->get();

        return view('reservations.index', compact('availableRooms', 'validated', 'userReservations'));
    }
}

