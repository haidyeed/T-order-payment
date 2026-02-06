<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Payment extends Model
{

    protected $fillable = ['order_id', 'status', 'method', 'transaction_id']; 
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('payments.id', 'desc');
        });
    }


    public function order() { 
        return $this->belongsTo(Order::class); 
        
    }

}
