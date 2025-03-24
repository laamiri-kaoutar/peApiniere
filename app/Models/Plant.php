<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plant extends Model
{
    /** @use HasFactory<\Database\Factories\PlantFactory> */
    use HasFactory;
    protected $fillable= [
                        'category_id',
                        'description',
                        'slug',
                        'name',
                        'price',
                     ];
    protected $sluggable = 'name';

    public static function boot(){
        parent::boot();
        static::saving(function (self $post){
            $post->slug =Str::slug($post->{$post->sluggable});
        });

    }

    // public function getRouteKeyName()
    // {
    //     return 'slug'; 
    // }

    public function category(){
        return $this->belongsTo(Category::class , 'category_id');
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_plant')
                    ->using(OrderPlant::class)
                    ->withPivot(['quantity', 'price_at_order'])
                    ->withTimestamps();
    }

}
