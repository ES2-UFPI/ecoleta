<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionItem as ResourcesCollectionItem;
use App\Models\CollectionItem;

class ItemController extends Controller
{
    /**
     * Listar quantidade de itens de um item de um ponto de coleta
     */
    public function listAllquantity(int $collectionItem)
    {
        $collectionItem = CollectionItem::where('id', $collectionItem)->first();
        if (is_null($collectionItem)) {
            return $this->sendError('Item de ponto de coleta não encontrado.');
        }

        return $this->sendResponse(['collectionItem' => ResourcesCollectionItem::collection($collectionItem->item()->get())], 'Item encotrado');
    }
}
