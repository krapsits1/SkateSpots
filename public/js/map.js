let map;
let marker;


// Initialize the map and set default behavior
window.initMap = function() {
    
    const initialLocation = { lat: 56.9, lng: 24.1 }; // Central point of the Baltic States

    // Initialize Google Map
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: initialLocation,
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
        marker = new google.maps.Marker({
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

function loadSkateSpots() {
    // Assume skateSpots variable contains data passed from the server
    skateSpots.forEach(spot => {
        const spotLatLng = new google.maps.LatLng(spot.latitude, spot.longitude);

        // Add a marker for each skate spot
        new google.maps.Marker({
            position: spotLatLng,
            map: map,
            title: spot.title, // Optional: add the title of the skate spot to the marker
        });
    });
}

function showModalskate(row) {
    // Get data from the clicked row's data attributes
    const title = row.getAttribute('data-title');
    const description = row.getAttribute('data-description');
    const latitude = row.getAttribute('data-latitude');
    const longitude = row.getAttribute('data-longitude');
    const images = JSON.parse(row.getAttribute('data-images'));
    const date = row.getAttribute('data-date');
    console.log(images);
    // Update modal title and description
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalDescription').innerText = description;

    // Update carousel
    const carouselInner = document.querySelector('#carouselExampleControls .carousel-inner');
    carouselInner.innerHTML = ''; // Clear existing items



    images.forEach((image, index) => {
        console.log(image)
        const activeClass = index === 0 ? 'active' : '';

        carouselInner.innerHTML += `
            <div class="carousel-item ${activeClass}">
                <img class="d-block w-100" src="${image}" alt="Slide ${index + 1}">
            </div>  
        `;
    });


    // Insert data into the modal elements
    document.getElementById('modalDate').textContent = date;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description;
    document.getElementById('modalLatitude').textContent = latitude;
    document.getElementById('modalLongitude').textContent = longitude;

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('skateSpotModal'));
    modal.show();
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

function seeUserProfile(row){
    const username = row.getAttribute('data-username');
    window.location.href = `/profile/${username}`;
}