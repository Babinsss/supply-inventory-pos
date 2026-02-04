<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirect the homepage to Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. DASHBOARD (Redirects to your supplies list)
Route::get('/dashboard', function () {
    return redirect()->route('supplies.index');
})->middleware(['auth', 'verified'])->name('dashboard');


// 3. PROTECTED ROUTES (Only logged-in users can see this)
Route::middleware('auth')->group(function () {

    // --- USER MANAGEMENT ---
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // --- INVENTORY SUPPLIES ---
    Route::get('/supplies', [SupplyController::class, 'index'])->name('supplies.index');
    Route::get('/supplies/create', [SupplyController::class, 'create'])->name('supplies.create');
    Route::post('/supplies', [SupplyController::class, 'store'])->name('supplies.store');
    Route::post('/supplies/{id}/restock', [SupplyController::class, 'restock'])->name('supplies.restock');

    // --- ISSUANCE & TRANSACTIONS ---
    Route::get('/issue', [TransactionController::class, 'create'])->name('issue.create');
    Route::post('/issue', [TransactionController::class, 'store'])->name('issue.store');
    Route::get('/history', [TransactionController::class, 'index'])->name('transactions.index');

    // --- REQUEST SYSTEM (Admin View) ---
    Route::get('/pending-requests', [RequestController::class, 'index'])->name('requests.index');
    Route::post('/approve/{id}', [RequestController::class, 'approve'])->name('requests.approve');
    Route::post('/decline/{id}', [RequestController::class, 'decline'])->name('requests.decline');

    // --- REPORTS ---
    Route::get('/reports/consumption', [ReportController::class, 'index'])->name('reports.consumption');

    // --- PROFILE (Standard Breeze Routes) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. PUBLIC ROUTES (For Departments to request items without login)
Route::get('/request-supply', [RequestController::class, 'create'])->name('requests.create');
Route::post('/request-supply', [RequestController::class, 'store'])->name('requests.store');

// 5. LOAD AUTHENTICATION ROUTES (Login, Register, Logout)
require __DIR__.'/auth.php';