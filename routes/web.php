<?php

use App\Http\Controllers\AdminWorkshopController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserWorkshopController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Where Breeze sends people after login. Sends admins and users to their own home page.
Route::get('/dashboard', function () {
    // change this check to match whatever your AdminMiddleware uses
    return auth()->user()->role === 'admin'
        ? redirect()->route('adminDashboard')
        : redirect()->route('workshops.index');
})->middleware('auth')->name('dashboard');

//USER//
Route::middleware(['auth', 'user'])->group(function () {
    // Browse workshops
    Route::get('workshops', [UserWorkshopController::class, 'index'])->name('workshops.index');
    Route::get('workshops/{workshop}', [UserWorkshopController::class, 'show'])->name('workshops.show');

    // Registration + Midtrans payment
    Route::post('workshops/{workshop}/register', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::get('registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('registrations/{registration}', [RegistrationController::class, 'show'])->name('registrations.show');
    Route::get('registrations/{registration}/pay', [RegistrationController::class, 'pay'])->name('registrations.pay');
    Route::get('registrations/{registration}/check', [RegistrationController::class, 'check'])->name('registrations.check');
    Route::get('registrations/{registration}/ticket', [RegistrationController::class, 'ticket'])->name('registrations.ticket');

    // Profile (Breeze). Delete these three lines if you removed the profile pages.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//ADMIN//
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('adminWorkshop', AdminWorkshopController::class)->except('show');
    Route::get('adminDashboard', [DashboardController::class, 'index'])->name('adminDashboard');
});

require __DIR__.'/auth.php';