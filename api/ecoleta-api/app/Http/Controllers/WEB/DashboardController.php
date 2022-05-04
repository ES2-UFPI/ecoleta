<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\CollectionItem;
use App\Models\CollectPoint;
use App\Models\Item;
use App\Models\Region;

class DashboardController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function home()
    {
        $countRegions = Region::count();
        $countCollectPoints = CollectPoint::count();
        $countCollectionItems = CollectionItem::count();

        $mostDescartedItems = Item::all()->groupBy('item_id')->take(3);
        $collectionItem = [];
        $count = 0;
        foreach($mostDescartedItems as $item){
            if($count === 0) $color = 'text-primary';
            if($count === 1) $color = 'text-success';
            if($count === 2) $color = 'text-info';
            $count++;
            array_push($collectionItem, [
                'color' => $color,
                'qtd' => $item,
                'collectionItem' => $item[0]->collectionItem()->first()
            ]);
        }

        $lastTwelveRegions = Region::take(3)->get();
        $twelveRegions = [];
        foreach($lastTwelveRegions as $item){
            array_push($twelveRegions, [
                'region' => $item,
                'qtd' => $item->collectPoint()->count(),
            ]);
        }

        return view('dashboard.home.index', [
            'countRegions' => $countRegions,
            'countCollectPoints' => $countCollectPoints,
            'countCollectionItems' => $countCollectionItems,
            'mostCollecionItems' => $collectionItem,
            'lastTwelveRegions' => $twelveRegions,
        ]);
    }
}
