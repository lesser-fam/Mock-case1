<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;

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
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(function () {

    Route::prefix('sell')->group(function () {
        Route::get('/', [ItemController::class, 'create'])->name('items.create');
        Route::post('/', [ItemController::class, 'store'])->name('items.store');
    });

    Route::prefix('purchase')->group(function () {
        Route::get('/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
        Route::post('/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');
        Route::get('/address/{item_id}', [PurchaseController::class, 'editaddress'])->name('purchase.address.edit');
        Route::put('/address/{item_id}', [PurchaseController::class, 'updateaddress'])->name('purchase.address.update');
    });

    Route::prefix('mypage')->group(function () {
        Route::get('/', [MypageController::class, 'mypage'])->name('mypage.index');
        Route::get('/profile', [MypageController::class, 'editprofile'])->name('mypage.profile.edit');
        Route::put('/profile', [MypageController::class, 'updateprofile'])->name('mypage.profile.update');
    });

});