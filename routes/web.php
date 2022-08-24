<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\SiteController;
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

Route::get('/', [SiteController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');
    Route::get('/balance/deposito', [BalanceController::class, 'deposito'])->name('balance.deposito');
    Route::get('/withdraw', [BalanceController::class, 'withdraw'])->name('balance.withdraw');
    Route::get('/transfer', [BalanceController::class, 'transfer'])->name('balance.transfer');
    Route::get('/historic', [BalanceController::class, 'historic'])->name('admin.historic');
   

    Route::post('/deposito', [BalanceController::class, 'depositoStore'])->name('deposito.store');
    Route::post('/withdraw', [BalanceController::class, 'withdrawStore'])->name('balance.withdrawStore');
    Route::post('/confirm-transfer', [BalanceController::class, 'confirmTransfer'])->name('confirm.transfer');
    Route::post('/transfer', [BalanceController::class, 'transferStore'])->name('transfer.store');


});


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
