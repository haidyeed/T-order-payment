<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['status'];

    protected $guarded = ['user_id', 'total'];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_products', 'order_id', 'product_id')->withPivot('quantity', 'price');
    }
}
