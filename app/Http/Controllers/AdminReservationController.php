<?php
namespace App\Http\Controllers;

use App\Models\Rezervacija;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index()
    {
        $reservations = Rezervacija::all();
        return view('admin.reservations', compact('reservations'));
    }
}
