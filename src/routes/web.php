<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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


Route::get('/email/verify', function () {
    return view('auth.verify');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function ($id,  $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
        abort(403);
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    Auth::login($user);

    session()->forget('verify_user_id');
    
    session(['first_profile' => true]);

    return redirect()->route('mypage.profile.edit');
})->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

Route::post('email/resend', function () {
    $userId = session('verify_user_id');

    if (! $userId) {
        abort(403);
    }

    $user = User::findOrFail($userId);

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login');
    }

    $user->sendEmailVerificationNotification();

    return back()->with('resent', true);
})->name('verification.resend');


Route::middleware('auth', 'verified')->group(function () {

    Route::prefix('item')->group(function () {
        Route::post('/{item_id}/favorite', [ItemController::class, 'favorite'])->name('items.favorite');
        Route::post('/{item_id}/comment', [ItemController::class, 'comment'])->name('items.comment');
    });

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
        Route::get('/', [MypageController::class, 'index'])->name('mypage.index');
        Route::get('/profile', [MypageController::class, 'editprofile'])->name('mypage.profile.edit');
        Route::put('/profile', [MypageController::class, 'updateprofile'])->name('mypage.profile.update');
    });

});