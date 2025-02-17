<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Rated Skate Spots</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skateModal.css') }}">
    <link rel="shortcut icon" href="#" />


</head>
<body>
    <nav class="navbar border navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ Auth::check() ? route('home') : route('welcome') }}">
                <img src="{{ asset('images/Logo2.svg') }}" alt="Logo" height="60" class="d-inline-block align-text-top">
            </a>            
            <!-- Hamburger Menu (for mobile view) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    @auth
                    <a class="nav-link" href="{{ route('profile.show', ['username' => Auth::user()->username]) }}">Profile</a>
                    @endauth    
                </li>
                <li class="nav-item">
                    @auth
                        <a class="nav-link" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                
                    @guest
                        <a class="nav-link" href="{{ route('login') }}" style="border: none; background: none; color: rgb(9, 89, 250);">Login</a>
                    @endguest
                </li>                
            </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Top Rated Skate Spots</h2>

        <!-- Sorting and Filtering Form -->
        <form method="GET" action="{{ route('topSpots') }}" class="mb-4">
            <div class="row">
                <div class=" p-2 col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="all">All</option>
                        <option value="skatepark">Skatepark</option>
                        <option value="street_spot">Street Spot</option>
                        <option value="skate_shop">Skate Shop</option>
                    </select>
                </div>
                <div class="col-md-3 p-2">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control" placeholder="Enter location">
                </div>
                <div class="col-md-3 p-2">
                    <label for="rating" class="form-label">Minimum Rating</label>
                    <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" step="0.1" placeholder="Enter rating">
                </div>
                <div class="col-md-3 p-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class = "userProfileTable">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr >
                            <th class="rank text-center align-middle">Rank</th>
                            <th class="rank text-center align-middle">Image</th>
                            <th class="rank text-center align-middle">Title</th>
                            <th >Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSpots as $spot)
                            <tr data-id="{{$spot->id}}" >
                                <td  class="rank text-center align-middle"><strong>{{ $loop->iteration }}</strong></td>
                                <td class="rank text-center align-middle">
                                    @if($spot->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $spot->images->first()->path) }}"  alt="{{ $spot->title }}" style="width: 200px; height: 200px;">

                                    @else
                                        <p>No image available.</p>
                                    @endif
                                </td>
                                <td class="rank text-center align-middle">
                                    <a href="{{ url('home/skate-spot/' . $spot->id) }}">{{ $spot->title }}</a>
                                </td>
                                <td class="rank text-center align-middle">
                                    
                                    <div class="userStarRating d-flex">
                                        <p class="average" style="padding-right: 0.5rem;">({{ number_format($spot->reviews_avg_rating, 1) }})</p>
                                        <div class="reviews">
                                        </div>
                                        <p class="count" style="padding-left: 0.5rem;">({{ $spot->reviews->count() }})</p>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No top-rated skate spots available.</td>
                            </tr>
                        @endforelse
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const spots = @json($topSpots);
            spots.forEach(spot => {
                const rating = spot.reviews_avg_rating;
                const fullStars = Math.floor(rating);
                const halfStar = rating - fullStars >= 0.5 ? 1 : 0;
                const emptyStars = 5 - fullStars - halfStar;
                console.log(fullStars, halfStar, emptyStars);   
                const starRatingHtml = [];
                for (let i = 1; i <= fullStars; i++) {
                    starRatingHtml.push('<span class="fa fa-star checked"></span>');
                }
                if (halfStar) {
                    starRatingHtml.push('<span class="fa fa-star half"></span>');
                }
                for (let i = 1; i <= emptyStars; i++) {
                    starRatingHtml.push('<span class="fa fa-star"></span>');
                }


                const starRatingContainer = document.querySelector(`tr[data-id="${spot.id}"] .reviews`);
                if (starRatingContainer) {
                    starRatingContainer.innerHTML = starRatingHtml.join('');
                }
                console.log(starRatingContainer);
            });
        });
    </script>
</body>
@include('layouts.footer')

</html>