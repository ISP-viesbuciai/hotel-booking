@extends('layouts.app')

<style>
    .star {
        font-size: 24px;
        color: gray;
        cursor: pointer;
    }
    .star.selected {
        color: gold;
    }
</style>

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    <h2>Vartotojo informacija</h2>
    <p><strong>Vardas:</strong> {{ $user->name }}</p>
    <p><strong>El. paštas:</strong> {{ $user->email }}</p>
    <p><strong>Registracijos data:</strong> {{ $user->registracijos_data }}</p>

    <hr>

    <h3>Vartotojo atsiliepimai</h3>
    @if($reviews->count() > 0)
        <ul class="list-group mt-3">
            @foreach($reviews as $review)
                <li class="list-group-item">
                    <p><strong>Kambarys:</strong> Nr. {{ $review->kambarys->kambario_nr }} ({{ $review->kambarys->tipas }})</p>
                    <p><strong>Patinka:</strong> {{ $review->likes_count }}</p>
                    <p><strong>Data:</strong> {{ $review->data }}</p>

                    <!-- Star Rating Display -->
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->ivertinimas)
                            <span class="star selected">&#9733;</span>
                        @else
                            <span class="star">&#9733;</span>
                        @endif
                    @endfor

                    <p class="mt-2">{{ $review->tekstas }}</p>

                    <!-- Admin can delete user's review -->
                    <form method="POST" action="{{ route('admin.users.reviews.delete', $review->atsiliepimo_id) }}" style="display:inline;" onsubmit="return confirm('Ar tikrai norite ištrinti šį atsiliepimą ir visus jo komentarus?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Ištrinti</button>
                    </form>

                    @if($review->comments->count() > 0)
                        <h5 class="mt-4">Komentarai:</h5>
                        <ul class="list-group">
                            @foreach ($review->comments as $comment)
                                <li class="list-group-item">
                                    <p><strong>Patinka:</strong> {{ $comment->likes_count }}</p>
                                    <p><strong>Data:</strong> {{ $comment->data }}</p>
                                    <p>{{ $comment->tekstas }}</p>
                                    <!-- Admin delete comment form -->
                                    <form method="POST" action="{{ route('admin.users.comments.delete', $comment->komentaro_id) }}" style="display:inline;" onsubmit="return confirm('Ar tikrai norite ištrinti šį komentarą?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Ištrinti komentarą</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>Šis vartotojas neturi atsiliepimų.</p>
    @endif

    <hr>
</div>
@endsection
