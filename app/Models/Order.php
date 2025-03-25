<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $guarded= [];

    public function plants()
    {
        return $this->belongsToMany(Plant::class, 'order_plant')
                    ->using(OrderPlant::class)
                    ->withPivot(['quantity', 'price_at_order'])
                    ->withTimestamps();
    }
}
