<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Job Board') }} - Discover Your Dream Job or Hire the Best Talent</title>
    
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
        
        .hero-bg {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(30, 58, 138, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
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
        
        .stats-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .section-divider {
            height: 4px;
            background: linear-gradient(90deg, #1E3A8A 0%, #FBBF24 50%, #D97706 100%);
            border: none;
            margin: 0;
        }
        
        .testimonial-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        @media (max-width: 768px) {
            .hero-bg {
                background-attachment: scroll;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-deep-blue text-xl" href="{{ route('home') }}">
                <i class="fas fa-briefcase me-2 text-golden-yellow"></i>{{ config('app.name', 'Job Board') }}
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-medium hover:text-deep-blue transition-colors" href="{{ route('jobs.index') }}">Find Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium hover:text-deep-blue transition-colors" href="#categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium hover:text-deep-blue transition-colors" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium hover:text-deep-blue transition-colors" href="#about">About</a>
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
                            <a class="btn btn-deep-blue ms-2 px-4" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg d-flex align-items-center text-white position-relative">
        <div class="container">
            <div class="row align-items-center min-vh-100 py-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="floating-animation">
                        <h1 class="display-3 fw-bold mb-4 text-white">
                            Discover Your Dream Job or 
                            <span class="text-golden-yellow">Hire the Best Talent</span>
                        </h1>
                        <p class="lead mb-5 text-gray-100 fs-5">
                            Connect with top employers and discover opportunities that match your skills and aspirations. 
                            Your next career move starts here with thousands of verified companies.
                        </p>
                        
                        <div class="d-flex flex-column flex-sm-row gap-4 mb-5">
                            <a href="{{ route('jobs.index') }}" class="btn btn-golden btn-lg px-5 py-3 rounded-pill shadow-lg">
                                <i class="fas fa-search me-2"></i>Find a Job
                            </a>
                            <a href="{{ route('employer.jobs.create') }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill border-2 hover:bg-white hover:text-deep-blue transition-all">
                                <i class="fas fa-plus me-2"></i>Post a Job
                            </a>
                        </div>
                        
                        <div class="d-flex flex-wrap gap-4 text-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-golden-yellow me-2"></i>
                                <span>Free to join</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-golden-yellow me-2"></i>
                                <span>Verified companies</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-golden-yellow me-2"></i>
                                <span>Instant notifications</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="stats-card rounded-4 p-4 text-center backdrop-blur">
                                <h3 class="h1 fw-bold text-golden-yellow mb-2">{{ isset($stats['total_jobs']) ? number_format($stats['total_jobs']) : '1,250' }}+</h3>
                                <p class="mb-0 fw-medium">Jobs Posted</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card rounded-4 p-4 text-center backdrop-blur">
                                <h3 class="h1 fw-bold text-golden-yellow mb-2">{{ isset($stats['total_employers']) ? number_format($stats['total_employers']) : '450' }}+</h3>
                                <p class="mb-0 fw-medium">Companies Registered</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card rounded-4 p-4 text-center backdrop-blur">
                                <h3 class="h1 fw-bold text-golden-yellow mb-2">{{ isset($stats['total_job_seekers']) ? number_format($stats['total_job_seekers']) : '3,200' }}+</h3>
                                <p class="mb-0 fw-medium">Users Hired</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card rounded-4 p-4 text-center backdrop-blur">
                                <h3 class="h1 fw-bold text-golden-yellow mb-2">{{ isset($stats['total_applications']) ? number_format($stats['total_applications']) : '8,500' }}+</h3>
                                <p class="mb-0 fw-medium">Success Stories</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <div class="text-center">
                <i class="fas fa-chevron-down fa-2x text-golden-yellow animate-bounce"></i>
            </div>
        </div>
    </section>

    <hr class="section-divider">

    <!-- Job Categories -->
    <section id="categories" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-deep-blue mb-4">Browse by Category</h2>
                <p class="lead text-muted fs-5">Explore opportunities in your field of expertise</p>
            </div>
            
            <div class="row g-4">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('jobs.category', $category->slug) }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm card-hover rounded-4">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <div class="bg-gradient-to-r from-deep-blue to-rich-gold rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 70px; height: 70px;">
                                            <i class="{{ $category->icon ?? 'fas fa-briefcase' }} fa-2x"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold text-deep-blue">{{ $category->name }}</h5>
                                    <p class="card-text text-muted">{{ $category->jobs_count ?? 0 }} jobs available</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @else
                    <!-- Default categories if none exist -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm card-hover rounded-4">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <div class="bg-gradient-to-r from-deep-blue to-rich-gold rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 70px; height: 70px;">
                                        <i class="fas fa-code fa-2x"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-deep-blue">Technology</h5>
                                <p class="card-text text-muted">150+ jobs available</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm card-hover rounded-4">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <div class="bg-gradient-to-r from-deep-blue to-rich-gold rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 70px; height: 70px;">
                                        <i class="fas fa-chart-line fa-2x"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-deep-blue">Marketing</h5>
                                <p class="card-text text-muted">85+ jobs available</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm card-hover rounded-4">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <div class="bg-gradient-to-r from-deep-blue to-rich-gold rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 70px; height: 70px;">
                                        <i class="fas fa-paint-brush fa-2x"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-deep-blue">Design</h5>
                                <p class="card-text text-muted">65+ jobs available</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm card-hover rounded-4">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <div class="bg-gradient-to-r from-deep-blue to-rich-gold rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 70px; height: 70px;">
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-deep-blue">Finance</h5>
                                <p class="card-text text-muted">95+ jobs available</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Recent Jobs -->
    @if(isset($recentJobs) && $recentJobs->count() > 0)
    <section class="py-5 bg-gray-50">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-deep-blue mb-4">Latest Job Opportunities</h2>
                <p class="lead text-muted fs-5">Fresh opportunities posted by top companies</p>
            </div>
            
            <div class="row g-4">
                @foreach($recentJobs as $job)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm card-hover rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-deep-blue px-3 py-2 rounded-pill">{{ $job->category->name ?? 'General' }}</span>
                                <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                            </div>
                            
                            <h5 class="card-title fw-bold text-deep-blue mb-3">{{ $job->title }}</h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-building me-2 text-rich-gold"></i>{{ $job->company_name }}
                            </p>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-2 text-rich-gold"></i>{{ $job->location }}
                            </p>
                            
                            @if($job->salary_range)
                            <p class="text-success fw-semibold mb-3">
                                <i class="fas fa-money-bill-wave me-2"></i>{{ $job->salary_range }}
                            </p>
                            @endif
                            
                            <p class="card-text text-muted">{{ Str::limit($job->description, 100) }}</p>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 p-4">
                            <a href="{{ route('jobs.show', 'internal_' . $job->id) }}" class="btn btn-outline-deep-blue w-100 rounded-pill">
                                View Details <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('jobs.index') }}" class="btn btn-golden btn-lg px-5 py-3 rounded-pill">
                    View All Jobs <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- How It Works -->
    <section id="how-it-works" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-deep-blue mb-4">How It Works</h2>
                <p class="lead text-muted fs-5">Get started in just a few simple steps</p>
            </div>
            
            <div class="row g-5">
                <div class="col-lg-4 text-center">
                    <div class="mb-4">
                        <div class="bg-gradient-to-r from-deep-blue to-rich-gold text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg" style="width: 100px; height: 100px;">
                            <i class="fas fa-user-plus fa-3x"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-deep-blue mb-3">1. Create Account</h4>
                    <p class="text-muted fs-6">Sign up as a job seeker or employer and complete your professional profile with your skills and experience</p>
                </div>
                
                <div class="col-lg-4 text-center">
                    <div class="mb-4">
                        <div class="bg-gradient-to-r from-deep-blue to-rich-gold text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg" style="width: 100px; height: 100px;">
                            <i class="fas fa-search fa-3x"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-deep-blue mb-3">2. Search & Apply</h4>
                    <p class="text-muted fs-6">Browse thousands of jobs, use advanced filters, and apply to positions that perfectly match your skills and career goals</p>
                </div>
                
                <div class="col-lg-4 text-center">
                    <div class="mb-4">
                        <div class="bg-gradient-to-r from-deep-blue to-rich-gold text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg" style="width: 100px; height: 100px;">
                            <i class="fas fa-handshake fa-3x"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-deep-blue mb-3">3. Get Hired</h4>
                    <p class="text-muted fs-6">Connect directly with employers, showcase your talents, and land your dream job with our streamlined hiring process</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-gray-50">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-deep-blue mb-4">What Our Users Say</h2>
                <p class="lead text-muted fs-5">Join thousands of satisfied job seekers and employers</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card rounded-4 p-4 h-100 shadow-sm">
                        <div class="mb-3">
                            <div class="d-flex text-golden-yellow">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="mb-4 text-muted">"Found my dream job within 2 weeks! The platform is incredibly user-friendly and the job matching is spot-on."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-deep-blue text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Sarah Johnson</h6>
                                <small class="text-muted">Software Developer</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="testimonial-card rounded-4 p-4 h-100 shadow-sm">
                        <div class="mb-3">
                            <div class="d-flex text-golden-yellow">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="mb-4 text-muted">"As an employer, this platform helped us find qualified candidates quickly. The quality of applicants is outstanding."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-deep-blue text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Michael Chen</h6>
                                <small class="text-muted">HR Director</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="testimonial-card rounded-4 p-4 h-100 shadow-sm">
                        <div class="mb-3">
                            <div class="d-flex text-golden-yellow">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="mb-4 text-muted">"The best job board I've used. Clean interface, relevant jobs, and excellent customer support. Highly recommended!"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-deep-blue text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Emily Rodriguez</h6>
                                <small class="text-muted">Marketing Manager</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-deep-blue text-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold mb-3">Ready to Take the Next Step?</h2>
                    <p class="lead mb-0">Join thousands of professionals who have found their perfect match on our platform.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-lg-end">
                        <a href="{{ route('jobs.index') }}" class="btn btn-golden btn-lg px-4 rounded-pill">Find Jobs</a>
                        <a href="{{ route('employer.jobs.create') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">Post Jobs</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="about" class="bg-dark text-white py-5">
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
    
    <!-- Custom JS for smooth scrolling -->
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
    </script>
</body>
</html>