<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectPoint extends Model
{
    use HasFactory;

    protected $table = 'collect_points';

    protected $fillable = [
        'region_id', 'title',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
