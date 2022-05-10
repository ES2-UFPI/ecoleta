<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBag;
use App\Http\Requests\UpdateBag;
use App\Http\Resources\ItemsByBag;
use App\Models\Bag;
use App\Models\CollectPoint;
use App\Models\Item;

class BagController extends Controller
{
    /**
     * Listar todas as sacolas pendentes de um ponto de coleta
     */
    public function listAllBagPendding()
    {
        $bags = Bag::where('discarded', false)->where('user_id', 1)->get();

        return $this->sendResponse(['bags' => ItemsByBag::collection($bags)], 'Sacola de descarte encontradas');
    }

    /**
     * Listar todas as sacolas finalizadas de um ponto de coleta (que foram resgatadas por uma empresa)
     */
    public function listAllBagFinished()
    {
        $bags = Bag::where('discarded', true)->where('user_id', 1)->get();

        return $this->sendResponse(['bags' => ItemsByBag::collection($bags)], 'Sacola de descarte encontradas');
    }

    public function listAllBagFinishedByCollectPoint($collectPoint)
    {
        $collectPoint = CollectPoint::where('id', $collectPoint)->first();
        if (is_null($collectPoint)) {
            return $this->sendError('Ponto de coleta não encontrado.');
        }

        $bags = Bag::where('discarded', true)->where('collect_point_id', $collectPoint->id)->get();

        return $this->sendResponse(['bags' => ItemsByBag::collection($bags)], 'Sacola de descarte encontradas');
    }

    /**
     * cadastrar sacola de descarte em um ponto de coleta
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBag $request)
    {
        // verificações
        if (count($request->item) !== count($request->quantity))
            return $this->sendError('Informe a quantidade de cada item na sacola.');

        $bag = new Bag();
        $bag->user_id = $request->user_id;
        $bag->collect_point_id = $request->collect_point_id;
        $bag->discarded = false;
        $bag->save();

        // salvando items
        foreach ($request->item as $key => $collection_item) {
            $item = new Item();
            $item->bag_id = $bag->id;
            $item->item_id = $collection_item;
            $item->quantity = $request->quantity[$key];
            $item->save();
        }

        return $this->sendResponse(['bag' => $bag], 'Sacola de descarte cadastrada com sucesso!');
    }

    /**
     * Visualizar uma sacola pelo id.
     *
     * @param  \App\Models\Bag  $bag
     * @return \Illuminate\Http\Response
     */
    public function show(int $bag)
    {
        $bag = Bag::where('id', $bag)->first();
        if (is_null($bag)) {
            return $this->sendError('Sacola de descarte não encontrado.');
        }

        return $this->sendResponse(['bag' => $bag], 'Sacola de descarte encontrada com sucesso!');
    }

    /**
     * Finalizar/reabrir sacola de descarte
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bag  $bag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBag $request, int $bag)
    {
        $bag = Bag::where('id', $bag)->first();
        if (is_null($bag))
            return $this->sendError('Sacola de descarte não encontrado.');

        if (!$request->discarded)
            return $this->sendError('Você não pode desfazer o descarte de uma sacola.');

        $bag->discarded = $request->discarded;
        $bag->save();

        return $this->sendResponse(['bag' => $bag], 'Sacola de descarte atualizado com sucesso!');
    }

    /**
     * Deletar sacola de descarte.
     * Só pode deletar se a sacola ainda estiver pendente.
     *
     * Caso a sacola não seja finaizada em 15 dias, o sistema irá deletar a sacola.
     *
     * @param  \App\Models\Bag  $bag
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $bag)
    {
        $bag = Bag::where('id', $bag)->first();
        if (is_null($bag))
            return $this->sendError('Sacola de descarte não encontrado.');

        if ($bag->discarded)
            return $this->sendError('Você não pode excluir uma sacola já descartada.');

        if (!$bag->discarded)
            $bag->delete();

        return $this->sendResponse([], 'Sacola de descarte excluída com sucesso!');
    }
}
