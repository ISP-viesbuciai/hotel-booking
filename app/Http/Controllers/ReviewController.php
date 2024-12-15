<?php
namespace App\Http\Controllers;

use App\Models\Atsiliepimas;
use App\Models\Komentaras;
use App\Models\Kambarys;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Display the review page with room selection
    /*public function index(Request $request)
    {
        // Fetch all rooms
        $rooms = Kambarys::all();
        
        // If a room is selected, fetch its reviews
        $selectedRoomId = $request->query('room_id');
        $reviews = [];
        $selectedRoom = null;

        if ($selectedRoomId) {
            $selectedRoom = Kambarys::find($selectedRoomId);
            $reviews = Atsiliepimas::where('fk_Kambarys', $selectedRoomId)->get();
        }

        return view('reviews', compact('rooms', 'selectedRoom', 'reviews'));
    }*/

    public function index(Request $request)
    {
        $rooms = Kambarys::all();
        $selectedRoom = null;
        $reviews = collect();

        if ($request->has('room_id')) {
            $selectedRoom = Kambarys::find($request->room_id);

            $query = Atsiliepimas::with(['user', 'comments.user'])
                ->where('fk_Kambarys', $request->room_id);

            // Apply filters if provided
            if ($request->filled('date_from')) {
                $query->where('data', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->where('data', '<=', $request->date_to);
            }
            if ($request->filled('stars')) {
                $query->where('ivertinimas', $request->stars);
            }

            // Sorting
            // sort_by can be 'date', 'likes', 'stars'
            // order can be 'asc' or 'desc'
            $sortBy = $request->get('sort_by', 'date'); 
            $order = $request->get('order', 'asc'); 

            switch($sortBy) {
                case 'likes':
                    $query->orderBy('likes_count', $order);
                    break;
                case 'stars':
                    $query->orderBy('ivertinimas', $order);
                    break;
                case 'date':
                default:
                    $query->orderBy('data', $order);
                    break;
            }

            $reviews = $query->get();

            // Sort comments within each review based on possible parameters
            // For simplicity, let's sort comments by date and likes too, if requested
            // We'll use the same sort parameters, but you could use separate form fields if needed
            foreach ($reviews as $review) {
                $comments = $review->comments;
                // Sort comments
                // We'll assume sort_by 'date' or 'likes' applies to comments as well.
                if ($sortBy == 'likes') {
                    $comments = $comments->sortBy('likes_count', SORT_REGULAR, $order == 'desc');
                } else {
                    // default date sort for comments
                    $comments = $comments->sortBy('data', SORT_REGULAR, $order == 'desc');
                }
                $review->setRelation('comments', $comments);
            }
        }

        return view('reviews', compact('rooms', 'selectedRoom', 'reviews'));
    }


    // Store a new review for a specific room
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:kambarys,kambario_id',
            'review_text' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5', // Enforce rating between 1 and 5
        ]);

        Atsiliepimas::create([
            'tekstas' => $validated['review_text'],
            'ivertinimas' => $validated['rating'],
            'data' => now(),
            'fk_Naudotojas' => auth()->id(),
            'fk_Kambarys' => $validated['room_id'],
        ]);

        return redirect()->route('reviews.index', ['room_id' => $validated['room_id']])
            ->with('success', 'Review added successfully!');
    }

    public function storeComment(Request $request, $reviewId)
    {
        $request->validate([
            'comment_text' => 'required|string|max:255',
        ]);

        Komentaras::create([
            'tekstas' => $request->comment_text,
            'data' => now()->toDateString(),
            'fk_Atsiliepimas' => $reviewId,
            'fk_Naudotojas' => auth()->id(), // associate current user
        ]);

        return redirect()->back()->with('success', 'Komentaras pridėtas sėkmingai!');
    }

    public function likeReview($reviewId)
    {
        $review = Atsiliepimas::findOrFail($reviewId);
        $review->increment('likes_count');
        return redirect()->back();
    }

    public function likeComment($commentId)
    {
        $comment = Komentaras::findOrFail($commentId);
        $comment->increment('likes_count');
        return redirect()->back();
    }

}
