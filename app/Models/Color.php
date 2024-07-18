<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = ['name'];

    public function products()
    {
        // Define a many-to-many relationship between the Shop model and the Product model
        return $this->belongsToMany(Product::class, 'color_product');
    }
}
