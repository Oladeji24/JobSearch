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
                        <a class="nav-link active" href="{{ route('job-seeker.bookmarks') }}">
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
                <h1 class="h2">Bookmarked Jobs</h1>
            </div>

            @if($bookmarks->count() > 0)
                <div class="row">
                    @foreach($bookmarks as $bookmark)
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-primary">{{ $bookmark->job->category->name ?? 'General' }}</span>
                                    <small class="text-muted">{{ $bookmark->created_at->diffForHumans() }}</small>
                                </div>
                                
                                <h5 class="card-title">{{ $bookmark->job->title ?? 'Job Title' }}</h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-building me-1"></i>{{ $bookmark->job->company_name ?? 'Company' }}
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $bookmark->job->location ?? 'Location' }}
                                </p>
                                
                                @if($bookmark->job->salary_range)
                                <p class="text-success fw-semibold mb-3">
                                    <i class="fas fa-money-bill-wave me-1"></i>{{ $bookmark->job->salary_range }}
                                </p>
                                @endif
                                
                                <p class="card-text">{{ Str::limit($bookmark->job->description ?? 'No description available', 100) }}</p>
                            </div>
                            
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('jobs.show', 'internal_' . $bookmark->job->id) }}" 
                                       class="btn btn-primary flex-fill">
                                        View Details
                                    </a>
                                    <button class="btn btn-outline-danger" 
                                            onclick="removeBookmark({{ $bookmark->job->id }})"
                                            title="Remove Bookmark">
                                        <i class="fas fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $bookmarks->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bookmark fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted">No Bookmarked Jobs</h3>
                    <p class="text-muted mb-4">You haven't bookmarked any jobs yet. Start browsing and save jobs you're interested in!</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Browse Jobs
                    </a>
                </div>
            @endif
        </main>
    </div>
</div>

<script>
function removeBookmark(jobId) {
    if (confirm('Are you sure you want to remove this bookmark?')) {
        fetch(`/bookmarks/${jobId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error removing bookmark');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing bookmark');
        });
    }
}
</script>

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