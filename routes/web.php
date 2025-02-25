<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskAttachmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(!Auth::check()){
        return view('welcome');
    }
    return redirect()->route('spa');
});

// Nhóm route authentication vẫn hoạt động bình thường
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/spa', function () {
        return view('dashboard'); // Trang Vue gốc
    })->name('spa');

    Route::get('/spa/{any}', function () {
        return view('dashboard'); // Trả về Vue
    })->where('any', '.*');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Call Api
Route::middleware('auth')->group(function(){
    // Users
    Route::resource('users', UserController::class);
    Route::get('/managers', [UserController::class,'getManagers']);
    Route::get('/employees', [UserController::class,'getEmployees']);

    // Projects
    Route::resource('projects', ProjectController::class);
    Route::get('/projects-by-manager-pagination/{id}', [ProjectController::class,'getProjectByManagerPagination']);
    Route::get('/projects-by-manager/{id}', [ProjectController::class,'getProjectByManager']);
    Route::get('/projects-by-employee/{id}', [ProjectController::class,'getProjectByEmployee']);
    
    // Tasks
    Route::resource('/tasks',TaskController::class);
    Route::get('/tasks-by-manager/{id}',[TaskController::class,'getTasksByManager']);
    Route::get('/tasks-by-employee/{id}',[TaskController::class,'getTasksByEmployee']);
    Route::post('/update-task-status/{id}',[TaskController::class,'updateTaskStatus']);
    Route::post('/update-task-priority/{id}',[TaskController::class,'updateTaskPriority']);

    // Task Attachment
    Route::resource('task-attachment', TaskAttachmentController::class);
    Route::get('/task-attachments/{id}',[TaskAttachmentController::class, 'getTaskAttachmentsByTaskId']);
    Route::post('/task-attachments-file-confrim/{id}',[TaskAttachmentController::class, 'fileConfrim']);
});

require __DIR__.'/auth.php';
