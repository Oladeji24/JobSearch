<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Get platform statistics
        $stats = [
            'total_users' => \App\Models\User::count(),
            'job_seekers' => \App\Models\User::where('role', 'job_seeker')->count(),
            'employers' => \App\Models\User::where('role', 'employer')->count(),
            'total_jobs' => \App\Models\Job::count(),
            'active_jobs' => \App\Models\Job::active()->count(),
            'total_applications' => \App\Models\Application::count(),
            'pending_applications' => \App\Models\Application::where('status', 'pending')->count(),
            'total_categories' => \App\Models\Category::count(),
        ];

        // Get recent activities
        $recentUsers = \App\Models\User::latest()->take(5)->get();
        $recentJobs = \App\Models\Job::with(['employer', 'category'])->latest()->take(5)->get();
        $recentApplications = \App\Models\Application::with(['user', 'job'])->latest()->take(5)->get();

        // Get monthly statistics for charts
        $monthlyStats = $this->getMonthlyStats();

        return view('admin.dashboard', compact(
            'stats', 
            'recentUsers', 
            'recentJobs', 
            'recentApplications',
            'monthlyStats'
        ));
    }

    public function users(Request $request)
    {
        $role = $request->get('role');
        $search = $request->get('search');

        $users = \App\Models\User::query()
            ->when($role, function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount(['jobs', 'applications'])
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    public function showUser($id)
    {
        $user = \App\Models\User::with(['jobs', 'applications', 'employerProfile'])
            ->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:job_seeker,employer,admin',
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Prevent deleting the current admin
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    public function jobs(Request $request)
    {
        $status = $request->get('status');
        $source = $request->get('source');
        $search = $request->get('search');

        $jobs = \App\Models\Job::with(['employer', 'category'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($source, function ($query) use ($source) {
                $query->where('source', $source);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%");
                });
            })
            ->withCount('applications')
            ->latest()
            ->paginate(15);

        return view('admin.jobs.index', compact('jobs', 'status', 'source', 'search'));
    }

    public function updateJobStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,filled,expired,draft',
        ]);

        $job = \App\Models\Job::findOrFail($id);
        $job->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Job status updated successfully!');
    }

    public function deleteJob($id)
    {
        $job = \App\Models\Job::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }

    public function categories()
    {
        $categories = \App\Models\Category::withCount('jobs')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
        ]);

        \App\Models\Category::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
            'is_active' => true,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        
        // Check if category has jobs
        if ($category->jobs()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with existing jobs.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    private function getMonthlyStats()
    {
        $months = [];
        $userCounts = [];
        $jobCounts = [];
        $applicationCounts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $userCounts[] = \App\Models\User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $jobCounts[] = \App\Models\Job::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $applicationCounts[] = \App\Models\Application::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'months' => $months,
            'users' => $userCounts,
            'jobs' => $jobCounts,
            'applications' => $applicationCounts,
        ];
    }
}
