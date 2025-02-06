<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConnectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\NegotiationController;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::post('login',[AuthController::class, 'login'])->name('auth.login');
Route::post('/signup',[AuthController::class, 'signup'])->name('auth.signup');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',[AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/user',[AuthController::class, 'user'])->name('user.index');
    Route::resource('leads', LeadController::class);
    Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/{id}', [AuthController::class, 'update'])->name('profile.update');
    Route::post('/negotiation/store', [NegotiationController::class, 'store'])->name('negotiation.store');
    Route::post('/negotiation/update-sub-status', [NegotiationController::class, 'updateSubStatus'])->name('negotiation.updateSubStatus');
    Route::put('/follow-up/{id}/mark-read', [NegotiationController::class, 'markAsRead']);
    Route::resource('connect', ConnectController::class);    
    Route::get('user_connect', [ConnectController::class, 'Userindex'])->name('user.connect');

});

