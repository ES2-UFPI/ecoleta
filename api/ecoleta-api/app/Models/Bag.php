<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    use HasFactory;

    protected $table = 'bags';

    protected $fillable = [
        'user_id', 'collect_point_id', 'discarded',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function collectPoint()
    {
        return $this->belongsTo(CollectPoint::class, 'collect_point_id', 'id');
    }

    public function item()
    {
        return $this->hasMany(Item::class, 'bag_id', 'id');
    }
}
