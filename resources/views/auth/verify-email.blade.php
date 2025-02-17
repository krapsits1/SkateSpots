<div class="container">
    <h2>Email Verification</h2>
    <p>Before accessing your account, please verify your email address.</p>
    
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('verification.resend') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
</div>