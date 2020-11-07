<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\GoodsController;

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
    return view('welcome');
});

Route::group([ "middleware" => ['auth:sanctum', 'verified'] ], function() {
    Route::view('/dashboard', "dashboard")->name('dashboard');

    //Route for Goods
    Route::put('/barang/{slug}/perbarui-simpan', [GoodsController::class, "update"])->name('barang.update');
    Route::post('/barang/baru-simpan', [GoodsController::class, "store"])->name('barang.store');
    Route::get('/barang/tambah', [GoodsController::class, "create"])->name('barang.create');
    Route::get('/barang/list-barang', [GoodsController::class, "getGoods"])->name('barang.getList');
    Route::get('/barang/{slug}/perbarui', [GoodsController::class, "edit"])->name('barang.edit');
    Route::get('/barang/{slug}', [GoodsController::class, "view"])->name('barang.view');
    Route::get('/barang', [GoodsController::class, "index"])->name('barang.index');

    //Route for Outlet
    Route::get('/outlet/{slug}', [OutletController::class, "view"])->name('outlet.view');
    Route::get('/outlet', [OutletController::class, "index"])->name('outlet.index');

    //Route for User
    Route::get('/user', [ UserController::class, "index_view" ])->name('user');
    Route::view('/user/new', "pages.user.user-new")->name('user.new');
    Route::view('/user/edit/{userId}', "pages.user.user-edit")->name('user.edit');
});
