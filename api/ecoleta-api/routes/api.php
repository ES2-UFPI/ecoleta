<?php

use App\Http\Controllers\BagController;
use App\Http\Controllers\BagRescueController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CollectionItemController;
use App\Http\Controllers\CollectPointController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

Route::get('/city/{city}', [CityController::class, 'show']);
Route::get('/state/{state}', [StateController::class, 'show']);
Route::get('/states', [StateController::class, 'index']);

//middleware(['auth:sanctum'])->
Route::prefix('admin')->group(function () {
    // rotas da região
    Route::resource('region', RegionController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::get('/region/city/{city}', [RegionController::class, 'findRegionsByCity']);

    // rotas dos pontos de coleta
    Route::resource('collect_point', CollectPointController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::get('/collect_point/region/{region}', [CollectPointController::class, 'showCollectPointsByRegionID']);
    Route::get('/collect_point/search/{queryItem}', [CollectPointController::class, 'showCollectPointsByQueryItem']);

    // rotas dos items de um ponto de coleta
    Route::resource('collectionItem', CollectionItemController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::get('/collectionItem/collectPoint/{region}', [CollectionItemController::class, 'showCollectionItensByCollectPointID']);

    // rotas da sacola de descarte
    Route::resource('bag', BagController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::get('/bags/pending', [BagController::class, 'listAllBagPendding']);
    Route::get('/bags/finished', [BagController::class, 'listAllBagFinished']);
    Route::get('/bags/finished/{collectPoint}', [BagController::class, 'listAllBagFinishedByCollectPoint']);

    // rotas dos items de um item de ponto de coleta(itens da sacola de descarte)
    Route::get('/item/{collectionItem}', [ItemController::class, 'listAllquantity']);

    // rotas de resgate de sacola de descarte
    Route::resource('bag-rescue', BagRescueController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::get('/bag-rescue/rescues/finished', [BagRescueController::class, 'listAllBagRescues']);
    Route::get('/bag-rescue/rescues/pending', [BagRescueController::class, 'listAllBagPending']);
});
