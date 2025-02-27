<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// The logout route is already automatically handled by Auth::routes(), 
// but here’s how you would manually define it if needed:

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); // You can redirect the user to any page after logout
})->name('logout');


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::middleware(['auth']) -> group(function () {
    Route::get('/account-dashboard', [ UserController::class, 'index']) -> name('user.index');
});

Route::middleware(['auth', AuthAdmin::class]) -> group(function () {
    Route::get('/admin', [ AdminController::class, 'index']) -> name('admin.index');
});
