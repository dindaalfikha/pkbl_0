<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix' => '/admin', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/master-csv-data', [AdminController::class, 'MasterCsvData'])->name('admin.master.csv.data');
    Route::post('/add-master-csv', [App\Http\Controllers\AdminController::class, 'AddMasterCsvProcess'])->name('add.master.csv.process');

    Route::get('/master-csv-table', [AdminController::class, 'MasterCsvTable'])->name('admin.master.csv.table');
    Route::get('/add-table', [AdminController::class, 'AddTable'])->name('admin.add.table');
    Route::post('/add-table', [App\Http\Controllers\AdminController::class, 'AddTableProcess'])->name('admin.add.table.process');
    Route::get('/edit-table/{id}', [App\Http\Controllers\AdminController::class, 'EditTable'])->name('admin.edit.table');
    Route::post('/edit-table/', [App\Http\Controllers\AdminController::class, 'EditTableProcess'])->name('admin.edit.table.process');
    Route::get('/data-sync', [App\Http\Controllers\AdminController::class, 'DataSync'])->name('admin.data.sync');

    Route::get('/master-unit', [App\Http\Controllers\AdminController::class, 'MasterUnit'])->name('admin.master.unit');
    Route::post('/add-unit', [App\Http\Controllers\AdminController::class, 'AddUnit'])->name('admin.add.unit');

    Route::get('/measure-data/{id}', [App\Http\Controllers\AdminController::class, 'MeasureData'])->name('admin.measure.data');
});

Route::get('/home', function() {
    return redirect()->route('admin.dashboard');
})->name('home');

