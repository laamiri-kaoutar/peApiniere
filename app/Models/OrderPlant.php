<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderPlant extends Pivot
{
    protected $table = 'order_plant';
    protected $fillable = ['order_id', 'plant_id', 'quantity', 'price_at_order'];
    public $timestamps = true;
}

