<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/courses', [AdminController::class, 'storeClassRoom'])->name('courses.store');
    Route::delete('/courses/{id}', [AdminController::class, 'destroyClassRoom'])->name('courses.destroy');
    Route::post('/remedial-tasks', [AdminController::class, 'storeRemedialTask'])->name('remedial-tasks.store');
    Route::delete('/remedial-tasks/{id}', [AdminController::class, 'destroyRemedialTask'])->name('remedial-tasks.destroy');
});

// Teacher Routes
Route::middleware(['auth', 'verified', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [TeacherController::class, 'students'])->name('students');
    Route::get('/attendance', [TeacherController::class, 'attendance'])->name('attendance');
    Route::post('/attendance', [TeacherController::class, 'storeAttendance'])->name('attendance.store');
    Route::get('/assessments', [TeacherController::class, 'assessments'])->name('assessments');
    Route::get('/assignments', [TeacherController::class, 'assignments'])->name('assignments');
    Route::get('/analytics', [TeacherController::class, 'analytics'])->name('analytics');
    Route::get('/study-materials', [TeacherController::class, 'studyMaterials'])->name('study-materials');
    Route::get('/settings', [TeacherController::class, 'settings'])->name('settings');
    Route::post('/courses', [TeacherController::class, 'storeClassRoom'])->name('courses.store');
    Route::post('/assignments', [TeacherController::class, 'storeAssignment'])->name('assignments.store');
    Route::post('/submissions/{id}/grade', [TeacherController::class, 'gradeSubmission'])->name('submissions.grade');

    Route::post('/enrollment/{id}/approve', [TeacherController::class, 'approveEnrollment'])->name('enrollment.approve');
    Route::post('/enrollment/{id}/reject', [TeacherController::class, 'rejectEnrollment'])->name('enrollment.reject');
});

// Student Routes
Route::middleware(['auth', 'verified', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
    Route::get('/attendance', [StudentController::class, 'attendance'])->name('attendance');
    Route::get('/assessments', [StudentController::class, 'assessments'])->name('assessments');
    Route::get('/assignments', [StudentController::class, 'assignments'])->name('assignments');
    Route::get('/insights', [StudentController::class, 'insights'])->name('insights');
    Route::get('/remedial-tasks', [StudentController::class, 'remedialTasks'])->name('remedial-tasks');
    Route::get('/reports', [StudentController::class, 'reports'])->name('reports');

    Route::post('/assignments/{id}/submit', [StudentController::class, 'submitAssignment'])->name('assignments.submit');
    Route::post('/enrollment/request', [StudentController::class, 'sendEnrollmentRequest'])->name('enrollment.request');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
