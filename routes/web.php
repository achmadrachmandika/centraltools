<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BpmController;
use App\Http\Controllers\StokMaterialController;
use App\Http\Controllers\BprmController;
use App\Http\Controllers\bomController;
use App\Models\Bprm;

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
    return redirect('/login');
});
Route::get('/login', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    return view('admin.index');
});

Route::get('/stok_material', [stokMaterialController::class, 'index'])->name('stok_material.index');
Route::post('/stok_material', [stokMaterialController::class, 'store'])->name('stok_material.store');
Route::get('/stok_material/create', [stokMaterialController::class, 'create'])->name('stok_material.create');
Route::delete('/stok_material/{stok_material}', [stokMaterialController::class, 'destroy'])->name('stok_material.destroy');
Route::get('/stok_material/{stok_material}', [stokMaterialController::class, 'show'])->name('stok_material.show');
Route::get('/stok_material/{stok_material}/edit', [stokMaterialController::class, 'edit'])->name('stok_material.edit');
Route::put('/stok_material/{stok_material}', [stokMaterialController::class, 'update'])->name('stok_material.update');

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


Route::get('/bom', [bomController::class, 'index'])->name('bom.index');
Route::get('/bom/create', [bomController::class, 'create'])->name('bom.create');


Route::get('/ajax-autocomplete-no-bpm', [BprmController::class, 'searchNoBPM'])->name('searchNoBPM');
Route::get('/ajax-autocomplete-material-code', [BpmController::class, 'searchCodeMaterial'])->name('searchCodeMaterial');















