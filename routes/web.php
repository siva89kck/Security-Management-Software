<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformMasterController;
use App\Http\Controllers\UniformPurchaseController;
use App\Http\Controllers\UniformIssueController;
use App\Http\Controllers\UniformStockController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('employees', EmployeeController::class);
// Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
Route::post('employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
Route::delete('employees/{id}/force-delete', [EmployeeController::class, 'forceDelete'])->name('employees.forceDelete');
Route::patch('/employees/{id}/toggle-status', [EmployeeController::class, 'toggleStatus'])
     ->name('employees.toggleStatus');

//Uniform module
Route::prefix('uniforms')->group(function(){
    Route::resource('masters', UniformMasterController::class);
    Route::resource('purchases', UniformPurchaseController::class);
    Route::resource('issues', UniformIssueController::class);
    Route::resource('stocks', UniformStockController::class)->only(['index','show']);
});
Route::patch('/uniforms/{uniform}/toggle-status', [UniformMasterController::class, 'toggleStatus'])
     ->name('uniforms.toggleStatus');


// Auth moule
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
