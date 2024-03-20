<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BpmController;
use App\Http\Controllers\KodeMaterialController;
use App\Http\Controllers\BprmController;
use App\Http\Controllers\DetailbpmController;


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

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/dashboard', function () {
    return view('admin.index');
});

Route::get('/kode_material', [KodeMaterialController::class, 'index'])->name('kode_material.index');
Route::post('/kode_material', [KodeMaterialController::class, 'store'])->name('kode_material.store');
Route::get('/kode_material/create', [KodeMaterialController::class, 'create'])->name('kode_material.create');
Route::delete('/kode_material/{kode_material}', [KodeMaterialController::class, 'destroy'])->name('kode_material.destroy');
Route::get('/kode_material/{kode_material}', [KodeMaterialController::class, 'show'])->name('kode_material.show');
Route::get('/kode_material/{kode_material}/edit', [KodeMaterialController::class, 'edit'])->name('kode_material.edit');
Route::put('/kode_material/{kode_material}', [KodeMaterialController::class, 'update'])->name('kode_material.update');

Route::get('/bprm/create', [BprmController::class, 'create'])->name('bprms.create');
Route::get('/bprm', [BprmController::class, 'index'])->name('bprm.index');
Route::post('/bprm', [BprmController::class, 'store'])->name('bprm.store');
Route::delete('/bprm/{bprm}', [BprmController::class, 'destroy'])->name('bprm.destroy');
Route::get('/bprm/{bprm}', [BprmController::class, 'show'])->name('bprm.show');
Route::get('/bprm/{bprm}/edit', [BprmController::class, 'edit'])->name('bprm.edit');
Route::put('/bprm/{bprm}', [BprmController::class, 'update'])->name('bprm.update');

Route::get('/bpm/create', [BpmController::class, 'create'])->name('bpms.create');
Route::get('/bpm', [BpmController::class, 'index'])->name('bpm.index');
Route::post('/bpm', [BpmController::class, 'store'])->name('bpm.store');
Route::delete('/bpm/{bpm}', [BpmController::class, 'destroy'])->name('bpm.destroy');
Route::get('/bpm/{bpm}', [BpmController::class, 'show'])->name('bpm.show');
Route::get('/bpm/{bpm}/edit', [BpmController::class, 'edit'])->name('bpm.edit');
Route::put('/bpm/{bpm}', [BpmController::class, 'update'])->name('bpm.update');


Route::get('detail/detail_bpm', [DetailbpmController::class, 'index'])->name('detail.detail_bpm');















