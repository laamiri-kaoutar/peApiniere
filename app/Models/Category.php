<?php

namespace App\Models;

use App\Models\Plant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $fillable= ['name'];
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function plants(){
        return $this->hasMany(Plant::class , 'category_id');
    }

}
