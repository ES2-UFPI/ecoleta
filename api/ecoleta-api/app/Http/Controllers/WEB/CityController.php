<?php

namespace App\Http\Controllers\WEB;

use App\Models\City;
use App\Http\Controllers\Controller;

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
