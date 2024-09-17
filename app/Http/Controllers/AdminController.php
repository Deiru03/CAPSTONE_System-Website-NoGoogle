<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
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

    public function clearances(): View
    {
        return view ('admin.views.clearances');
    }

    public function submittedReports(): View
    {
        return view ('admin.views.submitted-reports');
    }

    public function faculty(): View
    {
        return view ('admin.views.faculty');
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
    /////////////////////////////////////////////// End of Admin Views Controller ////////////////////////////////////////////////
}
