<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectPoint extends Model
{
    use HasFactory;

    protected $table = 'collect_points';

    protected $fillable = [
        'region_id', 'title', 'latitude', 'longitude'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function collectionItem()
    {
        return $this->hasMany(CollectionItem::class, 'collect_point_id', 'id');
    }

    public function delete()
    {
        if (!is_null($this->collectionItem()->first()) || !is_null($this->region()->first()))
            return false;

        parent::delete();

        return true;
    }
}
