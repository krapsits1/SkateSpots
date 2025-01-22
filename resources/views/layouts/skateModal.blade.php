

<div class="modal fade" id="skateSpotViewModal" tabindex="-1" aria-labelledby="skateSpotViewModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="skateSpotViewModalLabel">Skate Spot Details</h5>
                <h5 class="p-2" id="skateSpotID">{{$selectedSkateSpot->id}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Navigation Tabs for Overview and Reviews -->
                <ul class="nav nav-tabs" id="modalTab" role="tablist">
                    <li class="nav-item">
                        <a 
                            class="nav-link active" 
                            id="overview-tab" 
                            data-bs-toggle="tab" 
                            href="#overview" 
                            role="tab" 
                            aria-controls="overview" 
                            aria-selected="true"> Overview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                </ul>
                <div class="tab-content" id="modalTabContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="pt-3">
                            <div onclick="seeUserProfile(this.querySelector('#username').textContent)" class="skateModal-profile d-flex flex-row align-items-center">
                                <img id="userProfilePic" src="" class="skateModal-profile-pic" alt="skateModalProfilePic">
                                <h5 class="pr-6" id="username">username</h5>
                            </div>  
                            <div class="d-flex justify-content-between align-items-center pt-2">
                                <h5 class="" id="modalTitle">{{ $selectedSkateSpot->title }}</h5>
                                <p class="date" id="modalDate">{{ $selectedSkateSpot->created_at->format('Y-m-d') }}</p>
                            </div>
                            <div id="carouselExampleControls" class="carousel slide pt-2" data-bs-ride="carousel">
                                <div class="carousel-inner"></div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                            <hr>
                            <h5 class="pt-2">Description</h5>
                            <p id="modalDescription">Description</p>
                            <h5>Location</h5>
                            <div class="d-flex align-items-center border rounded">
                                <span class="location p-2" id="modalLatitude">Latitude</span>, <span class="location p-2" id="modalLongitude">Longitude</span>
                                <button type="button" onclick="copyCoordinatesToClipboard()" class="btn btn-primary p-2 ms-auto">Copy</button>
                            </div>
                        </div>
                    </div>
                    <!-- Reviews Section -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="pt-3">

                            <div class="totalCount d-flex justify-content-center">
                                <p class="average" style="padding-right: 0.5rem;">()</p>
                                <div class="star-rating-total-count ">
                                    <span class="fa fa-star" data-rating="1"></span>
                                    <span class="fa fa-star" data-rating="2"></span>
                                    <span class="fa fa-star" data-rating="3"></span>
                                    <span class="fa fa-star" data-rating="4"></span>
                                    <span class="fa fa-star" data-rating="5"></span>
                                </div>
                                <p class="count" style="padding-left: 0.5rem;">()</p>
                            </div>
                            <div class="d-flex justify-content-center p-2">
                                @if(Auth::check())    
                                    <button type="button" class="btn btn-secondary" id="showAddReviewButton" onclick="showAddReviewModal()">Write a review</button>                    
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-secondary p-2 ">Write a review</a>
                                @endif
                            </div>
                            <div id="reviewsContent" style="max-height: 300px; overflow-y: auto;">
                                <!-- Reviews will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    
    </div>
</div>


<div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel">
    @auth

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReviewModalLabel">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center pt-2">
                    <h5 class="" id="addReviewModalTitle">{{ $selectedSkateSpot->title }}</h5>
                    <p class="date" id="addReviewModalDate">{{ $selectedSkateSpot->created_at->format('Y-m-d') }}</p>
                </div>
                
                <div onclick="seeUserProfile(this.querySelector('#username').textContent)" class="skateModal-profile pt-2 d-flex flex-row align-items-center">
                    <img id="userProfilePicture" src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : '/images/person.svg' }}" class="skateModal-profile-pic" alt="skateModalProfilePic">
                    <h5 class="pr-6" id="username">{{ auth()->user()->username }}</h5>  
                </div>
                <form id="addReviewModalID" action="{{route('skate-spots.addReview',['id' => $selectedSkateSpot->id])}}" method="POST">
                    @csrf
                    <div class="star-rating-container">
                        <div class="d-flex justify-content-center p-4">
                            <div class="star-rating">
                                <span class="fa fa-star" data-rating="1"></span>
                                <span class="fa fa-star" data-rating="2"></span>
                                <span class="fa fa-star" data-rating="3"></span>
                                <span class="fa fa-star" data-rating="4"></span>
                                <span class="fa fa-star" data-rating="5"></span>
                            </div>
                        </div>
                        <!-- Hidden input for the rating value -->
                        <input type="hidden" id="rating" name="rating" value="">
                    </div> 
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
    @endauth

</div>


    
