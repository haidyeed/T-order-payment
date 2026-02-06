<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders_products extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_id');
    }
}
