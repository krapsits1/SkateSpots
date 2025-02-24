<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SkateSpots</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/skateModal.css') }}">
  <link rel="shortcut icon" href="#" />
  <!-- Add Font Awesome CSS if not already included -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    @include('layouts.banner')
    @include('layouts.homeNav')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class = "m-3">
        <h3>Welcome, {{ Auth::user()->username }}!</h3>
    </div>
    <div class="d-flex justify-content-center align-items-center mb-3">
        <button id="add-skate-spot" class="btn btn-primary">Add Skate Spot</button>
    </div>
    <div id="popup-notification" class="alert alert-info text-center" role="alert" style="display: none;">
        Drop marker in map to add a skate spot.
    </div> 
    <div class="text-center mb-3">
        <input id="searchBox" type="text" class="form-control mx-auto" placeholder="Enter a location" style="width: 60%;">
    </div>     
    <div  id="map">
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
    </div>
 

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

                // Update the review count and average rating
                const averageElement = document.querySelector('.totalCount .average');
                const countElement = document.querySelector('.totalCount .count');
                if (averageElement) {
                    averageElement.textContent = `(${averageRating})`;
                }
                if (countElement) {
                    countElement.textContent = `(${reviewCount})`;
                }

                // Update the star rating display
                const starRatingElement = document.querySelector('.star-rating-total-count');
                const stars = starRatingElement.querySelectorAll('.fa');
                reviews.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                stars.forEach((star, index) => {
                    const starValue = index + 1;
                    star.classList.remove('checked', 'half'); // Remove previous classes

                    if (averageRating >= starValue) {
                        star.classList.add('checked');
                    } else if (averageRating >= starValue - 0.5) {
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

    <div class="modal fade" id="skateSpotModal" tabindex="-1" aria-labelledby="skateSpotModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="skateSpotModalLabel">Add Skate Spot Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="skate-spot-form" action="{{ route('skate-spots.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Dropdown for Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category" id="category" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="skatepark">Skatepark</option>
                                <option value="skate_shop">Skate Shop</option>
                                <option value="street_spot">Street Spot</option>
                            </select>
                        </div>
    
                        <!-- Title Input -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div id="file-error" class="text-danger" style="display: none;">
                            You cannot upload more than 5 images.
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Upload Images (Up to 5)</label>
                            <input 
                                type="file" 
                                class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                                id="images" 
                                name="images[]" 
                                accept="image/*" 
                                multiple 
                                required
                            >
                            
                            <!-- Error for the array (too many files, not an array, etc.) -->
                            @error('images')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                            
                            <!-- Error for each individual image -->
                            @error('images.*')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="container">
                            <ul class="text-start">
                                <li><strong>Formats:</strong> .jpeg .jpg .heic .png .webp</li>
                                <li><strong>Image size:</strong> 2MB (each)</li>
                              </ul> 
                        </div>
    
                        <!-- Description Input -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <!-- Hidden fields for latitude and longitude -->
                        <input type="hidden" name="latitude"    id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <button type="submit" id="submit-skate-spot" class="btn btn-primary">Save Skate Spot</button>
                        <script src="{{ asset('js/imageVal.js') }}" defer></script>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/userProfile.js') }}" defer></script>
    {{-- <script src="{{ asset('js/skateModal.js') }}" defer></script> --}}

    <script src="{{ asset('js/reviewModal.js') }}" defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places,marker&map_ids={{ env('GOOGLE_MAPS_IDS') }}&loading=async"></script>
    <script src="{{ asset('js/map.js') }}" defer></script>

</body>
@include('layouts.footer')  
</html>