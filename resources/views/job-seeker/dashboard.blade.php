@extends('layouts.master')

@section('title', 'Dashboard - ' . config('app.name'))

@php
    $pageHeader = [
        'title' => 'Job Seeker Dashboard',
        'subtitle' => 'Welcome back, ' . auth()->user()->name . '! Track your job search progress'
    ];
    
    $breadcrumbs = [
        ['title' => 'Home', 'url' => route('home')],
        ['title' => 'Dashboard', 'url' => '']
    ];
@endphp

@section('content')
<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-lg border-0 rounded-4 sticky-top" style="top: 100px;">
                <div class="card-header bg-deep-blue text-white rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-circle me-2"></i>Navigation
                    </h5>
                </div>
                <div class="card-body p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active bg-golden-yellow bg-opacity-10 text-deep-blue fw-medium" href="{{ route('job-seeker.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover:text-deep-blue hover:bg-light" href="{{ route('job-seeker.profile') }}">
                                <i class="fas fa-user me-3"></i>Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover:text-deep-blue hover:bg-light" href="{{ route('job-seeker.applications') }}">
                                <i class="fas fa-file-alt me-3"></i>My Applications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover:text-deep-blue hover:bg-light" href="{{ route('job-seeker.bookmarks') }}">
                                <i class="fas fa-bookmark me-3"></i>Bookmarked Jobs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover:text-deep-blue hover:bg-light" href="{{ route('job-seeker.resumes') }}">
                                <i class="fas fa-file-pdf me-3"></i>My Resumes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover:text-deep-blue hover:bg-light" href="{{ route('job-seeker.notifications') }}">
                                <i class="fas fa-bell me-3"></i>Notifications
                            </a>
                        </li>
                        <li class="nav-item border-top">
                            <a class="nav-link text-muted hover:text-deep-blue hover:bg-light" href="{{ route('jobs.index') }}">
                                <i class="fas fa-search me-3"></i>Browse Jobs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Welcome Message -->
            @if($stats['profile_completion'] < 100)
            <div class="alert alert-info border-0 rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="alert-heading fw-bold mb-2">
                            <i class="fas fa-info-circle me-2"></i>Complete Your Profile
                        </h5>
                        <p class="mb-2">Your profile is {{ $stats['profile_completion'] }}% complete. A complete profile increases your chances of getting noticed by employers!</p>
                    </div>
                    <div>
                        <a href="{{ route('job-seeker.profile') }}" class="btn btn-deep-blue">
                            <i class="fas fa-user-edit me-2"></i>Complete Profile
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 card-hover">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1 fw-medium">Applications Submitted</p>
                                    <h3 class="fw-bold text-deep-blue mb-0">{{ $stats['applications'] }}</h3>
                                </div>
                                <div class="bg-deep-blue bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-file-alt fa-2x text-deep-blue"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 card-hover">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1 fw-medium">Bookmarked Jobs</p>
                                    <h3 class="fw-bold text-deep-blue mb-0">{{ $stats['bookmarks'] }}</h3>
                                </div>
                                <div class="bg-golden-yellow bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-bookmark fa-2x text-rich-gold"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 card-hover">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1 fw-medium">Resumes Uploaded</p>
                                    <h3 class="fw-bold text-deep-blue mb-0">{{ $stats['resumes'] }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-file-pdf fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 card-hover">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1 fw-medium">Profile Completion</p>
                                    <h3 class="fw-bold text-deep-blue mb-2">{{ $stats['profile_completion'] }}%</h3>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-golden-yellow" 
                                             role="progressbar" 
                                             style="width: {{ $stats['profile_completion'] }}%"
                                             aria-valuenow="{{ $stats['profile_completion'] }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-user fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-header bg-deep-blue text-white rounded-top-4">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-bolt me-2"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <a href="{{ route('jobs.index') }}" class="btn btn-golden w-100 py-3">
                                        <i class="fas fa-search d-block mb-2 fa-2x"></i>
                                        <strong>Find Jobs</strong>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('job-seeker.profile') }}" class="btn btn-outline-deep-blue w-100 py-3">
                                        <i class="fas fa-user-edit d-block mb-2 fa-2x"></i>
                                        <strong>Edit Profile</strong>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('job-seeker.resumes') }}" class="btn btn-outline-deep-blue w-100 py-3">
                                        <i class="fas fa-upload d-block mb-2 fa-2x"></i>
                                        <strong>Upload Resume</strong>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('job-seeker.applications') }}" class="btn btn-outline-deep-blue w-100 py-3">
                                        <i class="fas fa-file-alt d-block mb-2 fa-2x"></i>
                                        <strong>View Applications</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row g-4">
                <!-- Recent Applications -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-header bg-light border-0 rounded-top-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-deep-blue">
                                    <i class="fas fa-file-alt me-2"></i>Recent Applications
                                </h5>
                                <a href="{{ route('job-seeker.applications') }}" class="btn btn-sm btn-outline-deep-blue">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if($recentApplications->count() > 0)
                                @foreach($recentApplications as $application)
                                <div class="d-flex align-items-center mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-deep-blue">{{ $application->job->title ?? 'Job Title' }}</h6>
                                        <p class="text-muted mb-1 small">
                                            <i class="fas fa-building me-1"></i>{{ $application->job->company_name ?? 'Company' }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>Applied {{ $application->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'accepted' => 'success',
                                                'rejected' => 'danger',
                                                'reviewed' => 'info'
                                            ];
                                            $statusColor = $statusColors[$application->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }} px-3 py-2">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-file-alt fa-3x text-muted opacity-50 mb-3"></i>
                                    <h6 class="text-muted mb-2">No applications yet</h6>
                                    <p class="text-muted small mb-3">Start applying to jobs to see your applications here</p>
                                    <a href="{{ route('jobs.index') }}" class="btn btn-golden">
                                        <i class="fas fa-search me-2"></i>Find Jobs
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Bookmarked Jobs -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-header bg-light border-0 rounded-top-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-deep-blue">
                                    <i class="fas fa-bookmark me-2"></i>Bookmarked Jobs
                                </h5>
                                <a href="{{ route('job-seeker.bookmarks') }}" class="btn btn-sm btn-outline-deep-blue">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if($bookmarkedJobs->count() > 0)
                                @foreach($bookmarkedJobs as $bookmark)
                                <div class="d-flex align-items-center mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-deep-blue">{{ $bookmark->job->title ?? 'Job Title' }}</h6>
                                        <p class="text-muted mb-1 small">
                                            <i class="fas fa-building me-1"></i>{{ $bookmark->job->company_name ?? 'Company' }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-bookmark me-1"></i>Bookmarked {{ $bookmark->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div>
                                        <a href="{{ route('jobs.show', 'internal_' . $bookmark->job->id) }}" 
                                           class="btn btn-sm btn-outline-deep-blue">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-bookmark fa-3x text-muted opacity-50 mb-3"></i>
                                    <h6 class="text-muted mb-2">No bookmarked jobs yet</h6>
                                    <p class="text-muted small mb-3">Bookmark jobs you're interested in to save them for later</p>
                                    <a href="{{ route('jobs.index') }}" class="btn btn-golden">
                                        <i class="fas fa-search me-2"></i>Browse Jobs
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notifications -->
            @if(isset($notifications) && $notifications->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-header bg-light border-0 rounded-top-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-deep-blue">
                                    <i class="fas fa-bell me-2"></i>Recent Notifications
                                </h5>
                                <a href="{{ route('job-seeker.notifications') }}" class="btn btn-sm btn-outline-deep-blue">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @foreach($notifications as $notification)
                            <div class="d-flex align-items-center mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold text-deep-blue">{{ $notification->data['title'] ?? 'Notification' }}</h6>
                                    <p class="text-muted mb-1 small">{{ $notification->data['message'] ?? 'You have a new notification' }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                @if($notification->read_at === null)
                                <div>
                                    <span class="badge bg-golden-yellow text-dark px-3 py-2">New</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .nav-link {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .nav-link:last-child {
        border-bottom: none;
    }
    
    .nav-link:hover {
        background-color: rgba(251, 191, 36, 0.1) !important;
        color: #1E3A8A !important;
        transform: translateX(5px);
    }
    
    .nav-link.active {
        background-color: rgba(251, 191, 36, 0.15) !important;
        color: #1E3A8A !important;
        border-left: 4px solid #FBBF24;
    }
    
    .sticky-top {
        top: 100px !important;
    }
</style>
@endpush
@endsection