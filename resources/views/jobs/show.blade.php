@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <!-- Job Header -->
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="h2 mb-2">{{ $job->title }}</h1>
                            <p class="text-muted mb-1">
                                <i class="fas fa-building me-2"></i>{{ $job->company_name }}
                                @if($job->source !== 'internal')
                                    <span class="badge bg-secondary ms-2">{{ ucfirst($job->source) }}</span>
                                @endif
                            </p>
                            <p class="text-muted mb-1">
                                <i class="fas fa-map-marker-alt me-2"></i>{{ $job->location }}
                            </p>
                            <p class="text-muted">
                                <i class="fas fa-clock me-2"></i>{{ ucfirst(str_replace('-', ' ', $job->job_type)) }}
                            </p>
                        </div>
                        
                        <div class="text-end">
                            <span class="badge bg-primary fs-6 mb-2">{{ $job->category->name ?? 'General' }}</span>
                            @if($job->salary_range)
                                <p class="text-success fw-bold h5 mb-0">{{ $job->salary_range }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="mb-4">
                        <h4>Job Description</h4>
                        <div class="job-description">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Requirements -->
                    @if($job->requirements && count($job->requirements) > 0)
                    <div class="mb-4">
                        <h4>Requirements</h4>
                        <ul class="list-unstyled">
                            @foreach($job->requirements as $requirement)
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>{{ trim($requirement) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Benefits -->
                    @if($job->benefits && count($job->benefits) > 0)
                    <div class="mb-4">
                        <h4>Benefits</h4>
                        <ul class="list-unstyled">
                            @foreach($job->benefits as $benefit)
                                <li class="mb-2">
                                    <i class="fas fa-star text-warning me-2"></i>{{ trim($benefit) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Job Details -->
                    <div class="row mt-4 pt-4 border-top">
                        <div class="col-md-6">
                            <h5>Job Details</h5>
                            <ul class="list-unstyled">
                                <li><strong>Posted:</strong> {{ $job->created_at->diffForHumans() }}</li>
                                @if($job->closing_date)
                                    <li><strong>Closing Date:</strong> {{ \Carbon\Carbon::parse($job->closing_date)->format('M d, Y') }}</li>
                                @endif
                                <li><strong>Job Type:</strong> {{ ucfirst(str_replace('-', ' ', $job->job_type)) }}</li>
                                @if($job->source === 'internal')
                                    <li><strong>Applications:</strong> {{ $job->applications_count ?? 0 }}</li>
                                @endif
                            </ul>
                        </div>
                        
                        @if($job->source === 'internal' && $job->employer)
                        <div class="col-md-6">
                            <h5>Company Info</h5>
                            @if($job->employer->employerProfile)
                                <p><strong>Industry:</strong> {{ $job->employer->employerProfile->industry ?? 'Not specified' }}</p>
                                <p><strong>Company Size:</strong> {{ $job->employer->employerProfile->company_size ?? 'Not specified' }}</p>
                                @if($job->employer->employerProfile->website)
                                    <p><strong>Website:</strong> 
                                        <a href="{{ $job->employer->employerProfile->website }}" target="_blank">
                                            {{ $job->employer->employerProfile->website }}
                                        </a>
                                    </p>
                                @endif
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    @auth
                        @if(auth()->user()->isJobSeeker())
                            @if($job->source === 'internal')
                                @if(!auth()->user()->hasAppliedTo($job->id))
                                    <button class="btn btn-primary btn-lg w-100 mb-3" onclick="showApplicationModal()">
                                        <i class="fas fa-paper-plane me-2"></i>Apply for this Job
                                    </button>
                                @else
                                    <button class="btn btn-success btn-lg w-100 mb-3" disabled>
                                        <i class="fas fa-check me-2"></i>Application Submitted
                                    </button>
                                @endif
                                
                                <button class="btn btn-outline-warning w-100" onclick="toggleBookmark({{ $job->id }})" id="bookmark-btn">
                                    @if(auth()->user()->hasBookmarked($job->id))
                                        <i class="fas fa-bookmark me-2"></i>Remove Bookmark
                                    @else
                                        <i class="far fa-bookmark me-2"></i>Bookmark Job
                                    @endif
                                </button>
                            @else
                                <a href="{{ $job->url }}" target="_blank" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-external-link-alt me-2"></i>Apply on {{ ucfirst($job->source) }}
                                </a>
                            @endif
                        @elseif(auth()->user()->isEmployer() && $job->source === 'internal' && $job->employer_id === auth()->id())
                            <a href="{{ route('employer.jobs.show', $job->id) }}" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-cog me-2"></i>Manage Job
                            </a>
                            <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-edit me-2"></i>Edit Job
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Apply
                        </a>
                        <p class="text-muted small">
                            Don't have an account? <a href="{{ route('register') }}">Sign up here</a>
                        </p>
                    @endauth
                </div>
            </div>

            <!-- Share Job -->
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Share this Job</h5>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($job->title . ' at ' . $job->company_name) }}" 
                           target="_blank" class="btn btn-outline-info btn-sm">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Modal -->
@auth
@if(auth()->user()->isJobSeeker() && $job->source === 'internal')
<div class="modal fade" id="applicationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apply for {{ $job->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('applications.store') }}">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cover_letter" class="form-label">Cover Letter (Optional)</label>
                        <textarea class="form-control" id="cover_letter" name="cover_letter" rows="5" 
                                  placeholder="Tell {{ $job->company_name }} why you're the perfect fit for this role..."></textarea>
                    </div>
                    
                    @if(auth()->user()->resumes()->count() === 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            You need to upload a resume before applying. 
                            <a href="{{ route('job-seeker.resumes') }}">Upload your resume here</a>.
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Your primary resume will be sent with this application.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    @if(auth()->user()->resumes()->count() > 0)
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Submit Application
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

<script>
function showApplicationModal() {
    new bootstrap.Modal(document.getElementById('applicationModal')).show();
}

function toggleBookmark(jobId) {
    fetch('/bookmarks/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ job_id: jobId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.getElementById('bookmark-btn');
            if (data.bookmarked) {
                btn.innerHTML = '<i class="fas fa-bookmark me-2"></i>Remove Bookmark';
                btn.className = 'btn btn-warning w-100';
            } else {
                btn.innerHTML = '<i class="far fa-bookmark me-2"></i>Bookmark Job';
                btn.className = 'btn btn-outline-warning w-100';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Job URL copied to clipboard!');
    });
}
</script>

<style>
.job-description {
    line-height: 1.6;
}
</style>
@endsection