<?php

use App\Http\Controllers\WEB\CollectionItemController;
use App\Http\Controllers\WEB\CollectPointController;
use App\Http\Controllers\WEB\DashboardController;
use App\Http\Controllers\WEB\RegionController;
use App\Http\Controllers\WEB\StateController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [DashboardController::class, 'login'])->name('login');

Route::get('cidades/{state}', [StateController::class, 'show'])->name('state.cities');

Route::prefix('dashboard')->group(function () {
    Route::get('home', [DashboardController::class, 'home'])->name('dashboard.index');

    // rotas da regiao
    Route::get('regiao', [RegionController::class, 'index'])->name('dashboard.region.index');
    Route::get('regiao/cadastrar', [RegionController::class, 'create'])->name('dashboard.region.create');
    Route::post('regiao/cadastrar/do', [RegionController::class, 'store'])->name('dashboard.region.store');
    Route::get('regiao/{region}/visualizar', [RegionController::class, 'show'])->name('dashboard.region.show');
    Route::put('regiao/{region}/atualizar/do', [RegionController::class, 'update'])->name('dashboard.region.update');
    Route::delete('regiao/{region}/remover', [RegionController::class, 'destroy'])->name('dashboard.region.destroy');

    // rotas do ponto de coleta
    Route::get('ponto-de-coleta', [CollectPointController::class, 'index'])->name('dashboard.collectpoint.index');
    Route::get('ponto-de-coleta/cadastrar', [CollectPointController::class, 'create'])->name('dashboard.collectpoint.create');
    Route::post('ponto-de-coleta/cadastrar/do', [CollectPointController::class, 'store'])->name('dashboard.collectpoint.store');
    Route::get('ponto-de-coleta/{collectPoint}/visualizar', [CollectPointController::class, 'show'])->name('dashboard.collectpoint.show');
    Route::put('ponto-de-coleta/{collectPoint}/atualizar/do', [CollectPointController::class, 'update'])->name('dashboard.collectpoint.update');
    Route::delete('ponto-de-coleta/{collectPoint}/remover', [CollectPointController::class, 'destroy'])->name('dashboard.collectpoint.destroy');

    // rotas dos itens de ponto de coleta
    Route::get('item', [CollectionItemController::class, 'index'])->name('dashboard.collectitem.index');
    Route::get('item/cadastrar', [CollectionItemController::class, 'create'])->name('dashboard.collectitem.create');
    Route::post('item/cadastrar/do', [CollectionItemController::class, 'store'])->name('dashboard.collectitem.store');
    Route::get('item/{collectionItem}/visualizar', [CollectionItemController::class, 'show'])->name('dashboard.collectitem.show');
    Route::put('item/{collectionItem}/atualizar/do', [CollectionItemController::class, 'update'])->name('dashboard.collectitem.update');
    Route::delete('item/{collectionItem}/remover', [CollectionItemController::class, 'destroy'])->name('dashboard.collectitem.destroy');
});
