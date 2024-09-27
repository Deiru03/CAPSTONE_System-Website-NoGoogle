<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SharedClearance;
use App\Models\UploadedClearance;
use App\Models\UserClearance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ClearanceController extends Controller
{/**
     * Display a listing of shared clearances for the faculty.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all shared clearances with their associated clearance data
        $sharedClearances = SharedClearance::with('clearance')->get();

        // Get user_clearances to map shared_clearance_id to user_clearance_id
        $userClearances = UserClearance::where('user_id', $user->id)
            ->whereIn('shared_clearance_id', $sharedClearances->pluck('id'))
            ->pluck('id', 'shared_clearance_id')
            ->toArray();

        return view('faculty.views.clearances.clearance-index', compact('sharedClearances', 'userClearances'));
    }

    /**
     * Handle the user getting a copy of a shared clearance.
     */
    public function getCopy($id)
    {
        $user = Auth::user();
        $sharedClearance = SharedClearance::findOrFail($id);

        // Check if the user has already copied this clearance
        $existingCopy = UserClearance::where('shared_clearance_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingCopy) {
            return redirect()->route('faculty.clearances.index')->with('error', 'You have already copied this clearance.');
        }

        // Create a new user clearance
        UserClearance::create([
            'shared_clearance_id' => $id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('faculty.clearances.index')->with('success', 'Clearance copied successfully.');
    }
    /**
     * Display the specified shared clearance and its requirements.
     */
    public function show($id)
    {
        $user = Auth::user();

        // Confirm that the user has copied this clearance
        $userClearance = UserClearance::where('id', $id)
            ->where('user_id', $user->id)
            ->with('sharedClearance.clearance.requirements')
            ->firstOrFail();

        // Fetch already uploaded clearances by the user for this shared clearance
        $uploadedClearances = UploadedClearance::where('shared_clearance_id', $userClearance->shared_clearance_id)
            ->where('user_id', $user->id)
            ->pluck('requirement_id')
            ->toArray();

        return view('faculty.views.clearances.clearance-show', compact('userClearance', 'uploadedClearances'));
    }

    /**
     * Handle the upload of a requirement.
     */
    public function upload(Request $request, $id, $requirementId, $userClearanceId)
    {
        $user = Auth::user();
        $userClearanceId = $request->input('userClearanceId');

        $userClearance = UserClearance::where('id', $userClearanceId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Adjust as needed
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads/faculty_clearances', 'public');

            // Create or update the uploaded clearance
            UploadedClearance::updateOrCreate(
                [
                    'shared_clearance_id' => $userClearance->shared_clearance_id,
                    'requirement_id' => $requirementId,
                    'user_id' => $user->id,
                ],
                [
                    'file_path' => $path,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded.',
        ], 400);
    }
}
