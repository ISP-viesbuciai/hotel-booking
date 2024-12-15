@extends('layouts.app')

<style>
    .star {
        font-size: 24px;
        color: gray;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }
    .star.hover {
        color: gold;
    }
    .star.selected {
        color: gold;
    }
    .comments-container {
        display: none;
        margin-top: 10px;
    }
</style>

@section('content')
<div class="container">
    <h2>Kambarių atsiliepimai</h2>

    <!-- Filter & Room Selection Form -->
    <form method="GET" action="{{ route('reviews.index') }}">
        <div class="mb-4">
            <label for="roomSelect" class="form-label">Pasirinkite kambarį:</label>
            <select id="roomSelect" name="room_id" class="form-select" onchange="this.form.submit()">
                <option value="" disabled {{ !$selectedRoom ? 'selected' : '' }}>Pasirinkite...</option>
                @foreach ($rooms as $room)
                    <option value="{{ $room->kambario_id }}" {{ $selectedRoom && $room->kambario_id == $selectedRoom->kambario_id ? 'selected' : '' }}>
                        Kambarys {{ $room->kambario_nr }} ({{ $room->tipas }})
                    </option>
                @endforeach
            </select>
        </div>

        @if ($selectedRoom)
            <!-- Additional Filters -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Data nuo:</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Data iki:</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label for="stars" class="form-label">Žvaigždutės:</label>
                    <select name="stars" id="stars" class="form-select">
                        <option value="">Visos</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ request('stars') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100">Filtruoti</button>
                </div>
                <div class="col-md-3">
                    <label for="sort_by" class="form-label">Rūšiuoti pagal:</label>
                    <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                        <option value="date" {{ request('sort_by') == 'date' ? 'selected' : '' }}>Data</option>
                        <option value="likes" {{ request('sort_by') == 'likes' ? 'selected' : '' }}>Patinka kiekis</option>
                        <option value="stars" {{ request('sort_by') == 'stars' ? 'selected' : '' }}>Žvaigždučių</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="order" class="form-label">Tvarka:</label>
                    <select name="order" id="order" class="form-select" onchange="this.form.submit()">
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Didėjanti</option>
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Mažėjanti</option>
                    </select>
                </div>
            </div>
        @endif
    </form>

    @if ($selectedRoom)
        <h4>Atsiliepimai apie kambarį {{ $selectedRoom->kambario_nr }} ({{ $selectedRoom->tipas }})</h4>

        <!-- Reviews List -->
        <ul class="list-group">
            @forelse ($reviews as $review)
                <li class="list-group-item">
                    <!-- Likes and Like Button for Review -->
                    <p>Patinka: {{ $review->likes_count }}</p>
                    <form method="POST" action="{{ route('reviews.like', $review->atsiliepimo_id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Patinka</button>
                    </form>
                    <!-- Username -->
                    <strong>{{ $review->user->name ?? 'Anonimas' }}</strong><br>

                    <!-- Star Rating -->
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->ivertinimas)
                            <span class="star selected">&#9733;</span>
                        @else
                            <span class="star">&#9733;</span>
                        @endif
                    @endfor
                    
                    <br>
                    
                    <!-- Review Text -->
                    {{ $review->tekstas }}
                    
                    <br>
                    
                    <!-- Review Date -->
                    <small>{{ $review->data }}</small>

                    <div class="mt-3">
                        <button class="btn btn-sm btn-info toggle-comments" data-target="#comments-{{ $review->atsiliepimo_id }}">
                            Rodyti komentarus ({{ $review->comments->count() }})
                        </button>
                    </div>

                    <!-- Comments Section -->
                    <div id="comments-{{ $review->atsiliepimo_id }}" class="comments-container">
                        <hr>
                        <h5>Komentarai</h5>
                        @if($review->comments->count() > 0)
                            <ul class="list-group mb-2">
                                @foreach($review->comments as $comment)
                                    <li class="list-group-item">
                                        <p>Patinka: {{ $comment->likes_count }}</p>
                                        <form method="POST" action="{{ route('comments.like', $comment->komentaro_id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Patinka</button>
                                        </form>
                                        <!-- Comment User Name -->
                                        <strong>{{ $comment->user->name ?? 'Anonimas' }}</strong><br>
                                        
                                        <!-- Comment Text -->
                                        {{ $comment->tekstas }}<br>
                                        
                                        <!-- Comment Date -->
                                        <small>{{ $comment->data }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Nėra komentarų.</p>
                        @endif

                        <!-- Add Comment Form -->
                        <!-- Add Comment Form -->
                        <form method="POST" action="{{ route('reviews.comment.store', $review->atsiliepimo_id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="comment_text_{{ $review->atsiliepimo_id }}" class="form-label">Pridėti komentarą</label>
                                <textarea id="comment_text_{{ $review->atsiliepimo_id }}" name="comment_text" class="form-control" rows="2" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Pridėti</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="list-group-item">Nėra atsiliepimų šiam kambariui.</li>
            @endforelse
        </ul>

        <!-- Add Review -->
        <h4 class="mt-4">Palikite atsiliepimą</h4>
        <form method="POST" action="{{ route('reviews.store') }}">
            @csrf
            <input type="hidden" name="room_id" value="{{ $selectedRoom->kambario_id }}">

            <div class="mb-3">
                <label for="reviewText" class="form-label">Atsiliepimas</label>
                <textarea id="reviewText" name="review_text" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Įvertinimas (1–5 žvaigždutės)</label>
                <div id="starRating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                </div>
                <input type="hidden" id="rating" name="rating" value="5">
            </div>

            <button type="submit" class="btn btn-primary">Pateikti</button>
        </form>

    @else
        <p>Pasirinkite kambarį, kad pamatytumėte atsiliepimus.</p>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Star rating logic for creating a new review
        const stars = document.querySelectorAll('#starRating .star');
        const ratingInput = document.getElementById('rating');
        let selectedValue = ratingInput.value;

        function highlightStars(value) {
            const valueInt = parseInt(value, 10);
            stars.forEach(star => {
                const starValueInt = parseInt(star.getAttribute('data-value'), 10);
                star.classList.toggle('hover', starValueInt <= valueInt);
                if (selectedValue) {
                    const selectedValueInt = parseInt(selectedValue, 10);
                    star.classList.toggle('selected', starValueInt <= selectedValueInt);
                }
            });
        }

        stars.forEach(star => {
            star.addEventListener('mouseover', function () {
                highlightStars(this.getAttribute('data-value'));
            });
            star.addEventListener('mouseout', function () {
                highlightStars(selectedValue);
            });
            star.addEventListener('click', function () {
                selectedValue = this.getAttribute('data-value');
                ratingInput.value = selectedValue;
                highlightStars(selectedValue);
            });
        });

        highlightStars(ratingInput.value);

        // Toggle comments section
        document.querySelectorAll('.toggle-comments').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.querySelector(button.dataset.target);
                if (target) {
                    target.style.display = target.style.display === 'none' || target.style.display === '' ? 'block' : 'none';
                }
            });
        });
    });
</script>
@endsection
