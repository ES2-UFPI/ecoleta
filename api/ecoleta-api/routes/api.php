<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Models\Region;
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

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    // rotas da região
    Route::resource('region', Region::class);
    Route::get('/region/city/{city}', [Region::class, 'findRegionsByCity']);
});
