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
<body >
    
    @include('layouts.homeNav')
    <main style = "min-height: 75vh">
        <div class="d-flex pt-5 flex-column align-items-center justify-content-center">
            <h1>Coming Soon...</h1>
            <div class="container text-center">
                <p class="lead">We are working on something awesome! Stay tuned.</p>

                <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>        
            </div>
        </div>
    </main>
</body>
@include('layouts.footer')

</html>