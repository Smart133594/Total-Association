<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BaseController;

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
Route::post('/login', [BaseController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/health', function (Request $request) {
        return $request->user();
    });
    Route::post('/clock-state', [BaseController::class, 'clockState']);
    Route::post('/clock-update', [BaseController::class, 'clockUpdate']);
});
