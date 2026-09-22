<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\MyTaskController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Surat Masuk
    Route::resource('incoming-letters', IncomingLetterController::class);

    // Penugasan (Disposisi)
    Route::get('incoming-letters/{letter}/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('incoming-letters/{letter}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');

    // Tugas Saya (Untuk Karyawan/Penerima Tugas)
    Route::get('my-tasks', [MyTaskController::class, 'index'])->name('my-tasks.index');
    Route::get('my-tasks/{assignment}', [MyTaskController::class, 'show'])->name('my-tasks.show');
    Route::post('my-tasks/{assignment}/respond', [MyTaskController::class, 'respond'])->name('my-tasks.respond');

    // Berita & Informasi
    Route::resource('news', \App\Http\Controllers\NewsController::class);

    // Audit Log (Hanya Admin)
    Route::get('audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit-logs.index');

    // Manajemen Pengguna (Hanya Admin)
    Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show']);

    // Manajemen Organisasi (Hanya Admin)
    Route::get('organizations', [\App\Http\Controllers\OrganizationController::class, 'index'])->name('organizations.index');
    Route::post('organizations/department', [\App\Http\Controllers\OrganizationController::class, 'storeDepartment'])->name('organizations.department.store');
    Route::delete('organizations/department/{department}', [\App\Http\Controllers\OrganizationController::class, 'destroyDepartment'])->name('organizations.department.destroy');
    Route::post('organizations/position', [\App\Http\Controllers\OrganizationController::class, 'storePosition'])->name('organizations.position.store');
    Route::delete('organizations/position/{position}', [\App\Http\Controllers\OrganizationController::class, 'destroyPosition'])->name('organizations.position.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
