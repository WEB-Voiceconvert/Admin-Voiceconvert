<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientAlatController;
use App\Http\Controllers\API\ClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('is_auth')->group(function () {
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('with_api_key')->group(function () {
    Route::get('cek', [ClientAlatController::class, 'getMember']);
});

Route::get('product', [ClientController::class, 'allProducts']);
Route::get('product/{id}', [ClientController::class, 'getProduct']);
Route::get('berita', [ClientController::class, 'allBeritas']);
Route::get('berita/{id}', [ClientController::class, 'getBerita']);
Route::get('alat', [ClientController::class, 'allAlats']);
Route::get('alat/{id}', [ClientController::class, 'getAlat']);
Route::get('event', [ClientController::class, 'allEvents']);
Route::get('event-category', [ClientController::class, 'allEventCategories']);
Route::get('event/{id}', [ClientController::class, 'getEvent']);
Route::get('gallery', [ClientController::class, 'allGalleries']);
Route::get('gallery/{id}', [ClientController::class, 'getGallery']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('register-check-otp', [AuthController::class, 'registerOtpCheck']);
Route::post('register-resend-otp', [AuthController::class, 'registerOtpResend']);
