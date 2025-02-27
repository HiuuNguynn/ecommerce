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
    Route::get('/admin/brands', [AdminController::class, 'brands']) ->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class,'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class,'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', action: [AdminController::class,'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update']) ->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete', action: [AdminController::class,'brand_delete'])->name('admin.brand.delete');
    Route::get('/admin/categories',[AdminController::class,'categories'])-> name('admin.categories');
});
