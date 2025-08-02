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
                        <a class="nav-link active" href="{{ route('job-seeker.profile') }}">
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
                <h1 class="h2">My Profile</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="mb-0">Profile Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('job-seeker.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone" 
                                               value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="avatar" class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                        <small class="form-text text-muted">Max size: 2MB. Formats: JPG, PNG</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio / About Me</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="4" 
                                              placeholder="Tell employers about yourself, your skills, and career goals...">{{ old('bio', $user->bio) }}</textarea>
                                    <small class="form-text text-muted">Maximum 1000 characters</small>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Profile Preview -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Profile Preview</h5>
                        </div>
                        <div class="card-body text-center">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Picture" 
                                     class="rounded-circle mb-3" width="100" height="100" style="object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                            @endif
                            
                            <h5>{{ $user->name }}</h5>
                            <p class="text-muted">{{ $user->email }}</p>
                            
                            @if($user->phone)
                                <p class="text-muted">
                                    <i class="fas fa-phone me-1"></i>{{ $user->phone }}
                                </p>
                            @endif
                            
                            @if($user->bio)
                                <p class="small">{{ Str::limit($user->bio, 100) }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Completion -->
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="mb-0">Profile Completion</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $fields = ['name', 'email', 'phone', 'bio', 'avatar'];
                                $completed = 0;
                                foreach ($fields as $field) {
                                    if (!empty($user->$field)) {
                                        $completed++;
                                    }
                                }
                                if ($user->resumes()->count() > 0) {
                                    $completed++;
                                    $fields[] = 'resume';
                                }
                                $percentage = round(($completed / count($fields)) * 100);
                            @endphp
                            
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%">
                                    {{ $percentage }}%
                                </div>
                            </div>
                            
                            <ul class="list-unstyled small">
                                <li class="{{ $user->name ? 'text-success' : 'text-muted' }}">
                                    <i class="fas fa-{{ $user->name ? 'check' : 'times' }} me-2"></i>Full Name
                                </li>
                                <li class="{{ $user->email ? 'text-success' : 'text-muted' }}">
                                    <i class="fas fa-{{ $user->email ? 'check' : 'times' }} me-2"></i>Email Address
                                </li>
                                <li class="{{ $user->phone ? 'text-success' : 'text-muted' }}">
                                    <i class="fas fa-{{ $user->phone ? 'check' : 'times' }} me-2"></i>Phone Number
                                </li>
                                <li class="{{ $user->bio ? 'text-success' : 'text-muted' }}">
                                    <i class="fas fa-{{ $user->bio ? 'check' : 'times' }} me-2"></i>Bio / About Me
                                </li>
                                <li class="{{ $user->avatar ? 'text-success' : 'text-muted' }}">
                                    <i class="fas fa-{{ $user->avatar ? 'check' : 'times' }} me-2"></i>Profile Picture
                                </li>
                                <li class="{{ $user->resumes()->count() > 0 ? 'text-success' : 'text-muted' }}">
                                    <i class="fas fa-{{ $user->resumes()->count() > 0 ? 'check' : 'times' }} me-2"></i>Resume Uploaded
                                </li>
                            </ul>
                            
                            @if($percentage < 100)
                                <p class="small text-muted">
                                    Complete your profile to increase your chances of getting hired!
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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