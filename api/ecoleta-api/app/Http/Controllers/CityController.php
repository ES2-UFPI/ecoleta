<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show(int $city)
    {
        $city = City::where('id', $city)->first();
        if (is_null($city)) {
            return $this->sendError('Cidade não encontrada.');
        }

        return $this->sendResponse(['city' => $city], 'Cidade encontrada com sucesso!');
    }
}
