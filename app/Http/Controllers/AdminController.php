<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Views\Admin;
/////////////////////////////////////////////// Admin ViewsController ////////////////////////////////////////////////
class AdminController extends Controller
{
    public function dashboard(): View
    {
        //////////////////////// Clearance Counts //////////////////////////
        $TotalUser = User::count();
        $clearancePending = User::where('clearances_status', 'pending')->count();
        $clearanceComplete = User::where('clearances_status', 'complete')->count();
        $clearanceReturn = User::where('clearances_status', 'return')->count();
        $clearanceTotal = $clearancePending + $clearanceComplete + $clearanceReturn;
        //////////////////////// Faculty Counts //////////////////////////
        $facultyPermanent = User::where('position', 'Permanent')->count();
        $facultyTemporary = User::where('position', 'Temporary')->count();
        $facultyPartTime = User::where('position', 'Part-Time')->count();

        if (Auth::check() && Auth::user()->user_type === 'Faculty') {
            return view('dashboard');
        }
        //////////////////////// Dashboard Throw Variables //////////////////////////
        return view('admindashboard', compact('TotalUser', 'clearancePending',
         'clearanceComplete', 'clearanceReturn', 'clearanceTotal',
         'facultyPermanent', 'facultyTemporary', 'facultyPartTime'));
    }

    public function clearances(Request $request): View
    {
        $clearance = User::all();
        $clearance = User::select('id', 'name', 'email', 'program', 'units', 'position', 'clearances_status', 'last_clearance_update', 'checked_by')->get();
        {
            $query = User::query();
        
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('program', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%")
                        ->orWhere('clearances_status', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
            }
        
            if ($request->has('sort')) {
                $sort = $request->input('sort');
                $query->orderBy('id', $sort);
            }
        
            $clearance = $query->get();
        return view ('admin.views.clearances', compact('clearance'));
        }
    }   

    public function submittedReports(): View
    {
        return view ('admin.views.submitted-reports');
    }

    public function faculty(Request $request): View
    {
        $faculty = User::all();
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('program', 'like', '%' . $search . '%')
                  ->orWhere('position', 'like', '%' . $search . '%')
                  ->orWhere('units', 'like', '%' . $search . '%');
        }

        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $query->orderBy('id', $sort);
        }


        $faculty = $query->paginate(10);

        return view ('admin.views.faculty', compact('faculty'));
    }

    public function myFiles(): View
    {
        return view ('admin.views.my-files');
    }

    public function archive(): View
    {
        return view ('admin.views.archive');
    }

    public function profileEdit(): View
    {
        $user = Auth::user();
        return view ('admin.profile.edit', compact('user'));
    }
    /////////////////////////////////////////////// End of Views Controller ////////////////////////////////////////////////

    /////////////////////////////////////////////// Edit Faculty /////////////////////////////////////////////////
    public function getFacultyData($id)
    {
        try {
            $facultyMember = User::findOrFail($id);
            return response()->json(['success' => true, 'faculty' => $facultyMember]);
        } catch (\Exception $e) {
            Log::error('Error fetching faculty member: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to fetch faculty member.'], 500);
        }
    }

    public function editFaculty(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'program' => 'nullable|string|max:255',
            'units' => 'nullable|integer',
            'position' => 'nullable|string|max:255',
        ]);

        try {
            $facultyMember = User::findOrFail($validatedData['id']);
            $facultyMember->update($validatedData);

            return response()->json(['success' => true, 'message' => 'Faculty member updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Error updating faculty member: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update faculty member.'], 500);
        }
    }

    public function deleteFaculty(Request $request, $id)
    {
        try {
            $facultyMember = User::findOrFail($id);

            // Optional: Prevent deletion of certain users
            // if ($facultyMember->user_type !== 'Faculty') {
            //     return response()->json(['success' => false, 'message' => 'Invalid user type.'], 400);
            // }

            $facultyMember->delete();

            return response()->json(['success' => true, 'message' => 'Faculty member deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting faculty member: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete faculty member.'], 500);
        }
    }
    ///////////////////////////////////////////// Clearance User Update /////////////////////////////////////////////
    public function updateFacultyClearanceUser(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'id' => 'required|exists:users,id',
                'clearances_status' => 'required|in:pending,complete,return',
                'checked_by' => 'required|string|max:255',
                // Note: 'last_clearance_update' is managed server-side
            ]);
    
            // Retrieve the user
            $user = User::findOrFail($validated['id']);
    
            // Update clearance status and checked by fields
            $user->clearances_status = $validated['clearances_status'];
            $user->checked_by = $validated['checked_by'];
    
            // Set 'last_clearance_update' to the current timestamp using Carbon
            $user->last_clearance_update = now();
    
            // Save the changes
            $user->save();
    
            // Return a success response with the updated user data
            return response()->json([
                'success' => true,
                'message' => 'Clearance updated successfully.',
                'user' => [
                    'id' => $user->id,
                    'clearances_status' => $user->clearances_status,
                    'checked_by' => $user->checked_by,
                    'last_clearance_update' => $user->last_clearance_update->format('Y-m-d H:i:s'),
                ],
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Clearance Update Error: ' . $e->getMessage());
    
            // Return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update clearance.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
