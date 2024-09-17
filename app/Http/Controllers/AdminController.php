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
        if (Auth::check() && Auth::user()->user_type === 'Admin') {
            return view('admindashboard');
        }
        return view('dashboard');
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
