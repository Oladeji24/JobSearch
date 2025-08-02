@section('title', 'Register - ' . config('app.name'))

<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold text-deep-blue mb-2">Join Our Community!</h2>
        <p class="text-muted">Create your account and start your career journey</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Role Selection -->
        <div class="mb-4">
            <label class="form-label fw-medium text-deep-blue">
                <i class="fas fa-users me-2"></i>I want to:
            </label>
            <div class="row g-2">
                <div class="col-6">
                    <input type="radio" class="btn-check" name="role" id="job_seeker" value="job_seeker" 
                           {{ old('role', request('role')) == 'job_seeker' || !old('role') && !request('role') ? 'checked' : '' }}>
                    <label class="btn btn-outline-deep-blue w-100 py-3" for="job_seeker">
                        <i class="fas fa-search d-block mb-2"></i>
                        <strong>Find Jobs</strong>
                        <small class="d-block text-muted">Job Seeker</small>
                    </label>
                </div>
                <div class="col-6">
                    <input type="radio" class="btn-check" name="role" id="employer" value="employer"
                           {{ old('role', request('role')) == 'employer' ? 'checked' : '' }}>
                    <label class="btn btn-outline-deep-blue w-100 py-3" for="employer">
                        <i class="fas fa-building d-block mb-2"></i>
                        <strong>Hire Talent</strong>
                        <small class="d-block text-muted">Employer</small>
                    </label>
                </div>
            </div>
            @error('role')
                <div class="text-danger mt-2">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-medium text-deep-blue">
                <i class="fas fa-user me-2"></i>Full Name
            </label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name"
                   placeholder="Enter your full name">
            @error('name')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

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
                       autocomplete="new-password"
                       placeholder="Create a strong password">
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
                <i class="fas fa-lock me-2"></i>Confirm Password
            </label>
            <div class="position-relative">
                <input id="password_confirmation" 
                       type="password" 
                       name="password_confirmation" 
                       class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" 
                       required 
                       autocomplete="new-password"
                       placeholder="Confirm your password">
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

        <!-- Terms and Conditions -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input @error('terms') is-invalid @enderror" 
                       type="checkbox" 
                       id="terms" 
                       name="terms" 
                       required>
                <label class="form-check-label text-muted" for="terms">
                    I agree to the <a href="#" class="auth-link">Terms of Service</a> and 
                    <a href="#" class="auth-link">Privacy Policy</a>
                </label>
                @error('terms')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-golden btn-lg py-3">
                <i class="fas fa-user-plus me-2"></i>Create Account
            </button>
        </div>

        <!-- Links -->
        <div class="text-center border-top pt-3">
            <p class="text-muted mb-2">Already have an account?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-deep-blue btn-lg px-4">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </a>
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

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strength = getPasswordStrength(password);
            // You can add password strength indicator here if needed
        });

        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }
    </script>
</x-guest-layout>