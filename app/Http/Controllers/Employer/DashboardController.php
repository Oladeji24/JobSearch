<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:employer']);
    }

    public function index()
    {
        $user = auth()->user();
        
        // Get dashboard statistics
        $stats = [
            'total_jobs' => $user->jobs()->count(),
            'active_jobs' => $user->jobs()->active()->count(),
            'total_applications' => $user->jobs()->withCount('applications')->get()->sum('applications_count'),
            'pending_applications' => \App\Models\Application::where('employer_id', $user->id)->where('status', 'pending')->count(),
        ];

        // Get recent jobs
        $recentJobs = $user->jobs()
            ->with(['category'])
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        // Get recent applications
        $recentApplications = \App\Models\Application::where('employer_id', $user->id)
            ->with(['user', 'job'])
            ->latest()
            ->take(5)
            ->get();

        return view('employer.dashboard', compact(
            'stats', 
            'recentJobs', 
            'recentApplications'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->employerProfile;
        
        return view('employer.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            // Company profile fields
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string|max:2000',
            'website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user data
        $userData = $request->only(['name', 'email', 'phone', 'bio']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($userData);

        // Update or create employer profile
        $profileData = $request->only([
            'company_name', 'company_description', 'website', 'industry', 
            'company_size', 'address', 'city', 'state', 'country'
        ]);

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            $profile = $user->employerProfile;
            if ($profile && $profile->company_logo && file_exists(storage_path('app/public/' . $profile->company_logo))) {
                unlink(storage_path('app/public/' . $profile->company_logo));
            }
            $profileData['company_logo'] = $request->file('company_logo')->store('company-logos', 'public');
        }

        $user->employerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('employer.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function jobs()
    {
        $jobs = auth()->user()->jobs()
            ->with(['category'])
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function createJob()
    {
        $categories = \App\Models\Category::active()->get();
        return view('employer.jobs.create', compact('categories'));
    }

    public function storeJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,remote,internship',
            'salary_min' => 'nullable|string|max:255',
            'salary_max' => 'nullable|string|max:255',
            'closing_date' => 'nullable|date|after:today',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);

        $job = auth()->user()->jobs()->create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'company_name' => auth()->user()->employerProfile->company_name ?? auth()->user()->name,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'job_type' => $request->job_type,
            'closing_date' => $request->closing_date,
            'requirements' => $request->requirements ? explode(',', $request->requirements) : null,
            'benefits' => $request->benefits ? explode(',', $request->benefits) : null,
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job posted successfully!');
    }

    public function showJob($id)
    {
        $job = auth()->user()->jobs()
            ->with(['category', 'applications.user'])
            ->findOrFail($id);

        return view('employer.jobs.show', compact('job'));
    }

    public function editJob($id)
    {
        $job = auth()->user()->jobs()->findOrFail($id);
        $categories = \App\Models\Category::active()->get();
        
        return view('employer.jobs.edit', compact('job', 'categories'));
    }

    public function updateJob(Request $request, $id)
    {
        $job = auth()->user()->jobs()->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,remote,internship',
            'salary_min' => 'nullable|string|max:255',
            'salary_max' => 'nullable|string|max:255',
            'closing_date' => 'nullable|date|after:today',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'status' => 'required|in:active,filled,expired,draft',
        ]);

        $job->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'job_type' => $request->job_type,
            'closing_date' => $request->closing_date,
            'requirements' => $request->requirements ? explode(',', $request->requirements) : null,
            'benefits' => $request->benefits ? explode(',', $request->benefits) : null,
            'status' => $request->status,
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    public function deleteJob($id)
    {
        $job = auth()->user()->jobs()->findOrFail($id);
        $job->delete();

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }

    public function applications()
    {
        $applications = \App\Models\Application::where('employer_id', auth()->id())
            ->with(['user', 'job'])
            ->latest()
            ->paginate(15);

        return view('employer.applications.index', compact('applications'));
    }

    public function showApplication($id)
    {
        $application = \App\Models\Application::where('employer_id', auth()->id())
            ->with(['user', 'job'])
            ->findOrFail($id);

        // Mark as viewed if not already
        if ($application->status === 'pending') {
            $application->markAsViewed();
        }

        return view('employer.applications.show', compact('application'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $application = \App\Models\Application::where('employer_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,viewed,shortlisted,rejected,accepted',
        ]);

        $application->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Application status updated successfully!');
    }
}
