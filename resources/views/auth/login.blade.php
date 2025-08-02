@section('title', 'Login - ' . config('app.name'))

<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold text-deep-blue mb-2">Welcome Back!</h2>
        <p class="text-muted">Sign in to your account to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
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
                   autocomplete="username"
                   placeholder="Enter your email address">
            @error('email')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium text-deep-blue">
                <i class="fas fa-lock me-2"></i>Password
            </label>
            <div class="position-relative">
                <input id="password" 
                       type="password" 
                       name="password" 
                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                       required 
                       autocomplete="current-password"
                       placeholder="Enter your password">
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
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label text-muted" for="remember_me">
                    Remember me for 30 days
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-golden btn-lg py-3">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
        </div>

        <!-- Links -->
        <div class="text-center">
            @if (Route::has('password.request'))
                <div class="mb-3">
                    <a class="auth-link" href="{{ route('password.request') }}">
                        <i class="fas fa-key me-1"></i>Forgot your password?
                    </a>
                </div>
            @endif
            
            <div class="border-top pt-3">
                <p class="text-muted mb-2">Don't have an account?</p>
                <a href="{{ route('register') }}" class="btn btn-outline-deep-blue btn-lg px-4">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </a>
            </div>
        </div>
    </form>

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