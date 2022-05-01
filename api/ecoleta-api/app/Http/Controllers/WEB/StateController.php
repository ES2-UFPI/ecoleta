<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesByState;
use App\Models\State;

class StateController extends Controller
{
    public function index(){
        $states = State::all();
        return $this->sendResponse(['states' => $states], 'Estados encontrados com sucesso!');
    }

    public function show(int $state)
    {
        $state = State::where('id', $state)->first();
        if (is_null($state)) {
            return $this->sendError('Estado não encontrado.');
        }

        return $this->sendResponse(['state' => new CitiesByState($state)], 'Estado encontrado com sucesso!');
    }
}
