<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuctionController::class, 'show'])->name('mainpage');

Route::post('/auction/{id}/move-to-end', [AuctionController::class, 'moveToEnd']);
Route::get('/auction/{id}/show', [AuctionController::class, 'show'])->name('auction.show');
Route::post('/auction/{id}/bid', [AuctionController::class, 'placeBid'])->middleware('auth')->name('auction.bid');


Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');

    Route::get('/auth/register', 'register')->name('register');
    Route::post('/auth/register', 'authenticateRegister')->name('register.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update-avatar');

    Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
    Route::get('/user/{id}/auctions', [AuctionController::class, 'userAuctions'])->name('profile.auctions');
    Route::delete('/auctions/{id}', [AuctionController::class, 'delete'])->name('profile.auction-delete');
    Route::get('/auctions/{id}/edit', [AuctionController::class, 'edit'])->name('profile.auction-edit');
    Route::get('/user/{id}/cars', [AuctionController::class, 'userCars'])->name('profile.cars');
});

Route::middleware(['auth', CheckRole::class . ':1'])->group(function () {
    Route::delete('/auction/{id}', [AuctionController::class, 'delete_on_mainpage'])->name('auction.delete-auction');
    Route::get('/administrator/auctions', [AuctionController::class, 'administrator_show_auctions'])->name('administrator.auctions');
    Route::delete('/administrator/auctions/{id}/delete', [AuctionController::class, 'administrator_delete_auctions'])->name('administrator_delete_auctions');
    Route::get('/administrator/users', [ProfileController::class, 'users'])->name('administrator.users');
    Route::get('/administrator/users/{id}/edit', [ProfileController::class, 'editUser'])->name('edit_user');
    Route::put('/administrator/users/{id}', [ProfileController::class, 'updateUser'])->name('update_user');
    Route::delete('/administrator/users/{id}', [ProfileController::class, 'deleteUser'])->name('delete_user');
    Route::post('/auction/{id}/end', [AuctionController::class, 'endAuction'])->name('auction.end');
    Route::get('/administrator/stats', [AuctionController::class, 'stats'])->name('administrator.stats');
});



