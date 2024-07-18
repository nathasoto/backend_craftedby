<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'street',
        'city',
        'postal_code',
        'country',
    ];

    public function user(): BelongsTo
    {
        // Define a belongs-to relationship between the Address model and the User model
        return $this->belongsTo(User::class);
    }
}
