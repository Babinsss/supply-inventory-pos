<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReportController;

Route::get('/reports/consumption', [ReportController::class, 'index'])->name('reports.consumption');

// 1. Redirect the homepage to the supplies list automatically
Route::redirect('/', '/supplies');

// 2. The Dashboard (List of Supplies) - This fixes your error!
Route::get('/supplies', [SupplyController::class, 'index'])->name('supplies.index');

// 3. The "Add New" Form
Route::get('/supplies/create', [SupplyController::class, 'create'])->name('supplies.create');

// 4. The Action to Save the data
Route::post('/supplies', [SupplyController::class, 'store'])->name('supplies.store');

// Show the Issuance Form
Route::get('/issue', [TransactionController::class, 'create'])->name('issue.create');

// Process the Issuance (Deduct Stock)
Route::post('/issue', [TransactionController::class, 'store'])->name('issue.store');
// The History Log
Route::get('/history', [TransactionController::class, 'index'])->name('transactions.index');
// Public Route (Share this URL with other departments)
Route::get('/request-supply', [RequestController::class, 'create'])->name('requests.create');
Route::post('/request-supply', [RequestController::class, 'store'])->name('requests.store');

// Admin Routes (For you only)
Route::get('/pending-requests', [RequestController::class, 'index'])->name('requests.index');
Route::post('/approve/{id}', [RequestController::class, 'approve'])->name('requests.approve');
Route::post('/decline/{id}', [RequestController::class, 'decline'])->name('requests.decline');
// Route to add stock to an existing item
Route::post('/supplies/{id}/restock', [SupplyController::class, 'restock'])->name('supplies.restock');
// Report Route
Route::get('/reports/consumption', [ReportController::class, 'index'])->name('reports.consumption');