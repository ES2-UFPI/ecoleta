<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegion;
use App\Http\Requests\UpdateRegion;
use App\Models\Region;
use App\Models\State;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.region.index', [
            'regions' => Region::paginate(15),
            'message' => 'Regiões encontradas'
        ]);
    }

    public function create()
    {
        return view('dashboard.region.create', [
            'states' => State::all()
        ]);
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

        return redirect()->route('dashboard.region.show', ['region' => $region->id]);
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

        return view('dashboard.region.update', [
            'region' => $region,
            'states' => State::all(),
            'message' => 'Região encontrada com sucesso!'
        ]);
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

        return redirect()->route('dashboard.region.show', ['region' => $region]);
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
        return redirect()->route('dashboard.region.index')->withErrors('Região não pode ser excluída pois há dados vinculados a essa região');

        return redirect()->route('dashboard.region.index');
    }
}
