<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Faculty\FacultyAuthController;
use App\Http\Controllers\Faculty\FacultyProfileController;

// Homepage
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Public pages
Route::get('/faculty', function () {
    return view('pages.faculty');
})->name('faculty');

Route::get('/student-council', function () {
    return view('pages.student-council');
})->name('student-council');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Login pages (other roles — views TBD)
Route::get('/jhs/login', function () {
    return view('auth.jhs-login');
})->name('jhs.login');

Route::get('/shs/login', function () {
    return view('auth.shs-login');
})->name('shs.login');

Route::get('/faculty/login', function () {
    return view('auth.faculty-login');
})->name('faculty.login');

Route::post('/faculty/login', [FacultyAuthController::class, 'login'])->name('faculty.login.post');
Route::post('/faculty/logout', [FacultyAuthController::class, 'logout'])->name('faculty.logout');

// Faculty Protected Routes
Route::middleware('faculty')->prefix('faculty')->name('faculty.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('faculty.profile');
    })->name('dashboard');

    Route::get('/profile',            [FacultyProfileController::class, 'show'])->name('profile');
    Route::patch('/profile/info',     [FacultyProfileController::class, 'updateInfo'])->name('profile.update');
    Route::patch('/profile/password', [FacultyProfileController::class, 'updatePassword'])->name('profile.password');

    // Placeholder routes for sidebar nav (pages to be built)
    Route::get('/students', function () {
        if (!session('faculty_id')) return redirect()->route('faculty.login');
        return view('faculty.students');
    })->name('students');
    Route::get('/calendar', function () {
        if (!session('faculty_id')) return redirect()->route('faculty.login');
        return view('faculty.calendar');
    })->name('calendar');
    Route::get('/gradebook', function () {
        if (!session('faculty_id')) return redirect()->route('faculty.login');
        return view('faculty.gradebook');
    })->name('gradebook');
    Route::get('/announcements', function () {
        if (!session('faculty_id')) return redirect()->route('faculty.login');
        return view('faculty.announcements');
    })->name('announcements');
    Route::get('/logs', function () {
        if (!session('faculty_id')) return redirect()->route('faculty.login');
        return view('faculty.logs');
    })->name('logs');
});

// Admin Auth
Route::get('/admin/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/faculty',              [FacultyController::class, 'index'])->name('faculty');
    Route::post('/faculty',             [FacultyController::class, 'store'])->name('faculty.store');
    Route::patch('/faculty/{faculty}',  [FacultyController::class, 'update'])->name('faculty.update');
    Route::delete('/faculty/{faculty}', [FacultyController::class, 'destroy'])->name('faculty.destroy');

    Route::get('/students',               [StudentController::class, 'index'])->name('students');
    Route::post('/students',              [StudentController::class, 'store'])->name('students.store');
    Route::patch('/students/{student}',   [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}',  [StudentController::class, 'destroy'])->name('students.destroy');

    Route::get('/announcements',                     [AnnouncementController::class, 'index'])->name('announcements');
    Route::post('/announcements',                    [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::patch('/announcements/{announcement}',    [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}',   [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/logs',     [AuditLogController::class, 'index'])->name('logs');
    Route::get('/settings',   [SettingsController::class, 'index'])->name('settings');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/profile',            [AdminProfileController::class, 'show'])->name('profile');
    Route::patch('/profile/info',     [AdminProfileController::class, 'updateInfo'])->name('profile.update');
    Route::patch('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
});
