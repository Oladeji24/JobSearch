@section('title', 'Forgot Password - ' . config('app.name'))

<x-guest-layout>
    <div class="text-center mb-4">
        <div class="bg-golden-yellow bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="fas fa-key fa-2x text-rich-gold"></i>
        </div>
        <h2 class="fw-bold text-deep-blue mb-2">Forgot Password?</h2>
        <p class="text-muted">No problem! Enter your email address and we'll send you a password reset link.</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label fw-medium text-deep-blue">
                <i class="fas fa-envelope me-2"></i>Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus
                   placeholder="Enter your registered email address">
            @error('email')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
            <div class="form-text">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    We'll send a secure link to reset your password
                </small>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-golden btn-lg py-3">
                <i class="fas fa-paper-plane me-2"></i>Send Reset Link
            </button>
        </div>

        <!-- Back to Login -->
        <div class="text-center border-top pt-3">
            <p class="text-muted mb-2">Remember your password?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-deep-blue btn-lg px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to Login
            </a>
        </div>
    </form>

    <!-- Help Section -->
    <div class="mt-4 p-3 bg-light rounded-3">
        <h6 class="fw-bold text-deep-blue mb-2">
            <i class="fas fa-question-circle me-2"></i>Need Help?
        </h6>
        <p class="text-muted mb-2 small">
            If you don't receive the email within a few minutes, please check your spam folder or contact our support team.
        </p>
        <a href="#" class="auth-link small">
            <i class="fas fa-headset me-1"></i>Contact Support
        </a>
    </div>
</x-guest-layout>