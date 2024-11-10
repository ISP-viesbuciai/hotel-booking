@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Viešbučių atsiliepimai</h2>
    <!-- Hotel Selection -->
    <div class="mb-4">
        <label for="hotelSelect" class="form-label">Pasirinkite viešbutį:</label>
        <select id="hotelSelect" class="form-select">
            <option value="1">Hotel A</option>
            <option value="2">Hotel B</option>
            <option value="3">Hotel C</option>
        </select>
    </div>

    <!-- Sort and Filter Options -->
    <div class="mb-4">
        <button onclick="sortByStars()" class="btn btn-secondary">Rikiuoti pagal žvaigždes</button>
        <button onclick="sortByLikes()" class="btn btn-secondary">Rikiuoti pagal patiktukus</button>
        <input type="number" id="filterStars" class="form-control mt-2" placeholder="Filtruoti pagal žvaigždučių skaičių" min="1" max="5">
        <button onclick="filterByStars()" class="btn btn-secondary mt-2">Filtruoti</button>
    </div>

    <!-- Average Rating -->
    <div class="mb-4">
        <h4>Vidutinis reitingas: <span id="averageRating">0</span> / 5</h4>
    </div>

    <!-- Review Form -->
    <h4>Palikite atsiliepimą</h4>
    <form id="reviewForm">
        <div class="mb-3">
            <label for="reviewText" class="form-label">Atsiliepimas</label>
            <textarea id="reviewText" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="starRating" class="form-label">Žvaigždutės</label>
            <input type="number" id="starRating" class="form-control" min="1" max="5" value="5">
        </div>
        <button type="button" class="btn btn-primary" onclick="addReview()">Pateikti</button>
    </form>

    <!-- Reviews List -->
    <h4 class="mt-4">Atsiliepimai</h4>
    <ul id="reviewList" class="list-group mt-3">
        <!-- Reviews will be injected here -->
    </ul>
</div>

