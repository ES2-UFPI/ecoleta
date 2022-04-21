<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagRescue extends Model
{
    use HasFactory;

    protected $table = 'bag_rescues';

    protected $fillable = [
        'company_id', 'bag_id', 'recue',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id', 'id');
    }

    public function bag()
    {
        return $this->belongsTo(Bag::class, 'bag_id', 'id');
    }
}
