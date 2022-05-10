<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegion;
use App\Http\Requests\UpdateRegion;
use App\Models\Region;

class RegionController extends Controller
{
    public function findRegionsByCity(int $city)
    {
        $regions = Region::where('city_id', $city)->get();
        if (is_null($regions)) {
            return $this->sendError('Nenhuma região foi encontrada.');
        }

        return $this->sendResponse(['regions' => $regions], 'Regiões encontrada com sucesso!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(['regions' => Region::paginate(15)], 'Regiões encontradas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegion $request)
    {
        $region = new Region();
        $region->city_id = $request->city_id;
        $region->title = $request->title;
        $region->save();

        return $this->sendResponse(['region' => $region], 'Região cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(int $region)
    {
        $region = Region::where('id', $region)->first();
        if (is_null($region)) {
            return $this->sendError('Região não encontrada.');
        }

        return $this->sendResponse(['region' => $region], 'Região encontrada com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegion $request, int $region)
    {
        $region = Region::where('id', $region)->first();
        if (is_null($region)) {
            return $this->sendError('Região não encontrada.');
        }

        if ($request->has('city_id'))
            $region->city_id = $request->city_id;
        $region->title = $request->title;
        $region->save();

        return $this->sendResponse(['region' => $region], 'Região atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $region)
    {
        $region = Region::where('id', $region)->first();
        if (is_null($region)) {
            return $this->sendError('Região não encontrada.');
        }

        if (!$region->delete())
            return $this->sendError('Região não pode ser excluída pois há dados vinculados a essa região');

        return $this->sendResponse([], 'Região excluída com sucesso!');
    }
}
