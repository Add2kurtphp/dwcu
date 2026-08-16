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
use App\Http\Controllers\Faculty\StudentController as FacultyStudentController;
use App\Http\Controllers\Faculty\ReportFormController as FacultyReportFormController;
use App\Http\Controllers\Faculty\GradebookController as FacultyGradebookController;
use App\Http\Controllers\Faculty\GradeController as FacultyGradeController;
use App\Http\Controllers\Faculty\QuizController as FacultyQuizController;
use App\Http\Controllers\Faculty\SubmissionController as FacultySubmissionController;
use App\Http\Controllers\Faculty\AnnouncementController as FacultyAnnouncementController;
use App\Http\Controllers\Faculty\LogController as FacultyLogController;
use App\Http\Controllers\JHS\JHSAuthController;
use App\Http\Controllers\JHS\JHSProfileController;
use App\Http\Controllers\JHS\QuizController as JHSQuizController;
use App\Http\Controllers\JHS\AnnouncementController as JHSAnnouncementController;
use App\Http\Controllers\JHS\LogController as JHSLogController;
use App\Http\Controllers\SHS\SHSAuthController;
use App\Http\Controllers\SHS\SHSProfileController;
use App\Http\Controllers\SHS\QuizController as SHSQuizController;
use App\Http\Controllers\SHS\AnnouncementController as SHSAnnouncementController;
use App\Http\Controllers\SHS\LogController as SHSLogController;

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

// JHS Auth
Route::get('/jhs/login',  function () { return view('auth.jhs-login'); })->name('jhs.login');
Route::post('/jhs/login', [JHSAuthController::class, 'login'])->middleware('throttle:5,1')->name('jhs.login.post');
Route::post('/jhs/logout', [JHSAuthController::class, 'logout'])->name('jhs.logout');

// JHS Protected Routes
Route::middleware('jhs')->prefix('jhs')->name('jhs.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('jhs.profile');
    })->name('dashboard');

    Route::get('/profile',            [JHSProfileController::class, 'show'])->name('profile');
    Route::patch('/profile/info',     [JHSProfileController::class, 'updateInfo'])->name('profile.update');
    Route::patch('/profile/password', [JHSProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/announcement', [JHSAnnouncementController::class, 'index'])->name('announcement');

    Route::get('/assignments', function () {
        return view('jhs.assignments');
    })->name('assignments');

    Route::get('/quizzes',              [JHSQuizController::class, 'index'])->name('quizzes');
    Route::get('/quizzes/{quiz}',       [JHSQuizController::class, 'show'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [JHSQuizController::class, 'submit'])->name('quizzes.submit');

    Route::get('/gradebook', function () {
        return view('jhs.gradebook');
    })->name('gradebook');

    Route::get('/calendar', function () {
        return view('jhs.calendar');
    })->name('calendar');

    Route::get('/logs', [JHSLogController::class, 'index'])->name('logs');
});

// SHS Auth
Route::get('/shs/login',  function () { return view('auth.shs-login'); })->name('shs.login');
Route::post('/shs/login', [SHSAuthController::class, 'login'])->middleware('throttle:5,1')->name('shs.login.post');
Route::post('/shs/logout', [SHSAuthController::class, 'logout'])->name('shs.logout');

// SHS Protected Routes
Route::middleware('shs')->prefix('shs')->name('shs.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('shs.profile');
    })->name('dashboard');

    Route::get('/profile',            [SHSProfileController::class, 'show'])->name('profile');
    Route::patch('/profile/info',     [SHSProfileController::class, 'updateInfo'])->name('profile.update');
    Route::patch('/profile/password', [SHSProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/announcement', [SHSAnnouncementController::class, 'index'])->name('announcement');
    Route::get('/assignments',  function () { return view('shs.assignments'); })->name('assignments');
    Route::get('/quizzes',                [SHSQuizController::class, 'index'])->name('quizzes');
    Route::get('/quizzes/{quiz}',         [SHSQuizController::class, 'show'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [SHSQuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/gradebook',    function () { return view('shs.gradebook'); })->name('gradebook');
    Route::get('/calendar',     function () { return view('shs.calendar'); })->name('calendar');
    Route::get('/logs',         [SHSLogController::class, 'index'])->name('logs');
});

Route::get('/faculty/login', function () {
    return view('auth.faculty-login');
})->name('faculty.login');

Route::post('/faculty/login', [FacultyAuthController::class, 'login'])->middleware('throttle:5,1')->name('faculty.login.post');
Route::post('/faculty/logout', [FacultyAuthController::class, 'logout'])->name('faculty.logout');

// Faculty Protected Routes
Route::middleware('faculty')->prefix('faculty')->name('faculty.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('faculty.profile');
    })->name('dashboard');

    Route::get('/profile',            [FacultyProfileController::class, 'show'])->name('profile');
    Route::patch('/profile/info',     [FacultyProfileController::class, 'updateInfo'])->name('profile.update');
    Route::patch('/profile/password', [FacultyProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/students', [FacultyStudentController::class, 'index'])->name('students');

    Route::get('/students/{student}/sf9',  [FacultyReportFormController::class, 'sf9'])->name('students.sf9');
    Route::get('/students/{student}/sf10', [FacultyReportFormController::class, 'sf10'])->name('students.sf10');

    Route::get('/quizzes',                    [FacultyQuizController::class, 'index'])->name('quizzes.index');
    Route::post('/quizzes',                   [FacultyQuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}/submissions', [FacultySubmissionController::class, 'index'])->name('quizzes.submissions');

    Route::get('/submissions/{submission}',        [FacultySubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/grade', [FacultySubmissionController::class, 'grade'])->name('submissions.grade');

    Route::get('/gradebook', [FacultyGradebookController::class, 'index'])->name('gradebook');

    Route::get('/students/{student}/grades',   [FacultyGradeController::class, 'show'])->name('students.grades.show');
    Route::patch('/students/{student}/grades', [FacultyGradeController::class, 'update'])->name('students.grades.update');

    // Placeholder routes for sidebar nav (pages to be built)
    Route::get('/calendar', function () {
        if (!session('faculty_id')) return redirect()->route('faculty.login');
        return view('faculty.calendar');
    })->name('calendar');
    Route::get('/announcements',  [FacultyAnnouncementController::class, 'index'])->name('announcements');
    Route::post('/announcements', [FacultyAnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/logs', [FacultyLogController::class, 'index'])->name('logs');
});

// Admin Auth
Route::get('/admin/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login.post');
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
