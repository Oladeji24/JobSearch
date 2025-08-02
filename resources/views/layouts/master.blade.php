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
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .form-control:focus {
            border-color: #FBBF24;
            box-shadow: 0 0 0 0.2rem rgba(251, 191, 36, 0.25);
        }
        
        .form-select:focus {
            border-color: #FBBF24;
            box-shadow: 0 0 0 0.2rem rgba(251, 191, 36, 0.25);
        }
        
        .page-header {
            background: linear-gradient(135deg, #1E3A8A 0%, #1E40AF 100%);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            color: #FBBF24;
        }
        
        .breadcrumb-item.active {
            color: #FBBF24;
        }
        
        .section-divider {
            height: 3px;
            background: linear-gradient(90deg, #1E3A8A 0%, #FBBF24 50%, #D97706 100%);
            border: none;
            margin: 0;
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
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: #1E3A8A !important;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 12px;
        }
        
        .dropdown-item:hover {
            background-color: rgba(251, 191, 36, 0.1);
            color: #1E3A8A;
        }
        
        .table th {
            background-color: #1E3A8A;
            color: white;
            border: none;
            font-weight: 600;
        }
        
        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(251, 191, 36, 0.05);
        }
        
        .pagination .page-link {
            color: #1E3A8A;
            border-color: #e5e7eb;
        }
        
        .pagination .page-link:hover {
            color: #D97706;
            background-color: rgba(251, 191, 36, 0.1);
            border-color: #FBBF24;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #1E3A8A;
            border-color: #1E3A8A;
        }
        
        .badge {
            font-weight: 500;
        }
        
        .bg-deep-blue {
            background-color: #1E3A8A !important;
        }
        
        .bg-golden-yellow {
            background-color: #FBBF24 !important;
        }
        
        .bg-rich-gold {
            background-color: #D97706 !important;
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
        
        .border-golden-yellow {
            border-color: #FBBF24 !important;
        }
        
        .btn-outline-deep-blue {
            color: #1E3A8A;
            border-color: #1E3A8A;
        }
        
        .btn-outline-deep-blue:hover {
            background-color: #1E3A8A;
            border-color: #1E3A8A;
            color: white;
        }
        
        .btn-outline-golden {
            color: #D97706;
            border-color: #FBBF24;
        }
        
        .btn-outline-golden:hover {
            background: linear-gradient(135deg, #FBBF24 0%, #D97706 100%);
            border-color: #D97706;
            color: white;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-lg @if(!isset($hideNavbar)) fixed-top @endif">
        <div class="container">
            <a class="navbar-brand text-deep-blue" href="{{ route('home') }}">
                <i class="fas fa-briefcase me-2 text-golden-yellow"></i>{{ config('app.name', 'Job Board') }}
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jobs.index') }}">Find Jobs</a>
                    </li>
                    @if(Route::has('jobs.category'))
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu shadow-lg border-0">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                @if(auth()->user()->isJobSeeker())
                                    <li><a class="dropdown-item" href="{{ route('job-seeker.profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('job-seeker.applications') }}"><i class="fas fa-file-alt me-2"></i>Applications</a></li>
                                    <li><a class="dropdown-item" href="{{ route('job-seeker.bookmarks') }}"><i class="fas fa-bookmark me-2"></i>Bookmarks</a></li>
                                @elseif(auth()->user()->isEmployer())
                                    <li><a class="dropdown-item" href="{{ route('employer.profile') }}"><i class="fas fa-building me-2"></i>Company Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('employer.jobs.index') }}"><i class="fas fa-briefcase me-2"></i>My Jobs</a></li>
                                    <li><a class="dropdown-item" href="{{ route('employer.jobs.create') }}"><i class="fas fa-plus me-2"></i>Post Job</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-deep-blue ms-2 px-4 rounded-pill" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(!isset($hideNavbar))
        <div style="height: 76px;"></div> <!-- Spacer for fixed navbar -->
    @endif

    <!-- Page Header -->
    @if(isset($pageHeader))
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if(isset($breadcrumbs))
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @foreach($breadcrumbs as $breadcrumb)
                                        @if($loop->last)
                                            <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                        @else
                                            <li class="breadcrumb-item">
                                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </nav>
                        @endif
                        
                        <h1 class="display-6 fw-bold mb-2">{{ $pageHeader['title'] }}</h1>
                        @if(isset($pageHeader['subtitle']))
                            <p class="lead mb-0 text-light">{{ $pageHeader['subtitle'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <hr class="section-divider">
    @endif

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="container mt-4">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="@if(!isset($pageHeader)) py-4 @else py-5 @endif">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-briefcase me-2 text-golden-yellow"></i>{{ config('app.name', 'Job Board') }}
                    </h5>
                    <p class="text-light mb-4">Connecting talented professionals with amazing opportunities worldwide. Your career journey starts here with us.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light hover:text-golden-yellow transition-colors"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-light hover:text-golden-yellow transition-colors"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light hover:text-golden-yellow transition-colors"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-light hover:text-golden-yellow transition-colors"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3 text-golden-yellow">For Job Seekers</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('jobs.index') }}" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Browse Jobs</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Create Account</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Career Tips</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Resume Builder</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3 text-golden-yellow">For Employers</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('employer.jobs.create') }}" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Post Jobs</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Find Talent</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Pricing</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Employer Guide</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3 text-golden-yellow">Company</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Contact</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Terms</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Privacy</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3 text-golden-yellow">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Live Chat</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none hover:text-golden-yellow transition-colors">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 border-secondary">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Job Board') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Made with <i class="fas fa-heart text-danger"></i> for job seekers everywhere</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>