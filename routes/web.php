<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::controller(HomeController::class)->group(function() {
    Route::get('/home', 'index')->name('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('login', [UserController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    /**
     * User profile routes
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Post routes
     */
    Route::resource('posts', PostController::class);

    /**
     * Category routes
     */
    Route::resource('category', CategoryController::class);

    /**
     * User routes
     */
    Route::resource('users', UserController::class);

    /**
     * Setting routes
     */
    Route::resource('settings', SettingController::class);

});

require __DIR__.'/auth.php';
