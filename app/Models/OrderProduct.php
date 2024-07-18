<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity', 'unit_price', 'color', 'size', 'products_id', 'orders_id',
    ];

//    public function order(): BelongsTo
//    {
//        // Define a belongs-to relationship between the OrderProduct model and the Order model
//        return $this->belongsTo(Order::class);
//    }
//
//    public function product(): BelongsTo
//    {
//        // Define a belongs-to relationship between the OrderProduct model and the Product model
//        return $this->belongsTo(Product::class);
//    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'products_id');
    }


}
