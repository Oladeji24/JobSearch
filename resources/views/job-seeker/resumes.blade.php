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
                        <a class="nav-link active" href="{{ route('job-seeker.resumes') }}">
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
                <h1 class="h2">My Resumes</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadResumeModal">
                        <i class="fas fa-upload me-1"></i>Upload Resume
                    </button>
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

            @if($resumes->count() > 0)
                <div class="row">
                    @foreach($resumes as $resume)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm {{ $resume->is_primary ? 'border-primary' : '' }}">
                            <div class="card-body text-center">
                                @if($resume->is_primary)
                                    <div class="badge bg-primary position-absolute top-0 start-50 translate-middle">
                                        Primary
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                </div>
                                
                                <h5 class="card-title">{{ $resume->file_name }}</h5>
                                <p class="text-muted small">
                                    <i class="fas fa-calendar me-1"></i>Uploaded {{ $resume->created_at->diffForHumans() }}
                                </p>
                                <p class="text-muted small">
                                    <i class="fas fa-file me-1"></i>{{ strtoupper($resume->file_type) }} • {{ number_format($resume->file_size / 1024, 1) }} KB
                                </p>
                            </div>
                            
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ asset('storage/' . $resume->file_path) }}" 
                                       target="_blank" class="btn btn-sm btn-outline-primary" title="View Resume">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ asset('storage/' . $resume->file_path) }}" 
                                       download="{{ $resume->file_name }}" class="btn btn-sm btn-outline-success" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    
                                    @if(!$resume->is_primary)
                                        <form method="POST" action="{{ route('job-seeker.resumes.primary', $resume->id) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Make Primary">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('job-seeker.resumes.delete', $resume->id) }}" 
                                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this resume?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-pdf fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted">No Resumes Uploaded</h3>
                    <p class="text-muted mb-4">Upload your resume to start applying for jobs. You can upload multiple versions for different types of positions.</p>
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#uploadResumeModal">
                        <i class="fas fa-upload me-2"></i>Upload Your First Resume
                    </button>
                </div>
            @endif
        </main>
    </div>
</div>

<!-- Upload Resume Modal -->
<div class="modal fade" id="uploadResumeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Resume</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('job-seeker.resumes.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="resume" class="form-label">Select Resume File</label>
                        <input type="file" class="form-control" id="resume" name="resume" 
                               accept=".pdf,.doc,.docx" required>
                        <div class="form-text">
                            Supported formats: PDF, DOC, DOCX. Maximum size: 5MB.
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Tips for a great resume:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Keep it concise (1-2 pages)</li>
                            <li>Use a professional format</li>
                            <li>Include relevant keywords</li>
                            <li>Highlight your achievements</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>Upload Resume
                    </button>
                </div>
            </form>
        </div>
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