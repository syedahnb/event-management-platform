<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FeedbackController;

use App\Http\Controllers\ReportingController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::resource('/events', EventController::class);
    Route::get('/events/{event}/attend', [RegistrationController::class, 'show'])->name('events.attend');
    Route::post('/events/{event}/attend', [RegistrationController::class, 'store'])->name('events.attend');
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');
    Route::post('/events/{event}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::get('/admin/report', [ReportingController::class, 'index'])->name('admin.report');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
