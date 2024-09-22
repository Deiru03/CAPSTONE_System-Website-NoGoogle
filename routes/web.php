<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\Admin\ClearanceController;
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

    //////////////////////// Edit Faculty //////////////////////
    Route::get('/faculty/edit/{id}', [AdminController::class, 'getFacultyData'])->name('admin.faculty.getData'); // Get Faculty Data
    Route::post('/faculty/edit', [AdminController::class, 'editFaculty'])->name('admin.faculty.edit'); // Edit Faculty
    Route::delete('/faculty/delete/{id}', [AdminController::class, 'deleteFaculty'])->name('admin.faculty.delete'); // Delete Faculty
    Route::post('/clearance/update', [AdminController::class, 'updateFacultyClearanceUser'])->name('admin.views.update-clearance'); // Update Clearance

    // Clearance Management
    Route::get('/clearance', [ClearanceController::class, 'index'])->name('admin.clearance.manage');
    Route::post('/clearance/store', [ClearanceController::class, 'store'])->name('admin.clearance.store');
    Route::get('/clearance/edit/{id}', [ClearanceController::class, 'edit'])->name('admin.clearance.edit');
    Route::post('/clearance/update/{id}', [ClearanceController::class, 'update'])->name('admin.clearance.update');
    Route::delete('/clearance/delete/{id}', [ClearanceController::class, 'destroy'])->name('admin.clearance.destroy');

    Route::prefix('clearance/{clearanceId}/requirements')->group(function () {
        Route::get('/', [ClearanceController::class, 'requirements'])->name('admin.clearance.requirements');
        Route::post('/store', [ClearanceController::class, 'storeRequirement'])->name('admin.clearance.requirements.store');
        Route::get('/edit/{requirementId}', [ClearanceController::class, 'editRequirement'])->name('admin.clearance.requirements.edit');
        Route::post('/update/{requirementId}', [ClearanceController::class, 'updateRequirement'])->name('admin.clearance.requirements.update');
        Route::delete('/delete/{requirementId}', [ClearanceController::class, 'destroyRequirement'])->name('admin.clearance.requirements.destroy');
    });
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