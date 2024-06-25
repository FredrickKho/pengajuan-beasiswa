<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\DekanController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProgramStudiController;
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
Route::middleware('auth')->group(function(){
    Route::get('/',function(){
        return redirect()->route('login');
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::PUT('/activate/{id}',[AdministratorController::class,'activateAccount'])->name('activateAccount');
    Route::middleware('administrator')->group(function(){
        Route::prefix('admin')->group(function(){
            Route::get('/',function(){
                return redirect()->route('listMahasiswa');
            });
            Route::prefix('mahasiswa')->group(function(){
                Route::get('/list', [AdministratorController::class,'listMahasiswa'])->name('listMahasiswa');
                Route::get('/create', [AdministratorController::class,'createMahasiswa'])->name('createMahasiswa');
                Route::get('/edit/{id}', [AdministratorController::class,'editMahasiswa'])->name('editMahasiswa');

                Route::post('/create', [MahasiswaController::class,'create'])->name('createMahasiswa');
                Route::put('/edit/{id}', [MahasiswaController::class,'edit'])->name('editMahasiswa');
                Route::delete('/delete/{id}', [MahasiswaController::class,'delete'])->name('deleteMahasiswa');
            });
            Route::prefix('dekan')->group(function(){
                Route::get('/list', [AdministratorController::class,'listDekan'])->name('listDekan');
                Route::get('/create', [AdministratorController::class,'createDekan'])->name('createDekan');
                Route::get('/edit/{id}', [AdministratorController::class,'editDekan'])->name('editDekan');

                Route::post('/create', [DekanController::class,'create'])->name('createDekan');
                Route::put('/edit/{id}', [DekanController::class,'edit'])->name('editDekan');
                Route::delete('/delete/{id}', [DekanController::class,'delete'])->name('deleteDekan');
            });
            Route::prefix('program-studi')->group(function(){
                Route::get('/list', [AdministratorController::class,'listPStudi'])->name('listPStudi');
                Route::get('/create', [AdministratorController::class,'createPStudi'])->name('createPStudi');
                Route::get('/edit/{id}', [AdministratorController::class,'editPStudi'])->name('editPStudi');

                Route::post('/create', [ProgramStudiController::class,'create'])->name('createPStudi');
                Route::put('/edit/{id}', [ProgramStudiController::class,'edit'])->name('editPStudi');
                Route::delete('/delete/{id}', [ProgramStudiController::class,'delete'])->name('deletePStudi');
            });
            Route::prefix('/fakultas')->group(function(){
                Route::get('/list', [AdministratorController::class,'listFakultas'])->name('listFakultas');

                Route::post('/create', [FakultasController::class,'create'])->name('createFakultas');
                Route::put('/edit/{id}', [FakultasController::class,'edit'])->name('editFakultas');
                Route::delete('/delete/{id}', [FakultasController::class,'delete'])->name('deleteFakultas');
            });
            Route::prefix('/jurusan')->group(function(){
                Route::get('/list', [AdministratorController::class,'listJurusan'])->name('listJurusan');

                Route::post('/create', [JurusanController::class,'create'])->name('createJurusan');
                Route::put('/edit/{id}', [JurusanController::class,'edit'])->name('editJurusan');
                Route::delete('/delete/{id}', [JurusanController::class,'delete'])->name('deleteJurusan');
            });
            Route::prefix('/kategori-beasiswa')->group(function(){
                Route::get('/list', [AdministratorController::class,'listBeasiswa'])->name('listBeasiswa');

                Route::post('/create', [BeasiswaController::class,'create'])->name('createBeasiswa');
                Route::put('/edit/{id}', [BeasiswaController::class,'edit'])->name('editBeasiswa');
                Route::delete('/delete/{id}', [BeasiswaController::class,'delete'])->name('deleteBeasiswa');
            });
            Route::prefix('/pengajuan-beasiswa')->group(function(){
                Route::get('/list', [AdministratorController::class,'listPengajuanBeasiswa'])->name('listPengajuanBeasiswa');

            });
            Route::prefix('/finalisasi')->group(function(){
                Route::get('/list', [AdministratorController::class,'listFinalisasi'])->name('listFinalisasi');

            });
        });
    });
    Route::middleware('mahasiswa')->group(function(){
        Route::prefix('mahasiswa')->group(function(){
            Route::get('/', [MahasiswaController::class,'index'])->name('mahasiswa/home');
            Route::get('/ajuan-beasiswa/{periodId}',[MahasiswaController::class,'beasiswa'])->name('ajuanBeasiswa');
            
            Route::post('/ajuan-beasiswa/{periodId}',[BeasiswaController::class,'createDataBeasiswa'])->name('ajuanBeasiswa');
            Route::put('/ajuan-beasiswa/edit/{type}/{id}',[BeasiswaController::class,'editPengajuanBeasiswa'])->name('editPengajuanBeasiswa');
            Route::delete('/ajuan-beasiswa/delete/{id}',[BeasiswaController::class,'deleteBeasiswa'])->name('deleteBeasiswa');
        });
    });
    Route::middleware('dekan')->group(function(){
        Route::prefix('dekan')->group(function(){
            Route::get('/', [DekanController::class,'index'])->name('dekan/home');
            Route::get('/review', [DekanController::class,'reviewPage'])->name('dekan/review');
            Route::get('/finalisasi', [DekanController::class,'finalizePage'])->name('dekan/finalisasi');

            Route::put('/review/{beasiswaId}', [DekanController::class,'reviewBeasiswa'])->name('dekanReviewBeasiswa');
            Route::put('/review/finalize/{beasiswaId}', [DekanController::class,'finalize'])->name('finalize');
        });
        Route::prefix('period')->group(function(){
            Route::get('/list', [DekanController::class,'listPeriod'])->name('listPeriod');
            Route::get('/create', [DekanController::class,'createPeriod'])->name('createPeriod');
            Route::get('/edit/{id}', [DekanController::class,'editPeriod'])->name('editPeriod');

            Route::post('/create', [PeriodController::class,'create'])->name('createPeriod');
            Route::put('/edit/{id}', [PeriodController::class,'edit'])->name('editPeriod');
            Route::delete('/delete/{id}', [PeriodController::class,'delete'])->name('deletePeriod');
        });
    });
    Route::middleware('program_studi')->group(function(){
        Route::prefix('program-studi')->group(function(){
            Route::get('/', [ProgramStudiController::class,'index'])->name('program-studi/home');
            Route::get('/review', [ProgramStudiController::class,'reviewPage'])->name('program-studi/review');
            Route::get('/finalisasi', [ProgramStudiController::class,'finalizePage'])->name('program-studi/finalisasi');

            Route::put('/review/{beasiswaId}', [ProgramStudiController::class,'reviewBeasiswa'])->name('programStudiReviewBeasiswa');

        });
    });
});

Route::middleware("guest")->group(function(){
    Route::get('/login', [AuthController::class,'login'])->name('login');
    Route::post('/login',[AuthController::class,'auth'])->name('login');
});
