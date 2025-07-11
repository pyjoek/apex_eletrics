<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/invoice', [ProjectController::class, 'invoice'])->middleware(['auth', 'verified'])->name('invoice');
Route::get('/projects', [ProjectController::class, 'index'])->middleware(['auth', 'verified']);
Route::post('/project', [ProjectController::class, 'store'])->name('new.project');
Route::post('/projects/import', [ProjectController::class, 'import'])->name('projects.import');
Route::get('/projects/export/excel', [ProjectController::class, 'exportExcel'])->name('projects.export.excel');
Route::get('/projects/export/pdf', [ProjectController::class, 'exportPDF'])->name('projects.export.pdf');




require __DIR__.'/auth.php';
