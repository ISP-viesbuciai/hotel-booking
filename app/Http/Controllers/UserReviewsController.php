<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atsiliepimas;
use App\Models\Komentaras;
use Illuminate\Support\Facades\Auth;

class UserReviewsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reviews = Atsiliepimas::where('fk_Naudotojas', $user->id)->with('comments')->get();
        $comments = Komentaras::where('fk_Naudotojas', $user->id)->with('atsiliepimas')->get();

        return view('user_reviews', compact('user', 'reviews', 'comments'));
    }

    public function updateReview(Request $request, $reviewId)
    {
        $review = Atsiliepimas::where('fk_Naudotojas', Auth::id())->findOrFail($reviewId);

        $validated = $request->validate([
            'tekstas' => 'required|string|max:255',
            'ivertinimas' => 'required|integer|min:1|max:5'
        ]);

        $review->update($validated);

        return redirect()->route('user.reviews.index')->with('success', 'Atsiliepimas sėkmingai pakeistas!');
    }

    public function deleteReview($reviewId)
    {
        $review = Atsiliepimas::where('fk_Naudotojas', Auth::id())->with('comments')->findOrFail($reviewId);

        // Manually delete comments
        Komentaras::where('fk_Atsiliepimas', $review->atsiliepimo_id)->delete();

        // Now delete the review
        $review->delete();

        return redirect()->route('user.reviews.index')->with('success', 'Atsiliepimas ir visi jo komentarai sėkmingai ištrinti!');
    }



    public function updateComment(Request $request, $commentId)
    {
        $comment = Komentaras::where('fk_Naudotojas', Auth::id())->findOrFail($commentId);

        $validated = $request->validate([
            'tekstas' => 'required|string|max:255'
        ]);

        $comment->update($validated);

        return redirect()->route('user.reviews.index')->with('success', 'Komentaras sėkmingai atnaujintas!');
    }

    public function deleteComment($commentId)
    {
        $comment = Komentaras::where('fk_Naudotojas', Auth::id())->findOrFail($commentId);
        $comment->delete();

        return redirect()->route('user.reviews.index')->with('success', 'Komentaras sėkmingai pašalintas!');
    }
}
