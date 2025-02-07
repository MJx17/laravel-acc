<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pdf\PdfController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\Auth\RegisteredProfessorUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseSubjectController;
use App\Http\Controllers\StudentSubjectController;




// Home Route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::middleware('auth', 'verified','role:admin')->group(function () {
    // Route to display the form
    Route::get('/admin/register-professor', [RegisteredProfessorUserController::class, 'create'])
    ->name('register_professor');

// Handle professor registration form submission
Route::post('/admin/register-professor', [RegisteredProfessorUserController::class, 'store']);
    
});



Route::middleware('auth', 'verified','role:student', )->group(function () {
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student-info', [StudentController::class, 'indexStudent'])->name('student.indexStudent');
    // Route::get('/enrollment/blank-form/download', [StudentController::class, 'downloadBlankForm'])
    //     ->name('enrollment.downloadBlankForm');
    // Route to download the filled enrollment form (PDF)
    Route::get('/enrollment/filled-form/download/{id}', [StudentController::class, 'downloadFilledForm'])
        ->name('enrollment.downloadFilledForm');
   
});




Route::middleware('auth', 'verified','role:admin')->group(function () {
    Route::get('/student-list', [StudentController::class, 'indexAdmin'])->name('student.indexAdmin');
  
        Route::get('/users-list', [UserController::class, 'index'])->name('users.index');
            // Edit student data
    Route::get('student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    
    // Update student data
    Route::put('student/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/view/{id}', [StudentController::class, 'show'])->name('student.show');
    
    // Delete student data
    Route::delete('student/{id}', [StudentController::class, 'destroy'])->name('student.destroy');

});

// Roles
Route::middleware('auth', 'verified','role:admin')->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});


// Permissions
Route::middleware(['auth','verified','role:admin'])->group(function () {
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'Edit'])->name('permissions.edit');
    Route::patch('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () { 
    Route::resource('departments', DepartmentController::class)->parameters([
        'departments' => 'department_id',
    ]);
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('courses', CourseController::class)->parameters([
        'courses' => 'course_id',
    ]);
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('professors', ProfessorController::class)->parameters([
        'professor' => 'professor_id',
    ]);

    Route::get('professors/{professor_id}/subjects', [ProfessorController::class, 'subjects'])
         ->name('professors.subjects');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('subjects', SubjectController::class)->parameters([
        'subjects' => 'id', // Use 'id' instead of 'subjects_id'
    ]);
    
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('enrollments', EnrollmentController::class);
});


Route::get('/get-subjects', [EnrollmentController::class, 'getSubjects'])->name('get.subjects');



Route::get('students/{studentId}/subjects', [StudentSubjectController::class, 'show'])
->name('student_subject.subjects');  

Route::get('/student-subjects/{studentId}/edit', [StudentSubjectController::class, 'edit'])->name('student_subjects.edit');

// Route to handle the update request
Route::put('/student-subjects/{studentId}/update', [StudentSubjectController::class, 'update'])->name('student_subjects.update');








// Auth Routes (Generated by Laravel Breeze or Jetstream)
require __DIR__ . '/auth.php';
