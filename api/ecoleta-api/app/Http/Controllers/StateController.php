<?php

namespace App\Http\Controllers;

use App\Http\Resources\CitiesByState;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function show(int $state)
    {
        $state = State::where('id', $state)->first();
        if (is_null($state)) {
            return $this->sendError('Estado não encontrado.');
        }

        return $this->sendResponse(['state' => new CitiesByState($state)], 'Estado encontrado com sucesso!');
    }
}
