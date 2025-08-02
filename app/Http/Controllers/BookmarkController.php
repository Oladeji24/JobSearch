<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);

        $user = auth()->user();
        $jobId = $request->job_id;

        // Check if already bookmarked
        if ($user->hasBookmarked($jobId)) {
            return response()->json([
                'success' => false,
                'message' => 'Job already bookmarked.'
            ]);
        }

        // Create bookmark
        $user->bookmarks()->create(['job_id' => $jobId]);

        return response()->json([
            'success' => true,
            'message' => 'Job bookmarked successfully!'
        ]);
    }

    public function destroy($jobId)
    {
        $user = auth()->user();
        $bookmark = $user->bookmarks()->where('job_id', $jobId)->first();

        if (!$bookmark) {
            return response()->json([
                'success' => false,
                'message' => 'Bookmark not found.'
            ]);
        }

        $bookmark->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bookmark removed successfully!'
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);

        $user = auth()->user();
        $jobId = $request->job_id;

        $bookmark = $user->bookmarks()->where('job_id', $jobId)->first();

        if ($bookmark) {
            // Remove bookmark
            $bookmark->delete();
            $bookmarked = false;
            $message = 'Bookmark removed successfully!';
        } else {
            // Add bookmark
            $user->bookmarks()->create(['job_id' => $jobId]);
            $bookmarked = true;
            $message = 'Job bookmarked successfully!';
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
            'message' => $message
        ]);
    }
}
