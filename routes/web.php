<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BpmController;
use App\Http\Controllers\stokMaterialController;
use App\Http\Controllers\BprmController;
use App\Http\Controllers\bomController;
use App\Models\Bprm;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SpmController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanBprmController;
use App\Http\Controllers\BagianController;


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


// Authentication routes
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.index');

        Route::get('/clear-log', [HomeController::class, 'clearLog'])->name('clearLog');

       Route::controller(LaporanBprmController::class)->group(function () {
    Route::get('/laporan-bagian', 'laporanBagian')->name('laporan.laporan-bagian');
    Route::get('/laporan-tanggal', 'laporanTanggal')->name('laporan.laporan-tanggal');
    Route::get('/laporan-project', 'laporanProject')->name('laporan.laporan-project');
    Route::get('/laporan-material', 'laporanMaterial')->name('laporan.laporan-material');
    Route::get('/laporan/filter', 'filterLaporanTanggal')->name('laporan.filter');
    Route::get('/laporan/filterProject', 'filterLaporanProject')->name('laporan.filterProject');
    Route::get('/laporan/filterBagian', 'filterLaporanBagian')->name('laporan.filterBagian');
    Route::get('/laporan/filterMaterial', 'filterLaporanMaterial')->name('laporan.filterMaterial');
});
        

        Route::resource('bprm', BprmController::class);


        Route::resource('bpm', BpmController::class);
        Route::get('/bpm/{bpm}/diterima', [BpmController::class, 'diterima'])->name('bpm.diterima');


        Route::resource('project', ProjectController::class);


        Route::resource('bom', BomController::class);

         Route::resource('bagian', BagianController::class);



       Route::resource('material', BomController::class)->only(['edit', 'update', 'destroy']);

    });

    Route::middleware('role:admin|user')->group(function () {
        Route::get('/stok_material/fabrikasi', [stokMaterialController::class, 'indexFabrikasi'])->name('stok_material_fabrikasi.index');
         Route::post('/stok_material/fabrikasi', [stokMaterialController::class, 'indexFabrikasi'])->name('stok_material.fabrikasi.index');
        Route::get('/stok_material/finishing', [stokMaterialController::class, 'indexFinishing'])->name('stok_material_finishing.index');
        Route::post('/stok_material', [stokMaterialController::class, 'store'])->name('stok_material.store');
        Route::get('/stok_material/create', [stokMaterialController::class, 'create'])->name('stok_material.create');
        Route::delete('/stok_material/{stok_material}', [stokMaterialController::class, 'destroy'])->name('stok_material.destroy');
        Route::get('/stok_material/{stok_material}', [stokMaterialController::class, 'show'])->name('stok_material.show');
        Route::get('/stok_material/{stok_material}/edit', [stokMaterialController::class, 'edit'])->name('stok_material.edit');
        Route::put('/stok_material/{stok_material}', [stokMaterialController::class, 'update'])->name('stok_material.update');
        Route::get('/stok_material_proyek/{kode_material}', [stokMaterialController::class, 'stokProyek'])->name('stok_material.stok_proyek');

        Route::get('/logs', [HomeController::class, 'log'])->name('logs');
        Route::get('/trash', [HomeController::class, 'trash'])->name('trash');
        Route::get('/trash/restore/{jenis}/{id}', [HomeController::class, 'restore_data'])->name('restore-data');
        Route::delete('/trash/force-delete/{jenis}/{id}', [HomeController::class, 'force_delete'])->name('force-delete');

        // Resource Route untuk SPM (Standar CRUD)
Route::resource('spm', SpmController::class)->except(['show']);

// Khusus untuk show dengan tambahan parameter id_notif
Route::get('/spm/{spm}/{id_notif}', [SpmController::class, 'show'])->name('spm.show');


        Route::post('/stok_material/filterStatus', [stokMaterialController::class, 'filterStatus'])->name('filterStatus');
        Route::post('/stok_material/filterLokasi', [stokMaterialController::class, 'filterLokasi'])->name('filterLokasi');

        Route::get('/ajax-autocomplete-no-bpm', [BprmController::class, 'searchNoBPM'])->name('searchNoBPM');
        Route::get('/ajax-autocomplete-material-code-bprm', [BprmController::class, 'searchCodeMaterial'])->name('searchCodeMaterialBprm');
        Route::get('/ajax-autocomplete-material-code-bpm', [BpmController::class, 'searchCodeMaterial'])->name('searchCodeMaterialBpm');
        Route::get('/ajax-autocomplete-material-code-spm', [SpmController::class, 'searchCodeMaterial'])->name('searchCodeMaterialSpm');

        Route::get('/ajax-autocomplete-no-spm', [BpmController::class, 'searchNoSPM'])->name('searchNoSPM');

        Route::get('/notifications/unread', [NotificationController::class, 'unread']);
        Route::put('/notifications/mark-as-read/{id}', 'NotificationController@markAsRead');
    });
});

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

