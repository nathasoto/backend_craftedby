<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens,HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'email_verified_at', 'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function product(): HasMany
    {
        // Define a one-to-many relationship with the Product model
        return $this->hasMany(Product::class);
    }

    public function role(): BelongsToMany
    {
        // Define a many-to-many relationship with the Role model
        return $this->belongsToMany(Role::class);
    }

    public function order(): HasMany
    {
        // Define a one-to-many relationship with the Order model
        return $this->hasMany(Order::class);
    }
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Eliminar todas las órdenes asociadas al usuario
            $user->order()->each(function ($order) {
                $order->delete();
            });

            // Eliminar todas las direcciones asociadas al usuario
            $user->addresses()->each(function ($address) {
                $address->delete();
            });
        });
    }
}
