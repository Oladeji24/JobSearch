<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Job Board'))</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-blue': '#1E3A8A',
                        'golden-yellow': '#FBBF24',
                        'rich-gold': '#D97706',
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1E3A8A 0%, #1E40AF 100%);
            min-height: 100vh;
        }
        
        .auth-bg {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(30, 64, 175, 0.95) 100%), 
                        url('https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .auth-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .form-control:focus {
            border-color: #FBBF24;
            box-shadow: 0 0 0 0.2rem rgba(251, 191, 36, 0.25);
        }
        
        .btn-golden {
            background: linear-gradient(135deg, #FBBF24 0%, #D97706 100%);
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-golden:hover {
            background: linear-gradient(135deg, #D97706 0%, #FBBF24 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(217, 119, 6, 0.3);
        }
        
        .btn-deep-blue {
            background-color: #1E3A8A;
            border-color: #1E3A8A;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-deep-blue:hover {
            background-color: #1E40AF;
            border-color: #1E40AF;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
        }
        
        .text-deep-blue {
            color: #1E3A8A !important;
        }
        
        .text-golden-yellow {
            color: #FBBF24 !important;
        }
        
        .text-rich-gold {
            color: #D97706 !important;
        }
        
        .auth-link {
            color: #1E3A8A;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .auth-link:hover {
            color: #D97706;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .alert-success {
            background-color: rgba(251, 191, 36, 0.1);
            border-color: #FBBF24;
            color: #D97706;
        }
        
        .alert-danger {
            background-color: rgba(220, 38, 38, 0.1);
            border-color: #DC2626;
            color: #DC2626;
        }
        
        .alert-info {
            background-color: rgba(30, 58, 138, 0.1);
            border-color: #1E3A8A;
            color: #1E3A8A;
        }
        
        .form-check-input:checked {
            background-color: #1E3A8A;
            border-color: #1E3A8A;
        }
        
        .form-check-input:focus {
            border-color: #FBBF24;
            box-shadow: 0 0 0 0.25rem rgba(251, 191, 36, 0.25);
        }
        
        @media (max-width: 768px) {
            .auth-bg {
                background-attachment: scroll;
            }
        }
    </style>
</head>
<body class="auth-bg">
    <div class="min-vh-100 d-flex align-items-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <div class="floating-animation">
                                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px;">
                                    <i class="fas fa-briefcase fa-2x text-deep-blue"></i>
                                </div>
                                <h3 class="text-white fw-bold mt-3 mb-0">{{ config('app.name', 'Job Board') }}</h3>
                                <p class="text-light mb-0">Your Career Journey Starts Here</p>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Auth Card -->
                    <div class="auth-card rounded-4 p-4 p-md-5">
                        <!-- Flash Messages -->
                        @if(session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger mb-4" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger mb-4" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        {{ $slot }}
                    </div>
                    
                    <!-- Back to Home -->
                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="text-white text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>