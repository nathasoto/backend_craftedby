<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Size extends Model
{
    use HasFactory;
    use HasUuids;
    public $incrementing = false; /* because UUID (Universally Unique Identifier)*/
    protected $fillable = ['name'];

    public function products(): BelongsToMany
    {
        // Define a many-to-many relationship between the User model and the Product model
        return $this->belongsToMany(Product::class, 'product_size');
    }
}
