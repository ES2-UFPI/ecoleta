<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
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

        return view('dashboard.collectpoint.showbyregion', [
            'collectPoints' => $region->collectPoint()->get(),
            'message' => 'Pontos de coleta encontrados',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.collectpoint.index', [
            'collectPoints' => CollectPoint::paginate(15),
            'message' => 'Pontos de coleta encontrados'
        ]);
    }

    public function create()
    {
        return view('dashboard.collectpoint.create', [
            'regions' => Region::all()
        ]);
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

        return redirect()->route('dashboard.collectpoint.show', ['collectPoint' => $collectPoint->id]);
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

        return view('dashboard.collectpoint.update', [
            'collectPoint' => $collectPoint,
            'regions' => Region::all(),
            'message' => 'Ponto de coleta encontrado com sucesso!'
        ]);
    }

    public function items(int $collectPoint)
    {
        $collectPoint = CollectPoint::where('id', $collectPoint)->first();
        if (is_null($collectPoint)) {
            return $this->sendError('Ponto de coleta não encontrado.');
        }

        return view('dashboard.collectpoint.items', [
            'collectPoint' => $collectPoint,
            'message' => 'Ponto de coleta encontrado com sucesso!'
        ]);
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

        return redirect()->route('dashboard.collectpoint.show', ['collectPoint' => $collectPoint->id]);
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

        if (!$collectPoint->delete())
            return redirect()->route('dashboard.collectpoint.index')->withErrors('Erro na exclusão');

        return redirect()->route('dashboard.collectpoint.index');
    }
}
