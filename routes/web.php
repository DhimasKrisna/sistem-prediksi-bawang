<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\AuthController;
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
    Route::get('/harga', [HargaController::class, 'index'])->name('harga.index');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('login.logout');
    
    Route::group(['middleware' => 'isAdmin'], function(){
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user/create', [UserController::class, 'store'])->name('user.store');
        Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('user/{user}/edit', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/{user}/delete', [UserController::class, 'delete'])->name('user.delete');

        Route::get('/harga/create', [HargaController::class, 'create'])->name('harga.create');
        Route::post('/harga/create', [HargaController::class, 'store'])->name('harga.store');
        Route::get('harga/{harga}/edit', [HargaController::class, 'edit'])->name('harga.edit');
        Route::patch('harga/{harga}/edit', [HargaController::class, 'update'])->name('harga.update');
        Route::delete('harga/{harga}/delete', [HargaController::class, 'delete'])->name('harga.delete');
    });
});

Route::group(['middleware' => 'guest'], function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login.index');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
});

