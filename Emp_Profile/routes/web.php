<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

// Home redirects to employee list (or you can show welcome page instead)
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

// Show form to create new employee
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

// Handle form submission
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
