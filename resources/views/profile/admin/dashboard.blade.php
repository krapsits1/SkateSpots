<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
<body>
    @include('layouts.adminNav')

    <div class="container">


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="d-flex justify-content-center">
            <h2 style="padding: 2px">Admin Dashboard</h2>
        </div>
        <h2>Newly Added Skate Spots</h2>
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
                            <th>Category</th>
                            <th>Actions</th>    
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($newSkateSpots as $skateSpot)
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
                                <td>{{ $skateSpot->category }}</td>
                                <td>
                                    <form action="{{ route('admin.approveSkateSpot', $skateSpot->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.denySkateSpot', $skateSpot->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Deny</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No newly added skate spots.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layouts.skateModal')
    <script src="{{ asset('js/map.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap JS -->
</body> 
</html>
