<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BpmController;
use App\Http\Controllers\StokMaterialController;
use App\Http\Controllers\BprmController;
use App\Http\Controllers\BomController;
use App\Models\Bprm;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SpmController;


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
Route::middleware('role:admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.index');

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

    Route::get('/spm/create', [SpmController::class, 'create'])->name('spms.create');
    Route::get('/spm', [SpmController::class, 'index'])->name('spm.index');
    Route::post('/spm', [SpmController::class, 'store'])->name('spm.store');
    Route::delete('/spm/{spm}', [SpmController::class, 'destroy'])->name('spm.destroy');
    Route::get('/spm/{spm}', [SpmController::class, 'show'])->name('spm.show');
    Route::get('/spm/{spm}/edit', [SpmController::class, 'edit'])->name('spm.edit');
    Route::put('/spm/{spm}', [SpmController::class, 'update'])->name('spm.update');




    Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
    Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');
    Route::get('/project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');
    

    Route::get('/bom/create', [BomController::class, 'create'])->name('bom.create');
    Route::get('/bom', [BomController::class, 'index'])->name('bom.index');
    Route::post('/bom/store', [BomController::class, 'store'])->name('bom.store'); // Gunakan method POST untuk store
    Route::get('/bom/{bom}', [BomController::class, 'show'])->name('bom.show');
    Route::get('/bom/{bom}/edit', [BomController::class, 'edit'])->name('bom.edit');
    Route::delete('/bom/{bom}', [BomController::class, 'destroy'])->name('bom.destroy');
    Route::put('/bom/{bom}', [BomController::class, 'update'])->name('bom.update');

});

Route::get('/ajax-autocomplete-no-bpm', [BprmController::class, 'searchNoBPM'])->name('searchNoBPM');
Route::get('/ajax-autocomplete-material-code', [BpmController::class, 'searchCodeMaterial'])->name('searchCodeMaterial');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
