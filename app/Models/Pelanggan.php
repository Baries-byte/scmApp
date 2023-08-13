<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $fillable = ['nama', 'alamat', 'telpon'];

    public function scopeFilter($query, array $filters){
        if ($filters['search'] ?? false){
            $query->where('nama', 'like', '%' . request('search') . '%');
        }
    }

    // public function penjualan(): HasMany
    // {
    //     return $this->hasMany(Penjualan::class);
    // }
}
