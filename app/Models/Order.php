<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false; /* because UUID (Universally Unique Identifier)*/

    protected $fillable = [
        'total', 'shipping_address','mobile_phone', 'status', 'user_id',
    ];



    public function user(): BelongsTo
    {
        // Define a belongs-to relationship between the Order model and the User model
        return $this->belongsTo(User::class);
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'unit_price', 'color_id', 'size_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            // Eliminar las relaciones en la tabla pivote
            $order->products()->detach();
        });
    }
}
