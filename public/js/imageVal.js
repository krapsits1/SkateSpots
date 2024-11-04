document.getElementById('skate-spot-form').addEventListener('submit', function (event) {
    var imageInput = document.getElementById('images');
    var fileError = document.getElementById('file-error');
    var maxFiles = 5;
    var maxSize = 2 * 1024 * 1024; // 2MB in bytes
    var validFormats = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp', 'image/heic'];
    var files = imageInput.files;

    // Reset error message
    fileError.style.display = 'none';
    fileError.innerHTML = '';

    // Check the number of files
    if (files.length > maxFiles) {
        event.preventDefault();
        fileError.style.display = 'block';
        fileError.innerHTML = 'You can upload a maximum of ' + maxFiles + ' images.';
        return;
    }

    // Check each file's size and format
    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        if (file.size > maxSize) {
            event.preventDefault();
            fileError.style.display = 'block';
            fileError.innerHTML = 'Each image must be smaller than 2MB.';
            return;
        }

        if (!validFormats.includes(file.type)) {
            event.preventDefault();
            fileError.style.display = 'block';
            fileError.innerHTML = 'Invalid file format.';
            return;
        }
    }
});
