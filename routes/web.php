<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/profiles', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/project', [ProjectController::class, 'store'])->name('new.project');
    Route::get('/projects', [ProjectController::class, 'index'])->middleware(['auth', 'verified']);
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('work');
    Route::post('/projects/import', [ProjectController::class, 'import'])->name('projects.import');
    Route::get('/projects/export/excel', [ProjectController::class, 'exportExcel'])->name('projects.export.excel');
    Route::get('/projects/export/pdf', [ProjectController::class, 'exportPDF'])->name('projects.export.pdf');
    
    Route::get('/invoice', [InvoiceController::class, 'index']);
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('new.invoice');
    Route::post('/invoices/import', [InvoiceController::class, 'import'])->name('invoices.import');
    Route::get('/old/{id}', [ProjectController::class, 'oldInvoice']);
    Route::get('/invoices/export/excel/{id}', [InvoiceController::class, 'exportExcel'])->name('invoices.export.excel');
    Route::get('/invoices/export/pdf/{id}', [InvoiceController::class, 'exportPDF'])->name('invoices.export.pdf');
    Route::get('/profoma/export/pdf/{id}', [InvoiceController::class, 'profomaPDF'])->name('profoma.export.pdf');
    Route::get('/delivery/export/pdf/{id}', [InvoiceController::class, 'delivery'])->name('delivery.export.pdf');
    
    Route::get('/expense', [ExpenseController::class, 'index']);
    Route::post('/expense', [ExpenseController::class, 'store'])->name('new.expense');
    Route::get('/expense/{id}', [ExpenseController::class, 'show'])->name('expense');

    Route::post('/customer', [CustomerCOntroller::class, 'store'])->name('new.customer');
    Route::post('/suplier', [SupplierCOntroller::class, 'store'])->name('new.supplier');

    Route::get('/purchase', [PurchaseController::class, 'index']);
    Route::get('/purchases', [PurchaseController::class, 'show'])->name('show.purchase');
    Route::get('/purchases/{id}', [PurchaseController::class, 'all'])->name('purchase');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('new.purchase');
    Route::get('/purchase/export/excel/{id}', [PurchaseController::class, 'exportExcel'])->name('purchase.export.excel');
    Route::get('/purchase/export/pdf/{id}', [PurchaseController::class, 'exportPDF'])->name('purchase.export.pdf');
});

require __DIR__.'/auth.php';
