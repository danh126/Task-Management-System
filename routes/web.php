<?php

use App\Http\Controllers\ProfileController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Call Api
Route::middleware('auth')->group(function(){
    Route::resource('users',UserController::class);
});

require __DIR__.'/auth.php';
