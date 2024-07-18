<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false; /* because UUID (Universally Unique Identifier)*/

    protected $fillable = [
        'name', 'history', 'production_methods', 'specialties', 'zip_code', 'description', 'user_id', 'theme_id',
    ];

    public function theme(): BelongsTo
    {
        // Define a belongs-to relationship between the Shop model and the Theme model
        return $this->belongsTo(Theme::class);
    }

    public function user(): BelongsTo
    {
        // Define a belongs-to relationship between the Shop model and the User model
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        // Define a one-to-many relationship between the Shop model and the Product model
        return $this->hasMany(Product::class);
    }
}
