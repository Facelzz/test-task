<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect('employee');
});

Route::get('/home', function () {
    return redirect('employee');
})->name('home');

Route::get('/employee', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.index');

Route::delete('/employee/{id}', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employee.destroy');

Route::get('/employee/create', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('employee.create');

Route::post('/employee/store', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');

Route::get('/employee/{employee}/edit', [\App\Http\Controllers\EmployeeController::class, 'edit'])->name('employee.edit');

Route::put('/employee/{employee}', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('employee.update');

Route::get('/position', [\App\Http\Controllers\PositionController::class, 'index'])->name('position.index');

Route::delete('/position/{id}', [\App\Http\Controllers\PositionController::class, 'destroy'])->name('position.destroy');

Route::get('/position/create', [\App\Http\Controllers\PositionController::class, 'create'])->name('position.create');

Route::post('/position/store', [\App\Http\Controllers\PositionController::class, 'store'])->name('position.store');

Route::get('/position/{position}/edit', [\App\Http\Controllers\PositionController::class, 'edit'])->name('position.edit');

Route::put('/position/{position}', [\App\Http\Controllers\PositionController::class, 'update'])->name('position.update');
