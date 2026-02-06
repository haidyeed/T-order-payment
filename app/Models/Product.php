<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'price',
        'order',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('products.id', 'desc');
        });
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_products', 'product_id', 'order_id')->withPivot('quantity', 'price');

    }
}
