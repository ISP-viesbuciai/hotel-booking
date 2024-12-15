<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokalbis;
use App\Models\Zinute;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Show chat page and load messages
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Check if an active conversation exists
        $pokalbis = Pokalbis::where('naudotojo_id', $user->id)
            ->latest()
            ->first();

        if (!$pokalbis) {
            return redirect()->route('chat.start');
        }

        $zinutes = Zinute::where('pokalbio_id', $pokalbis->id)
            ->orderBy('laikas', 'asc')
            ->get();

        return view('chat', compact('pokalbis', 'zinutes'));
    }

    // Start a new conversation
    public function startConversation(Request $request)
    {
        $user = Auth::user();

        // Create a new conversation
        $pokalbis = Pokalbis::create([
            'pradzios_laikas' => now(),
            'naudotojo_id' => $user->id,
            'admin_id' => 1 // Assuming admin ID is static for now
        ]);

        return redirect()->route('chat.index');
    }

    public function sendMessage(Request $request)
{
    // Validate the message input
    $request->validate([
        'message' => 'required|string',
    ]);

    $user = Auth::user();
    // Get the active conversation for the user
    $pokalbis = Pokalbis::where('naudotojo_id', $user->id)->latest()->first();


    if (!$pokalbis) {
        return response()->json(['success' => false, 'error' => 'No active conversation found.'], 404);
    }

    // Save the new message
    $zinute = Zinute::create([
        'pokalbio_id' => $pokalbis->id,
        'siuntejo_id' => $user->id,
        'gavejo_id' => $pokalbis->admin_id,
        'tekstas' => $request->message,
        'laikas' => now(),
    ]);

    // Return the newly saved message as JSON for frontend display
    return redirect()->route('chat.index');

}
    
}

