@section('title', 'Reset Password - ' . config('app.name'))

<x-guest-layout>
    <div class="text-center mb-4">
        <div class="bg-golden-yellow bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="fas fa-lock-open fa-2x text-rich-gold"></i>
        </div>
        <h2 class="fw-bold text-deep-blue mb-2">Reset Password</h2>
        <p class="text-muted">Create a new secure password for your account</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium text-deep-blue">
                <i class="fas fa-envelope me-2"></i>Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                   value="{{ old('email', $request->email) }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   readonly>
            @error('email')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium text-deep-blue">
                <i class="fas fa-lock me-2"></i>New Password
            </label>
            <div class="position-relative">
                <input id="password" 
                       type="password" 
                       name="password" 
                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                       required 
                       autocomplete="new-password"
                       placeholder="Create a strong new password">
                <button type="button" 
                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                        onclick="togglePassword('password')"
                        style="border: none; background: none; z-index: 10;">
                    <i class="fas fa-eye" id="password-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
            <div class="form-text">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Password must be at least 8 characters long
                </small>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-medium text-deep-blue">
                <i class="fas fa-lock me-2"></i>Confirm New Password
            </label>
            <div class="position-relative">
                <input id="password_confirmation" 
                       type="password" 
                       name="password_confirmation" 
                       class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" 
                       required 
                       autocomplete="new-password"
                       placeholder="Confirm your new password">
                <button type="button" 
                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                        onclick="togglePassword('password_confirmation')"
                        style="border: none; background: none; z-index: 10;">
                    <i class="fas fa-eye" id="password_confirmation-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-golden btn-lg py-3">
                <i class="fas fa-check me-2"></i>Reset Password
            </button>
        </div>

        <!-- Back to Login -->
        <div class="text-center border-top pt-3">
            <a href="{{ route('login') }}" class="btn btn-outline-deep-blue btn-lg px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to Login
            </a>
        </div>
    </form>

    <!-- Security Tips -->
    <div class="mt-4 p-3 bg-light rounded-3">
        <h6 class="fw-bold text-deep-blue mb-2">
            <i class="fas fa-shield-alt me-2"></i>Security Tips
        </h6>
        <ul class="text-muted mb-0 small">
            <li>Use a combination of letters, numbers, and symbols</li>
            <li>Make it at least 8 characters long</li>
            <li>Don't use personal information like your name or birthday</li>
            <li>Consider using a password manager</li>
        </ul>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById(fieldId + '-eye');
            
            if (field.type === 'password') {
                field.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>