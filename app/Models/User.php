<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'alamat',
        'password',
        'telepon',
        'level'
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

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class);
    }

    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class);
    }

    public function scopeFilter($query, array $filters)
    {

        if ($filters['search'] ?? false) {
            $query->where('nama', 'like', '%' . request('search') . '%');
        }
    }
}
