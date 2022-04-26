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

    // buscar cliente
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // buscar ponto de coleta vinculado
    public function collectPoint()
    {
        return $this->belongsTo(CollectPoint::class, 'collect_point_id', 'id');
    }

    // buscar items do ponto de coleta
    public function item()
    {
        return $this->hasMany(Item::class, 'bag_id', 'id');
    }

    // metodo de execucao em cascata apos chamar metodo delete()
    public static function boot()
    {
        parent::boot();

        self::deleting(function (Bag $bag) {
            // remove items
            $bag->item()->delete();
        });
    }
}
