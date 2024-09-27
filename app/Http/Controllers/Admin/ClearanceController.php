<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clearance;
use App\Models\ClearanceRequirement;
use App\Models\SharedClearance;
use Illuminate\Support\Facades\DB;

class ClearanceController extends Controller
{
    // Display the clearance management page
    public function index()
    {
        $clearances = Clearance::all();
        return view('admin.views.clearances.clearance-management', compact('clearances'));
    }

    // Store a new clearance
    public function store(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'nullable|integer',
            'type' => 'required|in:Permanent,Part-Timer,Temporary',
        ]);

        $clearance = Clearance::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Clearance created successfully.',
            'clearance' => $clearance
        ]);
    }

    // Fetch a clearance for editing
    public function edit($id)
    {
        $clearance = Clearance::find($id);
        if ($clearance) {
            return response()->json([
                'success' => true,
                'clearance' => $clearance
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Clearance not found.'
            ], 404);
        }
    }

    // Update a clearance
    public function update(Request $request, $id)
    {
        $clearance = Clearance::find($id);
        if (!$clearance) {
            return response()->json([
                'success' => false,
                'message' => 'Clearance not found.'
            ], 404);
        }

        $request->validate([
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'nullable|integer',
            'type' => 'required|in:Permanent,Part-Timer,Temporary',
        ]);

        $clearance->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Clearance updated successfully.',
            'clearance' => $clearance
        ]);
    }

    public function share(Request $request, $id)
    {
        $clearance = Clearance::findOrFail($id);

        // Check if the clearance is already shared
        $existingShare = SharedClearance::where('clearance_id', $clearance->id)->first();
        if ($existingShare) {
            return response()->json([
                'success' => false,
                'message' => 'Clearance is already shared.',
            ]);
        }

        DB::beginTransaction();

        try {
            SharedClearance::create([
                'clearance_id' => $clearance->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Clearance shared successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to share clearance.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete a clearance
    public function destroy($id)
    {
        $clearance = Clearance::find($id);
        if (!$clearance) {
            return response()->json([
                'success' => false,
                'message' => 'Clearance not found.'
            ], 404);
        }

        $clearance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Clearance deleted successfully.'
        ]);
    }

    ///////////////////////////////////////// Clearance Requirements ///////////////////////////////////////
    /**
     * Display the requirements for a specific clearance.
     */
    public function requirements(Request $request, $clearanceId)
    {
        $clearance = Clearance::with('requirements')->find($clearanceId);
        if ($request->ajax()) {
            if ($clearance) {
                return response()->json([
                    'success' => true,
                    'requirements' => $clearance->requirements,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Clearance not found.'
                ], 404);
            }
        } else {
            // If not AJAX, load the requirements blade view
            if ($clearance) {
                return view('admin.views.clearances.clearance-requirements', compact('clearance'));
            } else {
                abort(404);
            }
        }
    }

    /**
     * Store a new requirement for a clearance.
     */
    public function storeRequirement(Request $request, $clearanceId)
    {
        $clearance = Clearance::findOrFail($clearanceId);

        $request->validate([
            'requirement' => 'required|string|max:255',
        ]);

        $requirement = $clearance->requirements()->create([
            'requirement' => $request->requirement,
        ]);

        // Update the number_of_requirements
        $clearance->number_of_requirements = $clearance->requirements()->count();
        $clearance->save();

        return response()->json([
            'success' => true,
            'message' => 'Requirement added successfully.',
            'requirement' => $requirement,
        ]);
    }

    /**
     * Fetch a requirement for editing.
     */
    public function editRequirement($clearanceId, $requirementId)
    {
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->find($requirementId);

        if ($requirement) {
            return response()->json([
                'success' => true,
                'requirement' => $requirement,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Requirement not found.'
            ], 404);
        }
    }

    /**
     * Update a requirement.
     */
    public function updateRequirement(Request $request, $clearanceId, $requirementId)
    {
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->find($requirementId);

        if (!$requirement) {
            return response()->json([
                'success' => false,
                'message' => 'Requirement not found.'
            ], 404);
        }

        $request->validate([
            'requirement' => 'required|string|max:255',
        ]);

        $requirement->update([
            'requirement' => $request->requirement,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Requirement updated successfully.',
            'requirement' => $requirement,
        ]);
    }

    /**
     * Delete a requirement.
     */
    public function destroyRequirement($clearanceId, $requirementId)
    {
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->find($requirementId);

        if (!$requirement) {
            return response()->json([
                'success' => false,
                'message' => 'Requirement not found.'
            ], 404);
        }

        $requirement->delete();

        // Update the number_of_requirements
        $clearance = Clearance::findOrFail($clearanceId);
        $clearance->number_of_requirements = $clearance->requirements()->count();
        $clearance->save();

        return response()->json([
            'success' => true,
            'message' => 'Requirement deleted successfully.',
        ]);
    }
}