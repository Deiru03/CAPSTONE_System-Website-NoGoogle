<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clearance;
use App\Models\ClearanceRequirement;
use App\Models\ClearanceDocument;

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
    public function requirements($clearanceId)
    {
        $clearance = Clearance::with('requirements')->findOrFail($clearanceId);
        return view('admin.views.clearances.clearance-requirements', compact('clearance'));
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

        $clearance->requirements()->create([
            'requirement' => $request->requirement,
        ]);

        // Update the number_of_requirements
        $clearance->update([
            'number_of_requirements' => $clearance->requirements()->count(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Requirement added successfully.',
            'requirement' => $clearance->requirements()->latest()->first(),
        ]);
    }

    /**
     * Fetch a requirement for editing.
     */
    public function editRequirement($clearanceId, $requirementId)
    {
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->findOrFail($requirementId);

        return response()->json([
            'success' => true,
            'requirement' => $requirement,
        ]);
    }

    /**
     * Update a requirement.
     */
    public function updateRequirement(Request $request, $clearanceId, $requirementId)
    {
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->findOrFail($requirementId);

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
        $requirement = ClearanceRequirement::where('clearance_id', $clearanceId)->findOrFail($requirementId);
        $requirement->delete();

        // Update the number_of_requirements
        $clearance = Clearance::findOrFail($clearanceId);
        $clearance->update([
            'number_of_requirements' => $clearance->requirements()->count(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Requirement deleted successfully.',
        ]);
    }
}