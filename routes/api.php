<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'json'], function() {
    Route::post('register', [RegistrationController::class, 'register'])->name('register');
    Route::get('verify_email', [RegistrationController::class, 'verifyEmail'])->name('verifyEmail');
});

