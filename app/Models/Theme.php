<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false; /* because UUID (Universally Unique Identifier)*/
    protected $fillable = ['name', 'color','font'];

    public function shops(): HasMany
    {
        // Define a one-to-many relationship between the User model and the Shop model
        return $this->hasMany(Shop::class);
    }
}
