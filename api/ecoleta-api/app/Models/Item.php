<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'bag_id', 'item_id', 'quantity'
    ];

    // collection collectionItem
    public function collectionItem()
    {
        return $this->belongsTo(CollectionItem::class, 'item_id', 'id');
    }

    public function bag()
    {
        return $this->belongsTo(Bag::class, 'bag_id', 'id');
    }
}
