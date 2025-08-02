<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Job Routes (Public)
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
Route::get('/jobs/category/{slug}', [JobController::class, 'category'])->name('jobs.category');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

// Authentication Routes
require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Application Routes
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::delete('/applications/{id}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    
    // Bookmark Routes
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{jobId}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::post('/bookmarks/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
});

// Role-based Dashboard Redirects
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isJobSeeker()) {
        return redirect()->route('job-seeker.dashboard');
    } elseif ($user->isEmployer()) {
        return redirect()->route('employer.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Job Seeker Routes
Route::middleware(['auth', 'role:job_seeker'])->prefix('job-seeker')->name('job-seeker.')->group(function () {
    Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [JobSeekerDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [JobSeekerDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/applications', [JobSeekerDashboardController::class, 'applications'])->name('applications');
    Route::get('/bookmarks', [JobSeekerDashboardController::class, 'bookmarks'])->name('bookmarks');
    Route::get('/resumes', [JobSeekerDashboardController::class, 'resumes'])->name('resumes');
    Route::post('/resumes', [JobSeekerDashboardController::class, 'uploadResume'])->name('resumes.upload');
    Route::delete('/resumes/{id}', [JobSeekerDashboardController::class, 'deleteResume'])->name('resumes.delete');
    Route::patch('/resumes/{id}/primary', [JobSeekerDashboardController::class, 'makePrimaryResume'])->name('resumes.primary');
    Route::get('/notifications', [JobSeekerDashboardController::class, 'notifications'])->name('notifications');
});

// Employer Routes
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [EmployerDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [EmployerDashboardController::class, 'updateProfile'])->name('profile.update');
    
    // Job Management
    Route::get('/jobs', [EmployerDashboardController::class, 'jobs'])->name('jobs.index');
    Route::get('/jobs/create', [EmployerDashboardController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs', [EmployerDashboardController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{id}', [EmployerDashboardController::class, 'showJob'])->name('jobs.show');
    Route::get('/jobs/{id}/edit', [EmployerDashboardController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{id}', [EmployerDashboardController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{id}', [EmployerDashboardController::class, 'deleteJob'])->name('jobs.delete');
    
    // Application Management
    Route::get('/applications', [EmployerDashboardController::class, 'applications'])->name('applications.index');
    Route::get('/applications/{id}', [EmployerDashboardController::class, 'showApplication'])->name('applications.show');
    Route::patch('/applications/{id}/status', [EmployerDashboardController::class, 'updateApplicationStatus'])->name('applications.status');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
    Route::get('/users/{id}', [AdminDashboardController::class, 'showUser'])->name('users.show');
    Route::patch('/users/{id}/role', [AdminDashboardController::class, 'updateUserRole'])->name('users.role');
    Route::delete('/users/{id}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');
    Route::get('/jobs', [AdminDashboardController::class, 'jobs'])->name('jobs.index');
    Route::patch('/jobs/{id}/status', [AdminDashboardController::class, 'updateJobStatus'])->name('jobs.status');
    Route::delete('/jobs/{id}', [AdminDashboardController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{id}', [AdminDashboardController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminDashboardController::class, 'deleteCategory'])->name('categories.delete');
});

// Legacy Profile Routes (for Breeze compatibility)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
