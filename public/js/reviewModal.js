const currentPath = window.location.pathname;

document.addEventListener('DOMContentLoaded', function () {
    const observer = new MutationObserver(function (mutationsList, observer) {
        const addReviewModal = document.getElementById('addReviewModal');
        if (addReviewModal) {
            console.log('addReviewModal dynamically added to the DOM.');
            observer.disconnect(); // Stop observing once the modal is found
            attachModalEventListeners();
        }
    });

    // Start observing changes to the body
    observer.observe(document.body, { childList: true, subtree: true });
});

function attachModalEventListeners() {
    const addReviewModal = document.getElementById('addReviewModal');
    if (addReviewModal) {
        addReviewModal.addEventListener('show.bs.modal', function () {
            const skateModal = bootstrap.Modal.getInstance(document.getElementById('skateSpotViewModal'));
            if (skateModal && skateModal._isShown) {
                skateModal.hide();
            }
        });

    }
}



function showAddReviewModal() {

    const addReviewModalElement = document.getElementById('addReviewModal');

    const addReviewModal = new bootstrap.Modal(addReviewModalElement);
    addReviewModal.show();
}

document.addEventListener('click', function (event) {
    const star = event.target;
    if (star.classList.contains('fa') && star.closest('.star-rating')) {
        console.log('Star clicked:', star);

        const rating = star.getAttribute('data-rating');
        const stars = star.closest('.star-rating').querySelectorAll('.fa');
        const ratingInput = document.getElementById('rating');

        if (ratingInput) {
            ratingInput.value = rating;
        }

        // Highlight the stars up to the clicked star
        stars.forEach((s, index) => {
            if (index < rating) {
                s.classList.add('checked');
            } else {
                s.classList.remove('checked');
            }
        });
    }
});

    
