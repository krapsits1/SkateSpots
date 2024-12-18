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

        <h2 class="pt-2">Users ({{ $totalUsers }})</h2>
        <div class="container" style="overflow-x:auto;">
            <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Date</th>  
                            <th>Role</th>  

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr                                 
                                onclick="seeUserProfile('{{ $user->username }}')" 
                                data-username="{{ $user->username }}" 
                                style="cursor: pointer;">
                                
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $user->role }}</td>

                        
                                <td>
                                    <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No newly added users.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/userProfile.js') }}" defer></script>
</body>
</html>