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
                        <a class="nav-link" href="{{ route('job-seeker.applications') }}">
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
                        <a class="nav-link active" href="{{ route('job-seeker.notifications') }}">
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
                <h1 class="h2">Notifications</h1>
            </div>

            @if($notifications->count() > 0)
                <div class="card shadow">
                    <div class="card-body">
                        @foreach($notifications as $notification)
                        <div class="d-flex align-items-start py-3 {{ !$loop->last ? 'border-bottom' : '' }} {{ $notification->read_at ? '' : 'bg-light' }}">
                            <div class="me-3">
                                @if($notification->read_at)
                                    <i class="fas fa-envelope-open text-muted"></i>
                                @else
                                    <i class="fas fa-envelope text-primary"></i>
                                @endif
                            </div>
                            
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h6>
                                <p class="mb-1">{{ $notification->data['message'] ?? 'You have a new notification' }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            
                            <div class="ms-3">
                                @if($notification->read_at === null)
                                    <span class="badge bg-primary">New</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted">No Notifications</h3>
                    <p class="text-muted mb-4">You don't have any notifications yet. We'll notify you about application updates and new job opportunities.</p>
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