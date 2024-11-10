@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mano Atsiliepimai</h2>

    <!-- Hardcoded User Reviews List -->
    <ul id="userReviewList" class="list-group mt-3">
        <li class="list-group-item">
            <span class="review-text">Nuostabus viešbutis, labai patiko! - 5 žvaigždutės</span>
            <button onclick="editReview(1)" class="btn btn-sm btn-warning">Redaguoti</button>
            <button onclick="deleteReview(1)" class="btn btn-sm btn-danger">Ištrinti</button>
        </li>
        <li class="list-group-item">
            <span class="review-text">Šiek tiek triukšminga, bet vis tiek buvo malonu. - 4 žvaigždutės</span>
            <button onclick="editReview(2)" class="btn btn-sm btn-warning">Redaguoti</button>
            <button onclick="deleteReview(2)" class="btn btn-sm btn-danger">Ištrinti</button>
        </li>
        <li class="list-group-item">
            <span class="review-text">Neblogas, bet tikėjausi daugiau. - 3 žvaigždutės</span>
            <button onclick="editReview(3)" class="btn btn-sm btn-warning">Redaguoti</button>
            <button onclick="deleteReview(3)" class="btn btn-sm btn-danger">Ištrinti</button>
        </li>
    </ul>
</div>

<script>
    function deleteReview(id) {
        const reviewList = document.getElementById('userReviewList');
        const reviewItem = reviewList.querySelector(`li:nth-child(${id})`);
        reviewList.removeChild(reviewItem);
    }

    function editReview(id) {
        // Redirect to the edit review page with the selected review's id
        window.location.href = `/edit_review/${id}`;
    }
</script>
@endsection
