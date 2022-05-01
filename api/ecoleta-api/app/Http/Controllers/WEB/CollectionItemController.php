<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCollectionItem;
use App\Http\Requests\UpdateCollectionItem;
use App\Models\CollectionItem;
use App\Models\CollectPoint;

class CollectionItemController extends Controller
{
    public function showCollectionItensByCollectPointID(int $collectionPoint)
    {
        $collectionPoint = CollectPoint::where('id', $collectionPoint)->first();
        if (is_null($collectionPoint)) {
            return $this->sendError('Ponto de coleta não encontrado.');
        }

        return view('dashboard.collectitem.showbycollectpoint', [
            'collectionItems' => $collectionPoint->collectionItem()->get(),
            'message' => 'Items de ponto de coleta encontrados',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.collectitem.index', [
            'collectionItems' => CollectionItem::paginate(15),
            'message' => 'Items de ponto de coleta encontrados'
        ]);
    }

    public function create()
    {
        return view('dashboard.collectitem.create', [
            'CollectPoints' => CollectPoint::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectionItem $request)
    {
        $collectionItem = new CollectionItem();
        $collectionItem->collect_point_id = $request->collect_point_id;
        $collectionItem->title = $request->title;
        $collectionItem->save();

        return redirect()->route('dashboard.collectitem.show', ['collectionItem' => $collectionItem->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollectionItem  $collectionItem
     * @return \Illuminate\Http\Response
     */
    public function show(int $collectionItem)
    {
        $collectionItem = CollectionItem::where('id', $collectionItem)->first();
        if (is_null($collectionItem)) {
            return $this->sendError('Item de ponto de coleta não encontrado.');
        }

        return view('dashboard.collectitem.update', [
            'collectionItem' => $collectionItem,
            'CollectPoints' => CollectPoint::all(),
            'message' => 'Item de ponto de coleta encontrado com sucesso!'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollectionItem  $collectionItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCollectionItem $request, int $collectionItem)
    {
        $collectionItem = CollectionItem::where('id', $collectionItem)->first();
        if (is_null($collectionItem)) {
            return $this->sendError('Item de ponto de coleta não encontrado.');
        }

        if ($request->has('collect_point_id'))
            $collectionItem->collect_point_id = $request->collect_point_id;
        $collectionItem->title = $request->title;
        $collectionItem->save();

        return redirect()->route('dashboard.collectitem.show', ['collectionItem' => $collectionItem->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollectionItem  $collectionItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $collectionItem)
    {
        $collectionItem = CollectionItem::where('id', $collectionItem)->first();
        if (is_null($collectionItem)) {
            return $this->sendError('Item de ponto de coleta não encontrado.');
        }

        $collectionItem->delete();

        return redirect()->route('dashboard.collectitem.index');
    }
}
