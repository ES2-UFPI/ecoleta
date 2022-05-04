<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    use HasFactory;

    protected $table = 'collection_items';

    protected $fillable = [
        'collect_point_id', 'title',
    ];

    public function collectPoint()
    {
        return $this->belongsTo(CollectPoint::class, 'collect_point_id', 'id');
    }

    public function item()
    {
        return $this->hasMany(Item::class, 'item_id', 'id');
    }

    public function delete()
    {
        if (!is_null($this->item()->first()) || !is_null($this->collectPoint()->first()))
            return false;

        parent::delete();

        return true;
    }
}
