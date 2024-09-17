<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->user_type === 'Admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('faculty.dashboard');
        }
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/////////////////////////////////////////////// Redirects If Not Admin or Faculty Middleware ////////////////////////////////////////////////
Route::middleware(['Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['Faculty'])->group(function () {
    Route::get('/faculty', [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
});
/////////////////////////////////////////////// End of Redirects If Not Admin or Faculty Middleware ////////////////////////////////////////////////

/////////////////////////////////////////////// Admin Routes ////////////////////////////////////////////////
Route::middleware(['auth', 'verified', 'Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/clearances', [AdminController::class, 'clearances'])->name('admin.views.clearances');
    Route::get('/submitted-reports', [AdminController::class, 'submittedReports'])->name('admin.views.submittedReports');
    Route::get('/faculty', [AdminController::class, 'faculty'])->name('admin.views.faculty');
    Route::get('/my-files', [AdminController::class, 'myFiles'])->name('admin.views.myFiles');
    Route::get('/archive', [AdminController::class, 'archive'])->name('admin.views.archive');
    Route::get('/profile', [AdminController::class, 'profileEdit'])->name('admin.profile.edit');
});

/////////////////////////////////////////////// End of Admin Routes ////////////////////////////////////////////////
/////////////////////////////////////////////// Faculty Routes ////////////////////////////////////////////////
Route::middleware(['auth', 'verified', 'Faculty'])->prefix('faculty')->group(function () {
    Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
    Route::get('/clearances', [FacultyController::class, 'clearances'])->name('faculty.views.clearances');
    Route::get('/submitted-reports', [FacultyController::class, 'submittedReports'])->name('faculty.views.submittedReports');
    Route::get('/my-files', [FacultyController::class, 'myFiles'])->name('faculty.views.myFiles');
    Route::get('/archive', [FacultyController::class, 'archive'])->name('faculty.views.archive');
    Route::get('/test', [FacultyController::class, 'test'])->name('faculty.views.test');
}); 
/////////////////////////////////////////////// End of Faculty Routes ////////////////////////////////////////////////

require __DIR__.'/auth.php';