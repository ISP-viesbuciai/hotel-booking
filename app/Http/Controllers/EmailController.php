<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Email;  // Import the Email model

class EmailController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'siuntejo_el_pastas' => 'required|email',
            'tema'               => 'required|string|max:255',
            'tekstas'            => 'required|string',
        ]);

        // Hardcoded recipient email
        $recipientEmail = 'hotel.booking.isp@gmail.com';

        // Get current time
        $currentTime = Carbon::now()->toTimeString();

        // Insert the data into the database using the Email model
        Email::create([
            'siuntejo_el_pastas' => $request->siuntejo_el_pastas,
            'gavejo_el_pastas'   => $recipientEmail, // Hardcoded email
            'tema'               => $request->tema,
            'tekstas'            => $request->tekstas,
            'laikas'             => $currentTime,
            'fk_Naudotojas'      => auth()->id(),
        ]);

        // Include the sender's email in the message body
        $messageContent = "Sender's Email: " . $request->siuntejo_el_pastas . "\n\n";
        $messageContent .= $request->tekstas;  // Append the original message

        // Send the email
        Mail::raw($messageContent, function ($message) use ($request, $recipientEmail) {
            $message->to($recipientEmail)
                    ->subject($request->tema)
                    ->from($request->siuntejo_el_pastas);
        });

        // Redirect back with a success message
        return back()->with('success', 'Laiškas buvo sėkmingai išsiųstas!');
    }
}
