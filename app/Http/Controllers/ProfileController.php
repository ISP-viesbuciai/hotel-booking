<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function addCard(Request $request)
    {
        $request->validate([
            'Korteles_nr' => ['required', 'string', 'max:255'],
            'Korteles_savininkas' => ['required', 'string', 'max:255'],
            'Galiojimo_data' => ['required', 'date'],
            'CVV' => ['required', 'string', 'max:4'],
            'Atsiskaitymo_adresas' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $user->paymentInformation()->create([
            'Korteles_nr' => $request->Korteles_nr,
            'Korteles_savininkas' => $request->Korteles_savininkas,
            'Galiojimo_data' => $request->Galiojimo_data,
            'CVV' => $request->CVV,
            'Atsiskaitymo_adresas' => $request->Atsiskaitymo_adresas,
            'fk_Mokejimas' => 1, // Example value, adjust as needed
        ]);

        return redirect()->route('profile.edit')->with('status', 'Card added successfully.');
    }
}
