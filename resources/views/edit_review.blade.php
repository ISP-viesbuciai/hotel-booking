@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Redaguoti Atsiliepimą</h2>
    <form id="editReviewForm">
        <div class="mb-3">
            <label for="reviewText" class="form-label">Atsiliepimas</label>
            <textarea id="reviewText" class="form-control" rows="3">Įveskite redaguotą tekstą čia...</textarea>
        </div>
        <div class="mb-3">
            <label for="starRating" class="form-label">Žvaigždučių Įvertinimas</label>
            <input type="number" id="starRating" class="form-control" min="1" max="5" value="5">
        </div>
        <button type="button" class="btn btn-primary" onclick="updateReview()">Išsaugoti</button>
    </form>
</div>

<script>
    function updateReview() {
        // Store locally and navigate back to reviews without persisting on refresh
        const updatedText = document.getElementById('reviewText').value;
        const updatedRating = document.getElementById('starRating').value;
        alert(`Atsiliepimas atnaujintas: ${updatedText} - ${updatedRating} žvaigždutės`);
        window.history.back();
    }
</script>
@endsection