<script>
    const hotels = {
        1: { name: 'Hotel A', reviews: [{ text: 'Šaunu!', rating: 5, likes: 3, comments: [] }, { text: 'komfortiška', rating: 4, likes: 5, comments: [] }, { text: 'Geras aptarnavimas', rating: 4, likes: 2, comments: [] }] },
        2: { name: 'Hotel B', reviews: [{ text: 'Švaru', rating: 4, likes: 4, comments: [] }, { text: 'Puiki vieta', rating: 5, likes: 10, comments: [] }, { text: 'Draugiški', rating: 5, likes: 6, comments: [] }] },
        3: { name: 'Hotel C', reviews: [{ text: 'Mid af', rating: 3, likes: 1, comments: [] }, { text: 'Galima geriau', rating: 2, likes: 2, comments: [] }, { text: 'geriau nei tikėjaus', rating: 4, likes: 4, comments: [] }] }
    };

    const hotelSelect = document.getElementById('hotelSelect');
    const reviewList = document.getElementById('reviewList');
    const averageRating = document.getElementById('averageRating');

    hotelSelect.addEventListener('change', displayReviews);

    function displayReviews() {
        const selectedHotel = hotelSelect.value;
        const hotel = hotels[selectedHotel];
        reviewList.innerHTML = '';

        if (hotel && hotel.reviews.length > 0) {
            let totalRating = 0;
            hotel.reviews.forEach((review, index) => {
                totalRating += review.rating;
                const reviewItem = document.createElement('li');
                reviewItem.classList.add('list-group-item');
                
                reviewItem.innerHTML = `
                    <div>
                        <strong>${review.text}</strong> - ${review.rating} žvaigždutės
                        <button onclick="likeReview(${index})" class="btn btn-sm btn-outline-primary">Patinka (${review.likes})</button>
                    </div>
                    <div id="comments-${index}">
                        <label for="commentInput-${index}" class="form-label mt-2">Komentarai:</label>
                        <ul class="list-group">
                            ${review.comments.map(comment => `<li class="list-group-item">${comment}</li>`).join('')}
                        </ul>
                        <input type="text" id="commentInput-${index}" class="form-control mt-2" placeholder="Palikite komentarą">
                        <button onclick="addComment(${index})" class="btn btn-sm btn-secondary mt-2">Pridėti komentarą</button>
                    </div>
                `;
                
                reviewList.appendChild(reviewItem);
            });
            averageRating.textContent = (totalRating / hotel.reviews.length).toFixed(1);
        } else {
            averageRating.textContent = '0';
            reviewList.innerHTML = '<li class="list-group-item">Nėra atsiliepimų.</li>';
        }
    }

    function addReview() {
        const selectedHotel = hotelSelect.value;
        const reviewText = document.getElementById('reviewText').value;
        const starRating = parseInt(document.getElementById('starRating').value);

        if (!reviewText || isNaN(starRating) || starRating < 1 || starRating > 5) {
            alert('Prašome įvesti galiojantį atsiliepimą ir įvertinimą (1-5 žvaigždutės).');
            return;
        }

        const newReview = { text: reviewText, rating: starRating, likes: 0, comments: [] };
        hotels[selectedHotel].reviews.push(newReview);

        displayReviews();
        document.getElementById('reviewForm').reset();
    }

    function likeReview(index) {
        const selectedHotel = hotelSelect.value;
        hotels[selectedHotel].reviews[index].likes += 1;
        displayReviews();
    }

    function addComment(index) {
        const selectedHotel = hotelSelect.value;
        const commentInput = document.getElementById(`commentInput-${index}`);
        const commentText = commentInput.value.trim();

        if (commentText) {
            hotels[selectedHotel].reviews[index].comments.push(commentText);
            displayReviews();
        }
    }

    function sortByStars() {
        const selectedHotel = hotelSelect.value;
        hotels[selectedHotel].reviews.sort((a, b) => b.rating - a.rating);
        displayReviews();
    }

    function sortByLikes() {
        const selectedHotel = hotelSelect.value;
        hotels[selectedHotel].reviews.sort((a, b) => b.likes - a.likes);
        displayReviews();
    }

    function filterByStars() {
        const selectedHotel = hotelSelect.value;
        const minStars = parseInt(document.getElementById('filterStars').value);

        if (isNaN(minStars) || minStars < 1 || minStars > 5) {
            alert('Prašome įvesti galiojantį filtrą (1-5 žvaigždutės).');
            return;
        }

        const hotel = hotels[selectedHotel];
        reviewList.innerHTML = '';
        let totalRating = 0;
        let count = 0;

        hotel.reviews.forEach((review, index) => {
            if (review.rating >= minStars) {
                totalRating += review.rating;
                count++;

                const reviewItem = document.createElement('li');
                reviewItem.classList.add('list-group-item');
                
                reviewItem.innerHTML = `
                    <div>
                        <strong>${review.text}</strong> - ${review.rating} žvaigždutės
                        <button onclick="likeReview(${index})" class="btn btn-sm btn-outline-primary">Patinka (${review.likes})</button>
                    </div>
                    <div id="comments-${index}">
                        <label for="commentInput-${index}" class="form-label mt-2">Komentarai:</label>
                        <ul class="list-group">
                            ${review.comments.map(comment => `<li class="list-group-item">${comment}</li>`).join('')}
                        </ul>
                        <input type="text" id="commentInput-${index}" class="form-control mt-2" placeholder="Palikite komentarą">
                        <button onclick="addComment(${index})" class="btn btn-sm btn-secondary mt-2">Pridėti komentarą</button>
                    </div>
                `;
                
                reviewList.appendChild(reviewItem);
            }
        });

        averageRating.textContent = count ? (totalRating / count).toFixed(1) : '0';
    }

    displayReviews();
</script>
@endsection
