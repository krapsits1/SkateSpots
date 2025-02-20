<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
<body>
    @include('layouts.adminNav')
    <div class="container my-5">

        <h1>All Skate Spots ({{ $totalSkateSpots }})</h1>

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
                            <th>User</th>
                            <th>Title</th>
                            <th>Description</th>
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
                                data-id="{{ $skateSpot->id }}"

                                data-username="{{ $skateSpot->user->username }}" 
                                data-title="{{ $skateSpot->title }}" 
                                data-description="{{ $skateSpot->description }}" 
                                data-date="{{ $skateSpot->created_at->format('Y-m-d H:i')}}"
                                data-latitude="{{ $skateSpot->latitude }}" 
                                data-longitude="{{ $skateSpot->longitude }}"
                                data-images="{{ json_encode($skateSpot->images->map(fn($image) => asset('storage/' . $image->path))) }}"
                                style="cursor: pointer;">

                                <td><button onclick="seeUserProfile('{{ $skateSpot->user->username }}')">{{ $skateSpot->user->username }}</button></td>
                                <td>{{ $skateSpot->title }}</td>
                                <td>{{ $skateSpot->description }}</td>
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
    @if($skateSpots->isNotEmpty())
        @include('layouts.skateModal', ['selectedSkateSpot' => $selectedSkateSpot])
    @endif

    <script src="{{ asset('js/skateModal.js') }}" defer></script>
    <script src="{{ asset('js/userProfile.js') }}" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
