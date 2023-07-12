<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Applicant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/applicants', function () {
    return view('admin.applicants');
})->middleware(['auth', 'verified'])->name('applicants');

Route::get('/programs', function () {
    return view('admin.programs');
})->middleware(['auth', 'verified'])->name('programs');

Route::get('/conformation-of-enrollment-form', function () {
    return view('admin.enrollment-form');
})->middleware(['auth', 'verified'])->name('enrollment-form');

Route::get('/upload', function () {
    return view('admin.upload');
})->middleware(['auth', 'verified'])->name('upload');

Route::get('/applicant/pre-registration/{record}', function ($record) {
    $applicant = Applicant::findOrFail($record);

    return view('applicant.pre-registration-create', ['record' => $applicant]);
})->name('applicant.pre-registration');

Route::get('/applicant/pre-registration/success/{record}', function ($record) {
    $applicant = Applicant::findOrFail($record);

    return view('applicant.pre-registration-success', ['record' => $applicant]);
})->name('applicant.pre-registration-success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
