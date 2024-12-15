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
    .edit-form {
        display: none;
        margin-top: 10px;
    }
</style>

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif
    <h2>Mano Atsiliepimai ir Komentarai</h2>

    <h4 class="mt-4">Mano Atsiliepimai</h4>
    @if ($reviews->count() > 0)
        <ul class="list-group mt-3">
            @foreach ($reviews as $review)
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

                    <p class="mt-2 review-text">{{ $review->tekstas }}</p>

                    <!-- Edit & Delete Buttons -->
                    <button class="btn btn-sm btn-warning" onclick="toggleEditForm('review', {{ $review->atsiliepimo_id }})">Redaguoti</button>
                    <form method="POST" action="{{ route('user.reviews.delete', $review->atsiliepimo_id) }}" style="display:inline;" onsubmit="return confirm('Ar tikrai norite ištrinti šį atsiliepimą ir visus jo komentarus?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Ištrinti</button>
                    </form>

                    <!-- Edit Form for Review -->
                    <form method="POST" action="{{ route('user.reviews.update', $review->atsiliepimo_id) }}" class="edit-form" id="review-edit-form-{{ $review->atsiliepimo_id }}">
                        @csrf
                        <div class="mt-3">
                            <label>Atsiliepimas:</label>
                            <textarea name="tekstas" class="form-control" rows="2">{{ $review->tekstas }}</textarea>
                        </div>
                        <div class="mt-3">
                            <label>Įvertinimas (1–5):</label>
                            <select name="ivertinimas" class="form-select">
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}" {{ $i == $review->ivertinimas ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Išsaugoti pakeitimus</button>
                    </form>

                    <!-- Show comments for this review -->
                    @if ($review->comments->count() > 0)
                        <h5 class="mt-4">Komentarai:</h5>
                        <ul class="list-group">
                            @foreach ($review->comments as $comment)
                                <li class="list-group-item">
                                    <p><strong>Patinka:</strong> {{ $comment->likes_count }}</p>
                                    <p><strong>Data:</strong> {{ $comment->data }}</p>
                                    <p class="comment-text">{{ $comment->tekstas }}</p>

                                    <!-- Edit & Delete Buttons for Comment -->
                                    @if ($comment->fk_Naudotojas == auth()->id())
                                        <button class="btn btn-sm btn-warning" onclick="toggleEditForm('comment', {{ $comment->komentaro_id }})">Redaguoti</button>
                                        <form method="POST" action="{{ route('user.comments.delete', $comment->komentaro_id) }}" style="display:inline;" onsubmit="return confirm('Ar tikrai norite ištrinti šį komentarą?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Ištrinti</button>
                                        </form>

                                        <!-- Edit Form for Comment -->
                                        <form method="POST" action="{{ route('user.comments.update', $comment->komentaro_id) }}" class="edit-form" id="comment-edit-form-{{ $comment->komentaro_id }}">
                                            @csrf
                                            <div class="mt-3">
                                                <label>Komentaras:</label>
                                                <textarea name="tekstas" class="form-control" rows="2">{{ $comment->tekstas }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary mt-2">Išsaugoti pakeitimus</button>
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>Jūs dar neturite atsiliepimų.</p>
    @endif

<script>
    function toggleEditForm(type, id) {
        const form = document.getElementById(`${type}-edit-form-${id}`);
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>
@endsection
