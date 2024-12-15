<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Atsiliepimas;
use App\Models\Komentaras;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Get all users except admin itself if you want, or everyone
        $users = User::all();

        return view('admin.users_index', compact('users'));
    }

    public function showUser(User $user)
    {
        // Load user's reviews and their comments
        // We'll also load comments separately if needed
        $reviews = Atsiliepimas::where('fk_Naudotojas', $user->id)
            ->with('kambarys', 'comments')
            ->get();

        $comments = Komentaras::where('fk_Naudotojas', $user->id)
            ->with('atsiliepimas.kambarys')
            ->get();

        return view('admin.user_details', compact('user', 'reviews', 'comments'));
    }

    public function deleteReview($reviewId)
    {
        // Admin can delete any user's review
        $review = Atsiliepimas::with('comments')->findOrFail($reviewId);

        // Delete associated comments first
        Komentaras::where('fk_Atsiliepimas', $review->atsiliepimo_id)->delete();

        // Delete the review
        $review->delete();

        return back()->with('success', 'Atsiliepimas ir jo komentarai sėkmingai ištrinti!');
    }

    public function deleteComment($commentId)
    {
        // Admin can delete any user's comment
        $comment = Komentaras::findOrFail($commentId);

        $comment->delete();

        return back()->with('success', 'Komentaras sėkmingai ištrintas!');
    }
}
