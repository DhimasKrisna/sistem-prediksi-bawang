<?php

use App\Http\Controllers\ArtikelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SvrController;
use App\Http\Controllers\TmpHargaController;
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

Route::get('/', function () {return view('welcome');});
//
Route::group(['middleware' => 'auth'], function(){
    Route::get('/user', [UserController::class, 'index'])->name('user.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/harga', [HargaController::class, 'index'])->name('harga.index');
    Route::get('/hargaChart', [HargaController::class, 'chart'])->name('harga.chart');

    Route::get('/tmpharga', [TmpHargaController::class, 'index'])->name('tmpharga.index');

    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/{artikel}', [ArtikelController::class, 'baca'])->name('artikel.baca');

    Route::get('/svr', [SvrController::class, 'index'])->name('svr.index');

    Route::get('/login/gantiPassword', [AuthController::class, 'gantiPassword'])->name('login.gantiPass');
    Route::post('/login/gantiPassword', [AuthController::class, 'gantiPasswordAct'])->name('login.gantiPassAct');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('login.logout');
    
    Route::group(['middleware' => 'isAdmin'], function(){
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('/user/{user}/edit', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}/delete', [UserController::class, 'delete'])->name('user.delete');

        Route::get('/harga/create', [HargaController::class, 'create'])->name('harga.create');
        Route::post('/harga/create', [HargaController::class, 'store'])->name('harga.store');
        Route::get('/harga/{harga}/edit', [HargaController::class, 'edit'])->name('harga.edit');
        Route::patch('/harga/{harga}/edit', [HargaController::class, 'update'])->name('harga.update');
        Route::delete('/harga/{harga}/delete', [HargaController::class, 'delete'])->name('harga.delete');

        Route::get('/tmpharga/crawl', [TmphargaController::class, 'crawl'])->name('tmpharga.crawl');
        Route::post('/tmpharga/crawl', [TmphargaController::class, 'storeCrawl'])->name('tmpharga.storeCrawl');

        Route::get('/tmpharga/create', [TmphargaController::class, 'create'])->name('tmpharga.create');
        Route::post('/tmpharga/create', [TmphargaController::class, 'store'])->name('tmpharga.store');
        Route::get('/tmpharga/{tmpharga}/edit', [TmphargaController::class, 'edit'])->name('tmpharga.edit');
        Route::patch('/tmpharga/{tmpharga}/edit', [TmphargaController::class, 'update'])->name('tmpharga.update');
        Route::delete('/tmpharga/{tmpharga}/delete', [TmphargaController::class, 'delete'])->name('tmpharga.delete');
       

        Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
        Route::post('/artikel/create', [ArtikelController::class, 'store'])->name('artikel.store');
        Route::get('/artikel/{artikel}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
        Route::patch('/artikel/{artikel}/edit', [ArtikelController::class, 'update'])->name('artikel.update');
        Route::delete('/artikel/{artikel}/delete', [ArtikelController::class, 'delete'])->name('artikel.delete');
    });
});

Route::group(['middleware' => 'guest'], function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login.index');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
});

