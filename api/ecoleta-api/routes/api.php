<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StateController;
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

Route::get('/city/{city}', [CityController::class, 'show']);
Route::get('/state/{state}', [StateController::class, 'show']);

Route::prefix('admin')->group(function () {//middleware(['auth:sanctum'])->
    // rotas da região
    Route::resource('region', RegionController::class);
    Route::get('/region/city/{city}', [RegionController::class, 'findRegionsByCity']);
});
