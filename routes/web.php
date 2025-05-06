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
use App\Http\Controllers\ProjectMaterialLoanController;
use App\Http\Controllers\StaffController;


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
    Route::middleware('role:admin|staff')->group(function () {
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
         Route::get('/bprm-data', [BprmController::class, 'getDataBprm'])->name('bprm.data');


        Route::resource('bpm', BpmController::class);
        Route::get('/bpm-data', [BpmController::class, 'getDataBpm'])->name('bpm.data');
        Route::get('/bpm/{bpm}/diterima', [BpmController::class, 'diterima'])->name('bpm.diterima');



        Route::resource('project', ProjectController::class);
         Route::get('/project-data', [ProjectController::class, 'getData'])->name('project.data');


        Route::resource('bom', BomController::class);

         Route::resource('bagian', BagianController::class);
         Route::get('/bagian-data', [BagianController::class, 'getData'])->name('bagian.data');




       Route::resource('material', BomController::class)->only(['edit', 'update', 'destroy']);

       Route::get('/loans', [ProjectMaterialLoanController::class, 'index'])->name('loans.index');
Route::get('/loans/create', [ProjectMaterialLoanController::class, 'create'])->name('loans.create');
Route::post('/loans', [ProjectMaterialLoanController::class, 'store'])->name('loans.store');
Route::post('/loans/{id}/return', [ProjectMaterialLoanController::class, 'returnLoan'])->name('loans.return');
Route::get('/loans-data', [ProjectMaterialLoanController::class, 'getDataLoans'])->name('loans.data');
Route::get('/loans-material/data', [ProjectMaterialLoanController::class, 'getDataLoansMaterial'])->name('loans.material.data');
Route::get('/materials/by-project/{projectPemilikId}', [ProjectMaterialLoanController::class, 'getByProject']);



// Untuk ajax material berdasarkan proyek pemilik
// Route::get('/materials/by-project/{projectId}', [ProjectMaterialLoanController::class, 'getMaterials']);

    });

    Route::middleware('role:admin|user|staff')->group(function () {
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
        Route::get('/stok_material-fabrikasi-data', [stokMaterialController::class, 'getDataFabrikasi'])->name('stok_material-fabrikasi.data');

         Route::get('/stok_material-finishing-data', [stokMaterialController::class, 'getDataFinishing'])->name('stok_material-finishing.data');

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

        // Route::get('/notifications/unread', [NotificationController::class, 'unread']);
        // Route::put('/notifications/mark-as-read/{id}', 'NotificationController@markAsRead');
    });
});

Route::middleware('role:admin')->group(function () {
    // Hanya admin yang bisa menambah staff
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/index', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');


});
// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

