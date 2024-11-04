<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
<body>
    @include('layouts.adminNav')
    <div class="container my-5">
        <div class="d-flex justify-content-center align-items-center p-3">
            @auth
                <!-- If the user is authenticated, allow them to add a skate spot -->
                <a href="#skateSpotModal" class="btn btn-primary p-2" data-bs-toggle="modal">
                    Add Skate Spot
                </a>
            @else
                <!-- If the user is not authenticated, redirect them to the login page -->
                <a href="{{ route('login') }}" class="btn btn-primary p-2">
                    Add Skate Spot
                </a>
            @endauth
        </div>
        <h1>All Skate Spots</h1>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="container" style="overflow-x:auto;">
            <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($skateSpots as $skateSpot)
                            <tr 
                                onclick="showModalskate(this)" 
                                data-title="{{ $skateSpot->title }}" 
                                data-description="{{ $skateSpot->description }}" 
                                data-date="{{ $skateSpot->created_at->format('Y-m-d H:i')}}"
                                data-latitude="{{ $skateSpot->latitude }}" 
                                data-longitude="{{ $skateSpot->longitude }}"
                                data-images="{{ json_encode($skateSpot->images->map(fn($image) => asset('storage/' . $image->path))) }}"
                                style="cursor: pointer;">

                                <td>{{ $skateSpot->title }}</td>
                                <td>{{ $skateSpot->description }}</td>
                                <td>{{ $skateSpot->latitude }}</td>
                                <td>{{ $skateSpot->longitude }}</td>
                                <td>{{ $skateSpot->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ ucfirst($skateSpot->status) }}</td>
                                <td>{{ $skateSpot->category }}</td>
                                <td>
                                    <!-- Approve Button -->
                                    @if($skateSpot->status === 'pending')
                                        <form action="{{ route('admin.approveSkateSpot', $skateSpot->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                    @endif

                                    <!-- Deny/Delete Button -->
                                    <form action="{{ route('admin.denySkateSpot', $skateSpot->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No skate spots available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
              </div>
        </div>
    </div>
    @include('layouts.skateModal')

    <script src="{{ asset('js/map.js') }}" defer></script>
    {{-- <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBkdtxqdCf-scid2G_zSmHhDDOMxkBznvk&callback=initMap"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
