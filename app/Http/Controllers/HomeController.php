<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get platform statistics
        $stats = [
            'total_jobs' => \App\Models\Job::count(),
            'total_employers' => \App\Models\User::where('role', 'employer')->count(),
            'total_job_seekers' => \App\Models\User::where('role', 'job_seeker')->count(),
            'total_applications' => \App\Models\Application::count(),
        ];

        // Get recent jobs
        $recentJobs = \App\Models\Job::with(['category', 'employer'])
            ->active()
            ->latest()
            ->take(6)
            ->get();

        // Get active categories
        $categories = \App\Models\Category::active()
            ->withCount('jobs')
            ->take(8)
            ->get();

        return view('welcome', compact('stats', 'recentJobs', 'categories'));
    }
}
