@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('job-seeker.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('job-seeker.profile') }}">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('job-seeker.applications') }}">
                            <i class="fas fa-file-alt me-2"></i>My Applications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('job-seeker.bookmarks') }}">
                            <i class="fas fa-bookmark me-2"></i>Bookmarked Jobs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('job-seeker.resumes') }}">
                            <i class="fas fa-file-pdf me-2"></i>My Resumes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('job-seeker.notifications') }}">
                            <i class="fas fa-bell me-2"></i>Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jobs.index') }}">
                            <i class="fas fa-search me-2"></i>Browse Jobs
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">My Applications</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-search me-1"></i>Find More Jobs
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($applications->count() > 0)
                <div class="card shadow">
                    <div class="card-body">
                        @foreach($applications as $application)
                        <div class="row align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="col-md-8">
                                <h5 class="mb-1">{{ $application->job->title ?? 'Job Title' }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-building me-1"></i>{{ $application->job->company_name ?? 'Company Name' }}
                                </p>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $application->job->location ?? 'Location' }}
                                </p>
                                <small class="text-muted">
                                    Applied {{ $application->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="badge bg-{{ 
                                    $application->status === 'pending' ? 'warning' : 
                                    ($application->status === 'accepted' ? 'success' : 
                                    ($application->status === 'shortlisted' ? 'info' : 'secondary')) 
                                }} fs-6">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                            <div class="col-md-2 text-end">
                                <div class="btn-group" role="group">
                                    @if($application->job)
                                        <a href="{{ route('jobs.show', 'internal_' . $application->job->id) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View Job">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                    
                                    @if($application->status === 'pending')
                                        <form method="POST" action="{{ route('applications.destroy', $application->id) }}" 
                                              class="d-inline" onsubmit="return confirm('Are you sure you want to withdraw this application?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Withdraw Application">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($application->cover_letter)
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="collapse" id="coverLetter{{ $application->id }}">
                                    <div class="card card-body bg-light">
                                        <h6>Cover Letter:</h6>
                                        <p class="mb-0">{{ $application->cover_letter }}</p>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-link p-0" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#coverLetter{{ $application->id }}">
                                    <small>View Cover Letter</small>
                                </button>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted">No Applications Yet</h3>
                    <p class="text-muted mb-4">You haven't applied to any jobs yet. Start your job search now!</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Browse Jobs
                    </a>
                </div>
            @endif
        </main>
    </div>
</div>

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}
.sidebar .nav-link {
    font-weight: 500;
    color: #333;
}
.sidebar .nav-link.active {
    color: #007bff;
}
.sidebar .nav-link:hover {
    color: #007bff;
}
</style>
@endsection