<?php

use App\Http\Controllers\FakturController;
use App\Http\Controllers\GoodsStocksController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\LaporanController;

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


    //Route for Goods Stocks Proccess
    Route::get('/stok/list-stok-kurang', [GoodsStocksController::class, "getStockLow"])->name('stokKurang.getList');
    Route::get('/stok/list-stok-masuk', [GoodsStocksController::class, "getStockIn"])->name('stokMasuk.getList');
    Route::post('/stok/stok-masuk-simpan', [GoodsStocksController::class, "store"])->name('stokMasuk.store');
    Route::get('/stok/list-barang', [GoodsStocksController::class, "getGoodsStocks"])->name('stok.getList');
    //Route for Goods Stock
    Route::get('/barang/stok-kurang', [GoodsStocksController::class, "indexStockLow"])->name('stokKurang.index');
    Route::get('/barang/stok-masuk', [GoodsStocksController::class, "indexStockIn"])->name('stokMasuk.index');
    Route::get('/barang/daftar-stok', [GoodsStocksController::class, "index"])->name('stok.index');
    //Route for Goods
    //Rute for Goods - Process
    Route::post('/barang/stok-awal-simpan', [GoodsController::class, "firstStock"])->name('barang.fStock');
    Route::put('/barang/{slug}/perbarui-simpan', [GoodsController::class, "update"])->name('barang.update');
    Route::post('/barang/baru-simpan', [GoodsController::class, "store"])->name('barang.store');
    Route::get('/barang/tambah', [GoodsController::class, "create"])->name('barang.create');
    Route::get('/barang/list-barang', [GoodsController::class, "getGoods"])->name('barang.getList');
    //Rute for Goods - Views
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

    Route::get('/faktur', [FakturController::class, "index"])->name('faktur.index');
    Route::get('/faktur/{id}', [FakturController::class, "getOutlet"]);
    Route::get('/fakturJenis/{jenisOutlet}', [FakturController::class, "getJenis"]);
    Route::get('/fakturGoods/{goodsId}', [FakturController::class, "getGoods"]);
    Route::get('/faktur/create', [FakturController::class, "create"]);
    Route::post('/faktur/store', [FakturController::class, "store"])->name('faktur.store');

    //ROute Laporan
    Route::get('/laporan', [LaporanController::class, "index"])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, "index"])->name('laporan.index');

});
