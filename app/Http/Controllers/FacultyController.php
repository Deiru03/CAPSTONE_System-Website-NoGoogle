<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UploadedClearance;
use App\Models\UserClearance;
class FacultyController extends Controller
{

    //////////////////////////////////////////////// Views Controller ////////////////////////////////////////////////  
    public function dashboard(): View
    {
        if (Auth::check() && Auth::user()->user_type === 'Admin') {
            return view('admindashboard');
        }
        return view('dashboard'); // E redirect sa admin dashboard kun di sya admin bala
    }
    public function clearances(): View
    {
            // Fetch the user clearance data
        $userClearance = UserClearance::with('sharedClearance.clearance')->where('user_id', Auth::id())->first();

        return view('faculty.views.clearances', compact('userClearance'));
    }

    public function myFiles(): View
    {
        $user = Auth::user();

        // Fetch all uploaded clearances for the authenticated user
        $uploadedFiles = UploadedClearance::where('user_id', $user->id)->with('requirement')->get();
    
        return view('faculty.views.my-files', compact('uploadedFiles'));
    }
    public function submittedReports(): View
    {
        return view('faculty.views.submitted-reports');
    }   
    public function test(): View
    {
        return view('faculty.views.test-page');
    }       
    
/////////////////////////////////////////////// End of Views Controller ////////////////////////////////////////////////  
}
