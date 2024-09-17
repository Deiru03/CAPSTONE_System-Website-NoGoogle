<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Views\Faculty;
class FacultyController extends Controller
{

    //////////////////////////////////////////////// Views Controller ////////////////////////////////////////////////  
    public function dashboard(): View
    {
        if (Auth::check() && Auth::user()->user_type === 'Faculty') {
            return view('dashboard');
        }
        return view('admindashboard'); // E redirect sa admin dashboard kun di sya admin bala
    }
    public function clearances(): View
    {
        return view('faculty.views.clearances');
    }

    public function myFiles(): View
    {
        return view('faculty.views.my-files');
    }
    public function submittedReports(): View
    {
        return view('faculty.views.submitted-reports');
    }   
    public function archive(): View
    {
        return view('faculty.views.archive');
    }
    public function test(): View
    {
        return view('faculty.views.test-page');
    }
    
}

/////////////////////////////////////////////// End of Views Controller ////////////////////////////////////////////////  
