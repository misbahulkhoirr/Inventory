<?php

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

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::redirect('/', 'login');
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin,gudang'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/grafik-api', [App\Http\Controllers\HomeController::class, 'grafik_api'])->name('grafik-api');

        Route::get('/product-in', [App\Http\Controllers\ProductInController::class, 'index'])->name('product-in.index');
        Route::post('/product-in', [App\Http\Controllers\ProductInController::class, 'index'])->name('product-in.search');
        Route::post('/product-in/store', [App\Http\Controllers\ProductInController::class, 'store3'])->name('product-in.store');
        Route::get('/product-out', [App\Http\Controllers\ProductOutController::class, 'index'])->name('product-out.index');
        Route::post('/product-out', [App\Http\Controllers\ProductOutController::class, 'index'])->name('product-out.search');
        Route::post('/product-out/store', [App\Http\Controllers\ProductOutController::class, 'store'])->name('product-out.store');

        Route::get('/product/data', [App\Http\Controllers\ProductInController::class, 'get_api'])->name('product.api');
        Route::get('/product/In/form', [App\Http\Controllers\ProductInController::class, 'create_in'])->name('product-in.create');
        Route::get('/product/Out/form', [App\Http\Controllers\ProductInController::class, 'create_out'])->name('product-out.create');
        Route::post('/product/{type}/form', [App\Http\Controllers\ProductInController::class, 'store'])->name('product.store');
        Route::post('/product/{type}/form2', [App\Http\Controllers\ProductInController::class, 'store2'])->name('product.store2');

        Route::get('/transfer-stok', [App\Http\Controllers\MoveController::class, 'index'])->name('transfer.index');
        Route::post('/transfer-stok', [App\Http\Controllers\MoveController::class, 'index'])->name('transfer.search');
        Route::get('/transfer-stok/create', [App\Http\Controllers\MoveController::class, 'create'])->name('transfer.create');
        Route::post('/transfer-stok/store', [App\Http\Controllers\MoveController::class, 'store'])->name('transfer.store');

        Route::get('/stok-product', [App\Http\Controllers\StokController::class, 'index'])->name('stok.index');
        Route::get('/mutasi-product', [App\Http\Controllers\MutasiController::class, 'index'])->name('mutasi.index');
        Route::post('/mutasi-product', [App\Http\Controllers\MutasiController::class, 'index'])->name('mutasi.search');
        Route::get('/stok-opname', [App\Http\Controllers\OpnameController::class, 'index'])->name('opname.index');
        Route::post('/stok-opname', [App\Http\Controllers\OpnameController::class, 'index'])->name('opname.search');
        Route::get('/stok-opname/create', [App\Http\Controllers\OpnameController::class, 'create'])->name('opname.create');
        Route::post('/stok-opname/create', [App\Http\Controllers\OpnameController::class, 'store'])->name('opname.store');
        Route::get('/stok-opname/{id}/view', [App\Http\Controllers\OpnameController::class, 'show'])->name('opname.view');
        Route::get('/stok-opname/{id}/edit', [App\Http\Controllers\OpnameController::class, 'edit'])->name('opname.edit');
        Route::post('/stok-opname/{id}/api', [App\Http\Controllers\OpnameController::class, 'api'])->name('opname.api');
        Route::post('/stok-opname/{id}/update', [App\Http\Controllers\OpnameController::class, 'update'])->name('opname.update');


        Route::get('/change-password', [App\Http\Controllers\UserController::class, 'changePasswordView'])->name('viewProfile.index');
        Route::post('/changePasswordDB', [App\Http\Controllers\UserController::class, 'changePasswordDB'])->name('changePasswordDB');


        Route::get('/no-trx', [App\Http\Controllers\ProductInController::class, 'no_trx'])->name('no-trx.api');
        Route::get('/petugas/{id}', [App\Http\Controllers\OpnameController::class, 'petugas'])->name('opname.petugas');

        Route::get('/gudang/data', [App\Http\Controllers\GudangController::class, 'get_api'])->name('gudang.api');
        Route::post('/gudang-product', [App\Http\Controllers\OpnameController::class, 'get_product'])->name('product-gudang.api');
        Route::get('/gudang-product2', [App\Http\Controllers\ProductInController::class, 'get_product2'])->name('product-gudang2.api');

        Route::get('/invoice', [App\Http\Controllers\ProductController::class, 'invoice'])->name('invoice');

    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::post('/users-add', [App\Http\Controllers\UserController::class, 'store']);
        Route::post('/users-edit/{user}', [App\Http\Controllers\UserController::class, 'edit']);
        Route::post('/users-update/{user}', [App\Http\Controllers\UserController::class, 'update']);
        Route::post('/users-delete/{user}', [App\Http\Controllers\UserController::class, 'destroy']);

        Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

        Route::get('/supplier', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');


        Route::get('/product-code', [App\Http\Controllers\ProductController::class, 'create']);
        Route::post('/product-add', [App\Http\Controllers\ProductController::class, 'store']);
        Route::post('/product-edit/{id}', [App\Http\Controllers\ProductController::class, 'edit']);
        Route::post('/product-update/{id}', [App\Http\Controllers\ProductController::class, 'update']);
        Route::post('/product-delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy']);


        Route::get('/create-supplier', [App\Http\Controllers\SupplierController::class, 'create'])->name('create-supplier');
        Route::post('/store-supplier', [App\Http\Controllers\SupplierController::class, 'store'])->name('store-supplier');
        Route::get('/edit-supplier/{id}', [App\Http\Controllers\SupplierController::class, 'edit'])->name('edit-supplier');
        Route::put('/update-supplier/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('update-supplier');
        Route::delete('/delete-supplier/{id}', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('delete-supplier');
        // gudang
        Route::get('/gudang', [App\Http\Controllers\GudangController::class, 'index'])->name('gudang.index');
        Route::get('/create-gudang', [App\Http\Controllers\GudangController::class, 'create'])->name('create-gudang');
        Route::post('/store-gudang', [App\Http\Controllers\GudangController::class, 'store'])->name('store-gudang');
        Route::get('/edit-gudang/{id}', [App\Http\Controllers\GudangController::class, 'edit'])->name('edit-gudang');
        Route::put('/update-gudang/{id}', [App\Http\Controllers\GudangController::class, 'update'])->name('update-gudang');
        Route::delete('/delete-gudang/{id}', [App\Http\Controllers\GudangController::class, 'destroy'])->name('delete-gudang');

        Route::get('/storage', [App\Http\Controllers\StorageController::class, 'index'])->name('storage.index');
        Route::post('/storage-add', [App\Http\Controllers\StorageController::class, 'store']);
        Route::post('/storage-edit/{id}', [App\Http\Controllers\StorageController::class, 'edit']);
        Route::post('/storage-update/{id}', [App\Http\Controllers\StorageController::class, 'update']);
        Route::post('/storage-delete/{id}', [App\Http\Controllers\StorageController::class, 'destroy']);


        Route::get('/stok-opname/{id}/reject', [App\Http\Controllers\OpnameController::class, 'reject'])->name('opname.reject');
        Route::post('/stok-opname/{id}/approved', [App\Http\Controllers\OpnameController::class, 'approved'])->name('opname.approved');


        Route::get('/category-product', [App\Http\Controllers\CategoryProductController::class, 'index'])->name('category-product.index');
        Route::post('/category-add', [App\Http\Controllers\CategoryProductController::class, 'store']);
        Route::post('/category-edit/{id}', [App\Http\Controllers\CategoryProductController::class, 'edit']);
        Route::post('/category-update/{id}', [App\Http\Controllers\CategoryProductController::class, 'update']);
        Route::post('/category-delete/{id}', [App\Http\Controllers\CategoryProductController::class, 'destroy']);
   
        Route::get('/satuan', [App\Http\Controllers\SatuanController::class, 'index'])->name('satuan.index');
        Route::post('/satuan-add', [App\Http\Controllers\SatuanController::class, 'store']);
        Route::post('/satuan-edit/{id}', [App\Http\Controllers\SatuanController::class, 'edit']);
        Route::post('/satuan-update/{id}', [App\Http\Controllers\SatuanController::class, 'update']);
        Route::post('/satuan-delete/{id}', [App\Http\Controllers\SatuanController::class, 'destroy']);

    });
});
