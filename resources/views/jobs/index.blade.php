@extends('layouts.master')

@section('title', 'Find Jobs - ' . config('app.name'))

@php
    $pageHeader = [
        'title' => 'Find Your Dream Job',
        'subtitle' => 'Discover thousands of opportunities from top companies worldwide'
    ];
    
    $breadcrumbs = [
        ['title' => 'Home', 'url' => route('home')],
        ['title' => 'Jobs', 'url' => '']
    ];
@endphp

@section('content')
<div class="container">
    <!-- Search Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('jobs.search') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="keyword" class="form-label fw-medium text-deep-blue">
                                    <i class="fas fa-search me-2"></i>Keywords
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="keyword" 
                                       name="keyword" 
                                       value="{{ request('keyword') }}" 
                                       placeholder="Job title, skills, company...">
                            </div>
                            <div class="col-md-3">
                                <label for="location" class="form-label fw-medium text-deep-blue">
                                    <i class="fas fa-map-marker-alt me-2"></i>Location
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="location" 
                                       name="location" 
                                       value="{{ request('location') }}" 
                                       placeholder="City, state, or remote">
                            </div>
                            <div class="col-md-3">
                                <label for="category" class="form-label fw-medium text-deep-blue">
                                    <i class="fas fa-tags me-2"></i>Category
                                </label>
                                <select class="form-select form-select-lg" id="category" name="category">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-golden btn-lg w-100">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </div>
                        
                        <!-- Advanced Filters -->
                        <div class="row g-3 mt-2">
                            <div class="col-md-3">
                                <label for="job_type" class="form-label fw-medium text-deep-blue">Job Type</label>
                                <select class="form-select" id="job_type" name="job_type">
                                    <option value="">All Types</option>
                                    <option value="full-time" {{ request('job_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part-time" {{ request('job_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ request('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="remote" {{ request('job_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                                    <option value="internship" {{ request('job_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="sort" class="form-label fw-medium text-deep-blue">Sort By</label>
                                <select class="form-select" id="sort" name="sort">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="d-flex gap-2 w-100">
                                    <button type="button" class="btn btn-outline-deep-blue" onclick="clearFilters()">
                                        <i class="fas fa-times me-1"></i>Clear Filters
                                    </button>
                                    <button type="button" class="btn btn-outline-golden" data-bs-toggle="collapse" data-bs-target="#savedSearches">
                                        <i class="fas fa-star me-1"></i>Saved Searches
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-deep-blue mb-1">
                        <i class="fas fa-briefcase me-2 text-golden-yellow"></i>
                        {{ number_format($jobs->total()) }} Jobs Found
                    </h4>
                    @if(request()->hasAny(['keyword', 'location', 'category', 'job_type']))
                        <p class="text-muted mb-0">
                            Showing results for your search criteria
                        </p>
                    @endif
                </div>
                @auth
                    @if(auth()->user()->isEmployer())
                        <a href="{{ route('employer.jobs.create') }}" class="btn btn-golden">
                            <i class="fas fa-plus me-2"></i>Post a Job
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="row">
        <div class="col-12">
            @if($jobs->count() > 0)
                @foreach($jobs as $job)
                <div class="card shadow-sm border-0 rounded-4 mb-4 card-hover">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-1 fw-bold">
                                        <a href="{{ route('jobs.show', $job->source === 'internal' ? 'internal_' . $job->id : $job->id) }}" 
                                           class="text-decoration-none text-deep-blue hover:text-rich-gold">
                                            {{ $job->title }}
                                        </a>
                                    </h5>
                                    <span class="badge bg-deep-blue px-3 py-2 rounded-pill">{{ $job->category->name ?? 'General' }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-building me-2 text-rich-gold"></i>{{ $job->company_name }}
                                        @if($job->source !== 'internal')
                                            <span class="badge bg-secondary ms-2">{{ ucfirst($job->source) }}</span>
                                        @endif
                                    </p>
                                    
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-map-marker-alt me-2 text-rich-gold"></i>{{ $job->location }}
                                        <span class="ms-4">
                                            <i class="fas fa-clock me-2 text-rich-gold"></i>{{ ucfirst(str_replace('-', ' ', $job->job_type)) }}
                                        </span>
                                    </p>
                                    
                                    @if($job->salary_range)
                                    <p class="text-success fw-semibold mb-2">
                                        <i class="fas fa-money-bill-wave me-2"></i>{{ $job->salary_range }}
                                    </p>
                                    @endif
                                </div>
                                
                                <p class="card-text text-muted mb-3">{{ Str::limit($job->description, 150) }}</p>
                                
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Posted {{ $job->created_at->diffForHumans() }}
                                </small>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="d-flex flex-column gap-2 h-100 justify-content-center">
                                    <a href="{{ route('jobs.show', $job->source === 'internal' ? 'internal_' . $job->id : $job->id) }}" 
                                       class="btn btn-outline-deep-blue btn-lg">
                                        <i class="fas fa-eye me-2"></i>View Details
                                    </a>
                                    
                                    @auth
                                        @if(auth()->user()->isJobSeeker())
                                            @if($job->source === 'internal')
                                                @if(!auth()->user()->hasAppliedTo($job->id))
                                                    <button class="btn btn-golden btn-lg" onclick="showApplicationModal({{ $job->id }})">
                                                        <i class="fas fa-paper-plane me-2"></i>Apply Now
                                                    </button>
                                                @else
                                                    <button class="btn btn-secondary btn-lg" disabled>
                                                        <i class="fas fa-check me-2"></i>Already Applied
                                                    </button>
                                                @endif
                                                
                                                <button class="btn btn-outline-golden" 
                                                        onclick="toggleBookmark({{ $job->id }})"
                                                        id="bookmark-btn-{{ $job->id }}">
                                                    @if(auth()->user()->hasBookmarked($job->id))
                                                        <i class="fas fa-bookmark me-2"></i>Bookmarked
                                                    @else
                                                        <i class="far fa-bookmark me-2"></i>Bookmark
                                                    @endif
                                                </button>
                                            @else
                                                <a href="{{ $job->url }}" target="_blank" class="btn btn-golden btn-lg">
                                                    <i class="fas fa-external-link-alt me-2"></i>Apply on {{ ucfirst($job->source) }}
                                                </a>
                                            @endif
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-golden btn-lg">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login to Apply
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $jobs->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search fa-5x text-muted opacity-50"></i>
                    </div>
                    <h3 class="text-muted fw-bold mb-3">No Jobs Found</h3>
                    <p class="text-muted mb-4 lead">
                        We couldn't find any jobs matching your criteria. Try adjusting your search filters or browse all available positions.
                    </p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('jobs.index') }}" class="btn btn-golden btn-lg">
                            <i class="fas fa-list me-2"></i>View All Jobs
                        </a>
                        <button type="button" class="btn btn-outline-deep-blue btn-lg" onclick="clearFilters()">
                            <i class="fas fa-times me-2"></i>Clear Filters
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Application Modal -->
@auth
@if(auth()->user()->isJobSeeker())
<div class="modal fade" id="applicationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-deep-blue text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-paper-plane me-2"></i>Apply for Job
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="applicationForm" method="POST" action="{{ route('applications.store') }}">
                @csrf
                <input type="hidden" id="job_id" name="job_id">
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label for="cover_letter" class="form-label fw-medium text-deep-blue">
                            <i class="fas fa-file-alt me-2"></i>Cover Letter (Optional)
                        </label>
                        <textarea class="form-control" 
                                  id="cover_letter" 
                                  name="cover_letter" 
                                  rows="6" 
                                  placeholder="Tell the employer why you're interested in this position and what makes you a great fit..."></textarea>
                        <div class="form-text">
                            <small class="text-muted">
                                <i class="fas fa-lightbulb me-1"></i>
                                A personalized cover letter increases your chances of getting noticed!
                            </small>
                        </div>
                    </div>
                    
                    @if(auth()->user()->resumes()->count() === 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Resume Required:</strong> You need to upload a resume before applying. 
                            <a href="{{ route('job-seeker.resumes') }}" class="alert-link">Upload your resume here</a>.
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Resume Ready:</strong> Your primary resume will be sent with this application.
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    @if(auth()->user()->resumes()->count() > 0)
                        <button type="submit" class="btn btn-golden">
                            <i class="fas fa-paper-plane me-2"></i>Submit Application
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

@push('scripts')
<script>
function showApplicationModal(jobId) {
    document.getElementById('job_id').value = jobId;
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
            const btn = document.getElementById(`bookmark-btn-${jobId}`);
            if (data.bookmarked) {
                btn.innerHTML = '<i class="fas fa-bookmark me-2"></i>Bookmarked';
                btn.classList.remove('btn-outline-golden');
                btn.classList.add('btn-golden');
            } else {
                btn.innerHTML = '<i class="far fa-bookmark me-2"></i>Bookmark';
                btn.classList.remove('btn-golden');
                btn.classList.add('btn-outline-golden');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}

function clearFilters() {
    // Clear all form inputs
    document.getElementById('keyword').value = '';
    document.getElementById('location').value = '';
    document.getElementById('category').value = '';
    document.getElementById('job_type').value = '';
    document.getElementById('sort').value = 'latest';
    
    // Redirect to jobs index without parameters
    window.location.href = '{{ route("jobs.index") }}';
}

// Auto-submit form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const filterSelects = document.querySelectorAll('#job_type, #sort');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
@endpush
@endsection