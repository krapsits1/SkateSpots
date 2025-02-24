<!-- filepath: resources/views/emails/newSkateSpotAdded.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>New Skate Spot Added</title>
</head>
<body>
    <h1>A new skate spot has been added!</h1>
    <p>Title : {{ $skateSpot->title }}</p>
    <p>Description : {{ $skateSpot->description }}</p>
    <p>Category : {{ $skateSpot->category }}</p>

</body>
</html>