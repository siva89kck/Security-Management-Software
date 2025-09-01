<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('employees', EmployeeController::class);
// Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');


Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
Route::post('employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
Route::delete('employees/{id}/force-delete', [EmployeeController::class, 'forceDelete'])->name('employees.forceDelete');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
