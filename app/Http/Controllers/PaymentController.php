<?php

namespace App\Http\Controllers;

use App\Models\Kambarys;
use App\Models\Rezervacija;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        if ($request->method() !== 'POST') {
            return redirect()->route('reservations.index')->with('error', 'Invalid access method.');
        }

        $validated = $request->validate([
            'kambario_id' => 'required|exists:kambarys,kambario_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'full_name' => 'required|string|max:255',
            'birthdate' => 'required|date'
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Kambario Rezervacija',
                            'description' => 'Rezervacija kambariui Nr. ' . $validated['kambario_id'],
                        ],
                        'unit_amount' => 10000, // Amount in cents (€100.00)
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('reservations.index') . '?success=true',
                'cancel_url' => route('reservations.index') . '?canceled=true',
            ]);

            return redirect($checkoutSession->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to create a payment session: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        // Simulate Stripe success callback and save reservation
        $validated = $request->validate([
            'kambario_id' => 'required|exists:kambarys,kambario_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'full_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
        ]);

        $room = Kambarys::findOrFail($validated['kambario_id']);

        // Calculate the number of nights
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $nights = $startDate->diffInDays($endDate);

        // Calculate the total price
        $bendraKaina = $nights * $room->kaina_nakciai;

        // Insert reservation details into the database
        $reservation = Rezervacija::create([
            'rezervuotu_kambariu_nr' => $room->kambario_nr,
            'pradzios_data' => $validated['start_date'],
            'pabaigos_data' => $validated['end_date'],
            'bendra_kaina' => $bendraKaina,
            'sukurimo_data' => now(),
            'kiek_zmoniu' => $room->capacity,
            'rezervacijos_statusas' => 1,
            'fk_Kambarys' => $room->kambario_id,
            'fk_Naudotojas' => auth()->id(),
        ]);

        // Redirect with a success message
        return redirect()->route('reservations.index')->with('success', 'Rezervacija sėkmingai užbaigta!');
    }
}

