<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body>
    @include('layouts.banner')
    @include('layouts.homeNav')
    <div class="m-3 text-center mx-auto" style="max-width: 80%;">
        <h1>
            Discover and Share the Best Skate Spots
        </h1>
        <p>Explore local skateparks, street spots, and hidden gems.</p>    
    </div>
    <div class="mb-3 d-flex justify-content-center align-items-center">
    <!-- If the user is not authenticated, redirect them to the login page -->
        <a href="{{ route('login') }}" class="btn btn-primary" id="add-skate-spot">
            Add Skate Spot
        </a>
    </div>
    <div class="text-center">
        <input id="searchBox" type="text" class="mb-3 form-control mx-auto" placeholder="Enter a location" style="width: 60%;">
    </div>
    <div id="map"></div>
    <script>
        const isAuthenticated = @json(Auth::check());
        var skateSpots = @json($skateSpots);
        window.MAP_ID = "{{ env('GOOGLE_MAPS_IDS') }}";
        const categoryIcons = {
        street_spot: "{{ url('storage/icons/street_spot_icon.png') }}",
        skatepark: "{{ url('storage/icons/skatepark_icon.png') }}",
        skate_shop: "{{ url('storage/icons/skate_shop_icon.png') }}",
        };
    </script>

    {{-- strandarta request --}}
    {{-- Šis ir vajdzīgs lai parādās skateModal, ja user ievada url ar skateSpot --}}
    @if(isset($selectedSkateSpot))

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const skateSpot = @json($selectedSkateSpot);
                
                const carouselInner = document.querySelector('#carouselExampleControls .carousel-inner');
                carouselInner.innerHTML = ''; // Clear existing items
                
                skateSpot.images.forEach((image, index) => {

                    const activeClass = index === 0 ? 'active' : '';

                    carouselInner.innerHTML += `
                        <div class="carousel-item ${activeClass}">
                            <img class="d-block w-100" src="/storage/${image.path}" alt="Slide ${index + 1}">
                        </div>  
                    `;
                });

                
                document.getElementById('userProfilePic').src = skateSpot.user.profile_picture ? '/storage/' + skateSpot.user.profile_picture : '/images/person.svg';

                document.getElementById('username').textContent = skateSpot.user.username;
                document.getElementById('modalTitle').textContent = skateSpot.title;
                document.getElementById('modalDate').textContent = new Date(skateSpot.created_at).toLocaleDateString();
                document.getElementById('modalDescription').textContent = skateSpot.description;
                document.getElementById('modalLatitude').textContent = skateSpot.latitude;
                document.getElementById('modalLongitude').textContent = skateSpot.longitude;


                const reviews = skateSpot.reviews;
                const reviewCount = reviews.length;
                let totalRating = 0;
                reviews.forEach(review => {
                    totalRating += review.rating;
                });

                const averageRating = reviewCount > 0 ? (totalRating / reviewCount).toFixed(1) : 0;
                const averageElement = document.querySelector('.totalCount .average');
                const countElement = document.querySelector('.totalCount .count');

                if (averageElement) {
                    averageElement.textContent = `(${averageRating})`;
                }
                if (countElement) {
                    countElement.textContent = `(${reviewCount})`;
                }
                const starRatingElement = document.querySelector('.star-rating-total-count');

                const stars = starRatingElement.querySelectorAll('.fa');
                stars.forEach((star, index) => {
                    const starValue = index + 1;
                    star.classList.remove('checked', 'half'); // Remove previous classes

                    if (averageRating >= starValue) {
                        star.classList.add('checked');
                    } else if (averageRating >= starValue - 0.5) {
                        // star.classList.add('fa-star-half');
                        star.classList.add('half');

                    }
                });

                const reviewsContent = document.getElementById('reviewsContent');
                reviewsContent.innerHTML = ''; // Clear existing reviews

                if (Array.isArray(reviews) && reviews.length > 0) {
                    reviews.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                    reviews.forEach(review => {
                        let starRatingHtml = '';
                        for (let i = 1; i <= 5; i++) {
                            starRatingHtml += `<span class="fa fa-star ${i <= review.rating ? 'checked' : ''}"></span>`;
                        }
                
                        reviewsContent.innerHTML += `
                        <div class="review">
                            <hr>
                            <div class="review-header d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center" onclick="seeUserProfile('${review.user.username}')" style = "cursor: pointer;">
                                    <img src="${review.user.profile_picture ? '/storage/' + review.user.profile_picture : '/images/person.svg'}" class="review-profile-pic" alt="Profile Picture">
                                    <span class="review-username">${review.user.username}</span>
                                </div>
                                <div class="userStarRating">
                                    ${starRatingHtml}
                                </div>
                            </div>
                            <p class="review-content">${review.content}</p>

                            <p><small>${new Date(review.created_at).toLocaleDateString()}</small></p>
                            <hr>
                        </div>
                    `;
                    });
                } else {
                    reviewsContent.innerHTML = '<p>No reviews yet. Be the first to add one!</p>';
                }

                var myModal = new bootstrap.Modal(document.getElementById('skateSpotViewModal'));
                myModal.show();

                
            });


        </script>
            @include('layouts.skateModal', ['skateSpot' => $selectedSkateSpot])

    @endif


    <script src="{{ asset('js/map.js') }}" defer></script>
    {{-- <script src="{{ asset('js/userProfile.js') }}" defer></script> --}}
    <script src="{{ asset('js/reviewModal.js') }}" defer></script>
    {{-- <script src="{{ asset('js/skateModal.js') }}" defer></script> --}}

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places,marker&map_ids={{ env('GOOGLE_MAPS_IDS') }}&loading=async"></script>
</body>
@include('layouts.footer')
</html>
