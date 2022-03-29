<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectPoints;
use App\Http\Requests\UpdateCollectPoints;
use App\Models\CollectPoint;
use App\Models\Region;

class CollectPointController extends Controller
{
    public function showCollectPointsByRegionID(int $region)
    {
        $region = Region::where('id', $region)->first();
        if (is_null($region)) {
            return $this->sendError('Região não encontrada.');
        }

        return $this->sendResponse(['collectPoints' => $region->collectPoint()->get()], 'Pontos de coleta encontrados');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(['collectPoints' => CollectPoint::paginate(15)], 'Pontos de coleta encontrados');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectPoints $request)
    {
        $collectPoint = new CollectPoint();
        $collectPoint->region_id = $request->region_id;
        $collectPoint->title = $request->title;
        $collectPoint->save();

        return $this->sendResponse(['collectPoint' => $collectPoint], 'Ponto de coleta cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollectPoint  $collectPoint
     * @return \Illuminate\Http\Response
     */
    public function show(int $collectPoint)
    {
        $collectPoint = CollectPoint::where('id', $collectPoint)->first();
        if (is_null($collectPoint)) {
            return $this->sendError('Ponto de coleta não encontrado.');
        }

        return $this->sendResponse(['collectPoint' => $collectPoint], 'Ponto de coleta encontrado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollectPoint  $collectPoint
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCollectPoints $request, int $collectPoint)
    {
        $collectPoint = CollectPoint::where('id', $collectPoint)->first();
        if (is_null($collectPoint)) {
            return $this->sendError('Ponto de coleta não encontrado.');
        }

        if ($request->has('region_id'))
            $collectPoint->region_id = $request->region_id;
        $collectPoint->title = $request->title;
        $collectPoint->save();

        return $this->sendResponse(['collectPoint' => $collectPoint], 'Ponto de Coleta cadastrado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollectPoint  $collectPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $collectPoint)
    {
        $collectPoint = CollectPoint::where('id', $collectPoint)->first();
        if (is_null($collectPoint)) {
            return $this->sendError('Ponto de coleta não encontrado.');
        }

        $collectPoint->delete();

        return $this->sendResponse([], 'Ponto de coleta excluído com sucesso!');
    }
}
