<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBagRescue;
use App\Http\Requests\UpdateBagRescue;
use App\Http\Resources\ItemsByBag;
use App\Http\Resources\ItemsByBagRescue;
use App\Models\Bag;
use App\Models\BagRescue;
use Illuminate\Http\Request;

class BagRescueController extends Controller
{
    /**
     * Listar todas as sacolas resgatadas de um ponto de coleta
     */
    public function listAllBagRescues()
    {
        $bags = BagRescue::where('recue', true)->where('company_id', 2)->get(); // auth()->user()->id

        return $this->sendResponse(['bags' => ItemsByBagRescue::collection($bags)], 'Sacolas já finalizadas encontradas');
    }

    /**
     * Listar todas as sacolas pendentes a serem resgatadas de um ponto de coleta
     */
    public function listAllBagPending()
    {
        $bags = BagRescue::where('recue', false)->where('company_id', 2)->get(); // auth()->user()->id

        return $this->sendResponse(['bags' => ItemsByBagRescue::collection($bags)], 'Sacolas pendentes encontradas');
    }

    /**
     * cadastrar resgate de sacola por uma empresa.
     * Uma empresa pode fazer a criação de um resgate de sacola, porem se ela nao finalizar em 15 dias, a sacola sera resetada para o ponto de coleta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBagRescue $request)
    {
        $bag = Bag::where('id', $request->bag_id)->first();
        if (!$bag->discarded)
            return $this->sendError('Essa sacola ainda não foi descartada pelo cliente. Aguarde até o mesmo realizar o descarte no ponto de coleta.');

        $bagRescue = BagRescue::where('bag_id', $request->bag_id)->first();
        if (!empty($bagRescue) && $bagRescue->recue){
            return $this->sendError('Essa sacola já foi resgatada por uma empresa.');
        }

        if(!empty($bagRescue) && !$bagRescue->recue){
            return $this->sendError('Essa sacola já foi resgatada por uma empresa mas ainda está pendente. Caso a empresa requerente não resgate em 15 dias, você poderá refazer o pedido de resgate.');
        }

        $bagRescue = new BagRescue();
        $bagRescue->company_id = $request->company_id;
        $bagRescue->bag_id = $request->bag_id;
        $bagRescue->recue = false;
        $bagRescue->save();

        return $this->sendResponse(['bagRescue' => $bagRescue], 'Resgate de sacola cadastrada com sucesso!');
    }

    /**
     * Listar uma sacola resgatada.
     *
     * @param  \App\Models\BagRescue  $bagRescue
     * @return \Illuminate\Http\Response
     */
    public function show(int $bagRescue)
    {
        $bagRescue = BagRescue::where('id', $bagRescue)->first();
        if (is_null($bagRescue))
            return $this->sendError('Sacola resgatada não encontrada.');

        return $this->sendResponse(['bagRescue' => $bagRescue], 'Sacola resgatada encontrada com sucesso!');
    }

    /**
     * Atualizar resgate de sacola.
     * A empresa não pode reabrir uma sacola já resgatada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BagRescue  $bagRescue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBagRescue $request, int $bagRescue)
    {
        $bagRescue = BagRescue::where('id', $bagRescue)->first();
        if (is_null($bagRescue))
            return $this->sendError('Sacola resgatada não encontrada.');

        if (!$request->recue)
            return $this->sendError('Você não pode reabrir um resgate de uma sacola.');

        $bagRescue->recue = $request->recue;
        $bagRescue->save();

        return $this->sendResponse(['bagRescue' => $bagRescue], 'Resgate de sacola atualizada com sucesso!');
    }

    /**
     * Deletar resgate de sacola.
     * A empresa só pode executar essa ação caso a sacola ainda esteja pendente.
     *
     * @param  \App\Models\BagRescue  $bagRescue
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $bagRescue)
    {
        $bagRescue = BagRescue::where('id', $bagRescue)->first();
        if (is_null($bagRescue))
            return $this->sendError('Sacola resgatada não encontrada.');

        if ($bagRescue->recue)
            return $this->sendError('Você não pode excluir um resgate de sacola já finalizada.');

        $bagRescue->delete();

        return $this->sendResponse([], 'Resgate de sacola excluída com sucesso!');
    }
}
