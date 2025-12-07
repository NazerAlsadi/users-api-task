<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserWebController;

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

// LOGIN PAGE
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// LOGIN SUBMIT
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// REGISTER PAGE
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// REGISTER SUBMIT
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// DASHBOARD (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/users', [UserWebController::class, 'index']) 
        ->name('admin.users');

    Route::delete('/admin/users/{id}', [UserWebController::class, 'destroy'])
        ->name('admin.users.delete');

    
    Route::get('/admin/users/{user}/edit', [UserWebController::class, 'edit'])
    ->name('admin.users.edit'); 
         // صفحة تعديل المستخدم
    Route::put('/admin/users/{user}', [UserWebController::class, 'update'])
    ->name('admin.users.update');      // تحديث المستخدم


});
