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
}
