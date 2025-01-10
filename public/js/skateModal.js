function showModalskate(row) {
    console.log("row",row);
    const skateSpotId = row.getAttribute('data-id');
    console.log(skateSpotId);
    fetch(`/admin/skate-spot/${skateSpotId}`) ///admin/skate-spot/${skateSpotId}
        .then(response => response.json())
        .then(data => {
            console.log("bURRRRRRRRRRRR");
            document.getElementById('username').textContent = data.skateSpot.user.username;

            document.getElementById('userProfilePic').src = data.skateSpot.user.profile_picture ? '/storage/' + data.skateSpot.user.profile_picture : '/images/person.svg';
            document.getElementById('username').textContent = data.skateSpot.user.username;
            document.getElementById('modalTitle').textContent = data.skateSpot.title;
            document.getElementById('modalDate').textContent = new Date(data.skateSpot.created_at).toLocaleDateString();
            document.getElementById('modalDescription').textContent = data.skateSpot.description;
            document.getElementById('modalLatitude').textContent = data.skateSpot.latitude;
            document.getElementById('modalLongitude').textContent = data.skateSpot.longitude;

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

            var myModal = new bootstrap.Modal(document.getElementById('skateSpotViewModal'));
            myModal.show();

        })
        .catch(error => console.error('Error fetching skate spot details:', error));
}

function copyCoordinatesToClipboard() {
    const latitudeText = document.getElementById('modalLatitude').innerText;
    const longitudeText = document.getElementById('modalLongitude').innerText;

    // Combine the coordinates into a single string
    const coordinates = `${latitudeText}, ${longitudeText}`;

    // Use the Clipboard API to copy the coordinates to clipboard
    navigator.clipboard.writeText(coordinates)
        .then(() => {
            alert("Coordinates copied to clipboard!");
        })
        .catch(err => {
            console.error("Failed to copy text: ", err);
        });
}



function showModalSkatePost(row) {
    const skateSpotId = row.getAttribute('data-id');
    fetch(`/home/skate-spot/post/${skateSpotId}`) ///admin/skate-spot/${skateSpotId}
        .then(response => response.json())
        .then(data => {
            document.getElementById('username').textContent = data.skateSpot.user.username;

            document.getElementById('userProfilePic').src = data.skateSpot.user.profile_picture ? '/storage/' + data.skateSpot.user.profile_picture : '/images/person.svg';
            document.getElementById('username').textContent = data.skateSpot.user.username;
            document.getElementById('modalTitle').textContent = data.skateSpot.title;
            document.getElementById('modalDate').textContent = new Date(data.skateSpot.created_at).toLocaleDateString();
            document.getElementById('modalDescription').textContent = data.skateSpot.description;
            document.getElementById('modalLatitude').textContent = data.skateSpot.latitude;
            document.getElementById('modalLongitude').textContent = data.skateSpot.longitude;

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

            var myModal = new bootstrap.Modal(document.getElementById('userProfileSkateModal'));
            myModal.show();

            // document.querySelector('body').setAttribute('inert', 'true');

            // // Remove inert attribute when modal is hidden
            // document.getElementById('skateSpotViewModal').addEventListener('hidden.bs.modal', function () {
            //     document.querySelector('body').removeAttribute('inert');
            // });
        })
        .catch(error => console.error('Error fetching skate spot details:', error));
}


