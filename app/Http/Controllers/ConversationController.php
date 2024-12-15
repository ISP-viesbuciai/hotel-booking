<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokalbis;
use Illuminate\Support\Facades\Auth;
use App\Models\Zinute;

class ConversationController extends Controller
{
    public function showAllConversations()
{
    // Fetch all conversations
    $pokalbiai = Pokalbis::all(); // Fetch all conversations, apply additional filters if necessary
    
    // Pass the data to the view
    return view('chatList', compact('pokalbiai')); // Use the 'chatlist' Blade view
}

// In ConversationController.php
public function joinConversation($id)
{
    // Find the conversation by its ID
    $pokalbis = Pokalbis::findOrFail($id);
    
    // Retrieve the messages for the conversation
    $zinutes = $pokalbis->zinutes;
    
    // Pass the conversation and messages to the view
    return view('adminChat', compact('pokalbis', 'zinutes'));
}

// In ConversationController.php
public function sendMessage(Request $request)
{
    $validated = $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    $pokalbis = Pokalbis::findOrFail($request->pokalbio_id);
    $gavejo_id = $pokalbis->naudotojo_id; // Get the first user in the conversation (assuming the recipient is one of the users)


    // Create a new message in the conversation
    $zinute = new Zinute();
    $zinute->pokalbio_id = $request->pokalbio_id; // or retrieve the ID from the request
    $zinute->siuntejo_id = Auth::id();
    $zinute->gavejo_id = $gavejo_id;
    $zinute->tekstas = $validated['message'];
    $zinute->save();

    return back(); // Redirect back to the same chat page
}

}