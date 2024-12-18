let map;
let marker;


window.initMap = function() {
    
    const initialLocation = { lat: 56.9, lng: 24.1 }; 

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: initialLocation,
        mapId: '9228c432fa6bf187'
    });

    loadSkateSpots();

    // Add click event to map for placing the marker
    map.addListener('click', function(event) {
        if (map.get('draggableCursor') === 'crosshair') { // Only allow marker placement if cursor is crosshair
            placeMarker(event.latLng);
            showModal(); // Show the modal form
            resetCursor(); // Reset the cursor back to default after placing the marker
        }
    });

    
};

// Function to place or update the marker
function placeMarker(location) {
    if (marker) {
        marker.setPosition(location); // Update marker position if it already exists
    } else {
        marker = new google.maps.marker.AdvancedMarkerElement({
            position: location,
            map: map,
        });
    }

    // Set latitude and longitude in the form inputs
    document.getElementById('latitude').value = location.lat();
    document.getElementById('longitude').value = location.lng();

        // Log the value
}

// Function to reset the map cursor back to default
function resetCursor() {
    map.setOptions({ draggableCursor: null });  
}

// Function to show the Bootstrap modal
function showModal() {
    const skateSpotModal = new bootstrap.Modal(document.getElementById('skateSpotModal'));
        skateSpotModal.show();
    // Ensure latitude and longitude are set

}
// Cache DOM elements for better performance
const addSkateSpotButton = document.getElementById('add-skate-spot');
const notification = document.getElementById('popup-notification');

// Handle "Add Skate Spot" button click
addSkateSpotButton.addEventListener('click', function() {
    // Change the map cursor to crosshair
    map.setOptions({ draggableCursor: 'crosshair' });

    // Show the pop-up notification
    notification.style.display = 'block';
    notification.style.opacity = '1';

    // Hide the notification after 2 seconds
    setTimeout(function() {
        notification.style.opacity = '0';
        setTimeout(function() {
            notification.style.display = 'none';
        }, 500); // Wait for opacity transition to complete
    }, 2000); // Show for 2 seconds

});

function updateHistoryState(spotId) {
    history.pushState({ spotId: spotId }, '', getFetchUrl(spotId));
}

function handleModalClose() {
    const currentPath = window.location.pathname;
    const newPath = currentPath.startsWith('/home') ? '/home' : '/';
    history.replaceState({}, '', newPath);
}


function loadSkateSpots() {
    skateSpots.forEach(spot => {
        const spotLatLng = new google.maps.LatLng(spot.latitude, spot.longitude);
        const marker = new google.maps.marker.AdvancedMarkerElement({
            position: spotLatLng,
            map: map,
            title: spot.title,
        });

        marker.addListener('click', function() {
            fetch(getFetchUrl(spot.id), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                // Insert modal HTML into the DOM
                document.body.insertAdjacentHTML('beforeend', data.modalHtml);


                var myModal = new bootstrap.Modal(document.getElementById('skateSpotViewModal'));
                myModal.show();


                updateHistoryState(spot.id);

                // Add event listener for when the modal is hidden
                document.getElementById('skateSpotViewModal').addEventListener('hidden.bs.modal', handleModalClose);
                // Update carousel with images
                const carouselInner = document.querySelector('#carouselExampleControls .carousel-inner');
                carouselInner.innerHTML = ''; // Clear existing items
                const images = data.skateSpot.images;
                if (Array.isArray(images) && images.length > 0) {
                    images.forEach((image, index) => {
                        const activeClass = index === 0 ? 'active' : '';
                        carouselInner.innerHTML += `
                            <div class="carousel-item ${activeClass}">
                                <img class="d-block w-100" src="/storage/${image.path}" alt="Slide ${index + 1}">
                            </div>  
                        `;
                    });
                } else {
                    console.warn('No images found for this skate spot.');
                }

                // Update user profile picture and details
                document.getElementById('userProfilePic').src = data.skateSpot.user.profile_picture ? '/storage/' + data.skateSpot.user.profile_picture : '/images/person.svg';
                document.getElementById('username').textContent = data.skateSpot.user.username;
                document.getElementById('modalTitle').textContent = data.skateSpot.title;
                document.getElementById('modalDate').textContent = new Date(data.skateSpot.created_at).toLocaleDateString();
                document.getElementById('modalDescription').textContent = data.skateSpot.description;
                document.getElementById('modalLatitude').textContent = data.skateSpot.latitude;
                document.getElementById('modalLongitude').textContent = data.skateSpot.longitude;

                const reviews = data.skateSpot.reviews;
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
                stars.forEach((star, index) => {
                    const starValue = index + 1;
                    star.classList.remove('checked', 'half'); // Remove previous classes

                    if (averageRating >= starValue) {
                        star.classList.add('checked');
                    } else if (averageRating >= starValue - 0.5) {
                        star.classList.add('half');
                        // star.classList.add('fa-star-half');

                    }
                });

                // Update reviews section
                const reviewsContent = document.getElementById('reviewsContent');
                reviewsContent.innerHTML = ''; // Clear existing reviews
                // const reviews = data.skateSpot.reviews;
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


                // Update history state
                  
                    
                
            })
            .catch(error => console.error('Error fetching skate spot details:', error));
        });
    });
}

function getFetchUrl(spotId) {
    return currentPath.startsWith('/home')
        ? `/home/skate-spot/${spotId}`
        : `/skate-spot/${spotId}`;
}


document.addEventListener('DOMContentLoaded', () => {
    const skateSpotModal = document.getElementById('skateSpotViewModal');
    if (skateSpotModal) {
        // Add event listener for when the modal is shown
        skateSpotModal.addEventListener('shown.bs.modal', function () {
            skateSpotModal.removeAttribute('inert');
        });

        // Add event listener for when the modal is hidden
        skateSpotModal.addEventListener('hidden.bs.modal', function () {
            skateSpotModal.setAttribute('inert', '');
            const currentPath = window.location.pathname;
            const newPath = currentPath.startsWith('/home') ? '/home' : '/';
            history.replaceState({}, '', newPath);
        });
    }
});


function seeUserProfile(row){
    const username = row.getAttribute('data-username');
    window.location.href = `/profile/${username}`;
}



