<?php

use App\Http\Controllers\Admin\ClassController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Dashboard
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Facilitator\DashboardController as FacilitatorDashboardController;
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FacilitatorController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\DailyReportController as AdminDailyReportController;
use App\Http\Controllers\Admin\SelfHelpController;
use App\Http\Controllers\Admin\BrainGymController;
use App\Http\Controllers\Admin\StimulationController;
use App\Http\Controllers\Admin\FacilitatorStudentController;

// Facilitator Controller
use App\Http\Controllers\Facilitator\DailyReportController as FacilitatorDailyReportController;

// Parent Controller
use App\Http\Controllers\Parent\DailyReportController as ParentDailyReportController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/test-email', function () {

    Mail::raw('Ini adalah email percobaan dari Asteriia Kinderhaus.', function ($message) {
        $message->to('ariwibowo0702@gmail.com')
            ->subject('Test Email Laravel');
    });

    return 'Email berhasil dikirim.';
});
/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:ADM'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('facilitators', FacilitatorController::class);
        Route::resource('parents', ParentController::class);
        Route::resource('students', StudentController::class);
        Route::resource('school-classes', SchoolClassController::class);
        Route::resource('meals', MealController::class);
        Route::resource('daily-reports', AdminDailyReportController::class);
        Route::resource('class-name', ClassController::class);
        Route::resource('selfhelp', SelfHelpController::class);
        Route::resource('brain-gym', BrainGymController::class);
        Route::resource('stimulation', StimulationController::class);
        Route::get(
            '/facilitator-students',
            [FacilitatorStudentController::class, 'index']
        )->name('facilitator-students.index');

        Route::get(
            '/facilitator-students/create',
            [FacilitatorStudentController::class, 'create']
        )->name('facilitator-students.create');

        Route::post(
            '/facilitator-students',
            [FacilitatorStudentController::class, 'store']
        )->name('facilitator-students.store');

        Route::get(
            '/facilitator-students/{facilitator_id}/{student_id}/edit',
            [FacilitatorStudentController::class, 'edit']
        )->name('facilitator-students.edit');

        Route::put(
            '/facilitator-students/{facilitator_id}/{student_id}',
            [FacilitatorStudentController::class, 'update']
        )->name('facilitator-students.update');

        Route::delete(
            '/facilitator-students/{facilitator_id}/{student_id}',
            [FacilitatorStudentController::class, 'destroy']
        )->name('facilitator-students.destroy');

        Route::patch('/students/{student}/toggle-status', [StudentController::class, 'toggleStatus'])
            ->name('students.toggle-status');
    });

/*
|--------------------------------------------------------------------------
| FACILITATOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:FAS'])
    ->prefix('facilitator')
    ->name('facilitator.')
    ->group(function () {

        Route::get('/dashboard', [FacilitatorDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('daily-reports', FacilitatorDailyReportController::class);

        Route::get('/profile', [FacilitatorDashboardController::class, 'profile'])
            ->name('profile');
    });

/*
|--------------------------------------------------------------------------
| PARENT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:PAR'])
    ->prefix('parent')
    ->name('parent.')
    ->group(function () {

        Route::get('/dashboard', [ParentDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/daily-reports', [ParentDailyReportController::class, 'index'])
            ->name('daily_reports.index');

        Route::get('/daily-reports/{dailyReport}', [ParentDailyReportController::class, 'show'])
            ->name('daily_reports.show');
    });

require __DIR__ . '/auth.php';
