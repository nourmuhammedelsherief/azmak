<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\Site\HomeController;
use \App\Http\Controllers\Api\Site\HotelInformationController;
use \App\Http\Controllers\Api\Site\HotelOurServiceController;
use \App\Http\Controllers\Api\Site\HotelNearServiceController;

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
Route::get('/check-hotel-status/{id1?}/{id2?}', [\App\Http\Controllers\Api\HotelController\SubscriptionController::class , 'check_status'])->name('checkHotelStatus');
Route::group(['middleware' => ['cors', 'localization']], function () {

});
